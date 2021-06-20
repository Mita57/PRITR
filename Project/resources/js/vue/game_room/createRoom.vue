<template>
    <div>
        <div id="container" v-if="!currGame">
            <h1>Комната</h1>
            <input type="text" id="roomId" readonly :value="roomId">
            <h2>Настройки текста</h2>
            <div id="lang" class="options_field">
                Язык:
                <input type="radio" id="english" name="lang" v-model="lang" value="en" checked>
                <label for="english">Английский</label>

                <input type="radio" id="russian" name="lang" v-model="lang" value="ru">
                <label for="russian">Русский</label>

                <input type="radio" id="any" name="lang" v-model="lang" value="any_lang">
                <label for="any">Любой</label>
            </div>
            <div id="text_length" class="options_field">
                Длина:
                <input type="radio" id="short" name="length" v-model="length" value="smol" checked>
                <label for="short">Короткий</label>

                <input type="radio" id="medium" name="length" v-model="length" value="med">
                <label for="medium">Средний</label>

                <input type="radio" id="long" name="length" v-model="length" value="long">
                <label for="long">Длинный</label>

                <input type="radio" id="any_length" name="length" v-model="length" value="long">
                <label for="any_length">Любой</label>
            </div>
            <div id="topicDiv" class="options_field">
                <label for="topic">Тема</label>
                <input type="text" id="topic" name="topic" placeholder="Темы" v-model="topic"
                       :disabled="this.anyTopicChecked">

                <input type="checkbox" id="any_topic_cb" name="any_topic" value="any" v-model="anyTopicChecked">
                <label for="any_topic_cb">Любая</label>
            </div>
            <button @click="getGame" id="findText" :disabled="verifyInputs()">Начать гонку</button>

        </div>

        <div id="members">
            <h3>В комнате:</h3>
            <p v-for="meme in roomMembers">{{ meme.user[0].username }}</p>
        </div>

        <race-typing :game="currGame" v-if="currGame" v-on:changeSettings="this.currGame = null"
                     v-on:newText="getGame" bts_enabled="true"/>
    </div>
</template>

<script>
import axios from "axios";
import RaceTyping from "../defRace/raceTyping";

export default {
    name: "createRoom",
    components: {RaceTyping},
    props: ['roomId'],

    data: () => {
        return {
            anyTopicChecked: false,
            length: '',
            lang: '',
            topic: '',
            roomMembersChecker: null,
            roomMembers: [],
            currGameId: null,
            currGame: null
        }
    },

    mounted() {
        this.roomMembersChecker = setInterval(this.getRoomMembers, 2000);
    },

    beforeDestroy() {
        clearInterval(this.roomMembersChecker);
    },


    methods: {

        getGame() {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token;
            axios({
                method: 'POST',
                url: 'api/v1/room/nextGame',
                data: {
                    len: this.length,
                    topic: this.topic,
                    lang: this.lang,
                    roomId: this.roomId
                }
            }).then((response) => {
                axios({
                    method: 'GET',
                    url: 'api/v1/defaultRace/getRaceByID',
                    params: {
                        gameId: response.data.id
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
            })

        },

        verifyInputs: function verifyInputs() {
            return !(this.length && (this.topic || this.anyTopicChecked) && this.lang);
        },

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

    }


}
</script>

<style scoped>

#container {
    width: 600px;
    text-align: center;
    background-color: #cdcdcd;
    padding: 16px;
    margin: 16px auto auto;
    border-radius: 8px;
}

.options_field {
    border: black 1px solid;
    padding: 8px;
    margin-top: 8px;
}

h1 {
    margin: 0;
}

#topic {
    width: 400px;
}

#findText {
    height: 40px;
    width: 200px;
    background-color: #530000;
    color: #FFFFFF;
    font-size: 14pt;
    border: none;
    transition: 0.3s;
    cursor: pointer;
    font-family: "Noto Sans";
}

#findText:hover {
    background-color: #693838;
}

#findText:disabled {
    background-color: #915656;
    color: #c8a4a4;
    cursor: default;
}

#members {
    background-color: #cdcdcd;
    width: 400px;
    border-radius: 8px;
    float: right;
    position: relative;
    right: -460px;
    top: -350px;
}
</style>
