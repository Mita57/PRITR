<template>
    <div id="container">
        <h1>Гонка</h1>
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
        <button @click="findGame" id="findGame" :disabled="verifyInputs()">Найти игру</button>
    </div>
</template>

<script>
export default {
    name: "raceTextSelector",
    methods: {
        findGame() {
            let params = {
                len: this.length,
                lang: this.lang,
                topic: this.anyTopicChecked ? 'any' : this.topic
            };
            this.$emit('findGame', params);
        },
        verifyInputs() {
            return !(this.length && (this.topic || this.anyTopicChecked) && this.lang);
        }
    },
    data: () => {
        return {
            anyTopicChecked: false,
            length: '',
            lang: '',
            topic: '',
        }
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

#findGame {
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

#findGame:hover {
    background-color: #693838;
}

#findGame:disabled {
    background-color: #915656;
    color: #c8a4a4;
    cursor: default;
}

</style>
