<template>
    <div>
        <div v-if="!currGame">
            <div id="members">
                <h3>В комнате:</h3>
                <p v-for="meme in roomMembers">{{ meme.user[0].username }}</p>
                <h3>Ожидание начала гонки</h3>
            </div>
        </div>

        <race-typing :game="currGame" v-if="currGame" bts_enabled="false"/>
    </div>
</template>

<script>
import axios from "axios";
import RaceTyping from "../defRace/raceTyping";

export default {
    name: "roomLobby",
    components: {RaceTyping},
    props: ['roomId'],


    data: () => {
        return {
            roomMembersChecker: null,
            roomMembers: [],
            gameStateChecker: null,
            currGameId: null,
            currGame: null
        }
    },

    mounted() {
        this.roomMembersChecker = setInterval(this.getRoomMembers, 2000);
        this.gameStateChecker = setInterval(this.checkGame, 2000);
        this.getRoomMembers();
        this.checkGame();
    },

    methods: {
        getRoomMembers() {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token;
            axios({
                method: 'GET',
                url: 'api/v1/room/getRoomMembers',
                params: {
                    roomId: this.roomId
                }
            }).then((response) => {
                this.roomMembers = response.data;
            })
        },

        checkGame() {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token;
            axios({
                method: 'GET',
                url: 'api/v1/room/checkGame',
                params: {
                    roomId: this.roomId,
                    clientGame: this.currGameId
                }
            }).then((response) => {
                if (!response.data) {
                    return;
                }
                this.currGameId = response.data.id;
                this.connectToGame();
            })
        },

        connectToGame() {
            axios({
                method: 'GET',
                url: 'api/v1/defaultRace/getRaceByID',
                params: {
                    gameId: this.currGameId
                }
            }).then((response) => {
                this.currGame = response.data;
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token;
                axios({
                    method: 'POST',
                    url: 'api/v1/defaultRace/joinGame',
                    data: {
                        gameId: this.currGame.id
                    }
                });
            });
        }
    },

    beforeDestroy() {
        clearInterval(this.roomMembersChecker);
    }
}
</script>

<style scoped>
#members {
    width: 600px;
    text-align: center;
    background-color: #cdcdcd;
    padding: 16px;
    margin: 16px auto auto;
    border-radius: 8px;
}
</style>
