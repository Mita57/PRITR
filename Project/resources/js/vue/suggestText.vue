<template>
    <div id="container">
        <h1>Добавление текста</h1>
        <textarea cols="70" placeholder="Введите текст" rows="20" v-model="text"></textarea>
        <p>Длина: {{ getTextLength() }}</p>
        <p>
            Откуда текст: <input type="text" id="textSource" v-model="source" placeholder="Источник">
        </p>
        <p>
            Тема текста: <input type="text" id="texttopic" v-model="topic" placeholder="Тема">
        </p>
        <button @click='sendText()' :disabled="verifyInputs()" id="findText">Предложить текст</button>
    </div>
</template>

<script>
export default {
    name: "suggestText",
    methods: {
        getTextLength() {
            if (this.text.length <= 250) {
                return 'Короткий';
            }
            if (this.text.length <= 400) {
                return 'Средний';
            }
            return 'Длинный'
        },

        verifyInputs() {
            return !(this.text && this.source && this.topic);
        },

        sendText() {
            const lang = /[а-яА-ЯЁё]/.test(this.text) === false ? 'en' : 'ru';

            axios({
                method: 'POST',
                url: 'api/v1/text/postText',
                data: {
                    text: this.text,
                    length: this.getTextLength(),
                    source: this.source,
                    topic: this.topic,
                    lang: lang,
                }
            }).then((response) => {
                location.reload();
            }).catch((response) => {
                console.log(response);
            })
        }
    },
    data: () => {
        return {
            text: '',
            source: '',
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

#textSource {
    width: 390px;
}

#texttopic {
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
}

#findText:hover {
    background-color: #693838;
}

#findText:disabled {
    background-color: #915656;
    color: #c8a4a4;
    cursor: default;
}


textarea {
    display: block;
    margin: 4px auto;

}

h1 {
    margin-top: 0;
}

p {
    font-size: 14pt;
}

</style>
