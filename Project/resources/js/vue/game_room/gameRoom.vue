<template>
    <div id="container">
        <div id="create" class="bigBtn" @click="createRoom" v-if="firstPage">
            <button>Создать комнату</button>
        </div>
        <div id="join" class="bigBtn" v-if="firstPage">
            Войти в комнату
            <p><input type="text" id="roomIDInput" v-model="roomId" autocomplete="off" placeholder="ID комнаты"></p>
            <button :disabled="!roomId" @click="getRoom">Войти</button>
        </div>

        <create-room v-if="hostingGame" :roomId="roomId" />
        <room-lobby v-if="connectedToGame" :room-id="roomId" />
    </div>
</template>

<script>
import CreateRoom from "./createRoom";
import RoomLobby from "./roomLobby";
import axios from "axios";
export default {
    name: "gameRoom",
    components: {RoomLobby, CreateRoom},
    data: () => {
        return {
            roomId: null,
            connectedToGame: false,
            hostingGame: false,
            firstPage: true
        }

    },

    methods: {
        createRoom() {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token;
            axios({
                method: 'POST',
                url: 'api/v1/room/createRoom'
            }).then((response) => {
                this.hostingGame = true;
                this.firstPage = false;
                this.roomId = response.data.id;
                axios({
                    method: 'GET',
                    url: 'api/v1/room/getRoom',
                    params: {
                        room: this.roomId
                    }
                });
            });
        },

        getRoom() {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token;
            axios({
                method: 'GET',
                url: 'api/v1/room/getRoom',
                params: {
                    room: this.roomId
                }
            }).then((response) => {
                this.firstPage = false;
                this.connectedToGame = true;

            })
        }
    }
}
</script>

<style scoped>

#container {
    width: 600px;
    text-align: center;
    margin: 16px auto auto;
}

.bigBtn {
    background-color: #cdcdcd;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
}

button {
    height: 40px;
    width: 200px;
    background-color: #530000;
    color: #FFFFFF;
    font-size: 14pt;
    border: none;
    transition: 0.3s;
    cursor: pointer;
}

button:hover {
    background-color: #693838;
}

button:disabled {
    background-color: #915656;
    color: #c8a4a4;
    cursor: default;
}

#roomIDInput {
    width: 500px;
    height: 28px;
}

</style>
