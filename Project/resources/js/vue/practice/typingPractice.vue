<template>
    <div id="container">
        <h1>Напиши этот текст</h1>
        <div id="textDiv">
            <span id="goodTextSpan">{{goodText}}</span><span id="badTextSpan">{{badText}}</span>{{textLeft}}
        </div>
        <input type="text" @input="textThing()" v-model="inputText" id="textInput" placeholder="Пиши сюда текст сверху">
    </div>
</template>

<script>
export default {
    name: "typingPractice",
    props: ['text'],
    mounted() {
      this.textLeft = this.text.text;
    },
    data: () => {
        return {
            goodText: '',
            badText: '',
            textLeft: '',
            inputText: '',
            lastGoodChar: 0
        }
    },
    methods: {
        textThing() {

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

#textDiv {
    background-color: #dcdcdc;
    text-align: justify;
    font-size: 14pt;
    padding: 8px;
}

h1 {
    margin-top: 0;
}

#goodTextSpan {
    color: #00961d;
}

#badTextSpan {
    background-color: #6a272f;
    color: #FFFFFF;
}

#textInput {
    width: 594px;
    height: 24px;
    margin-top: 8px;
}


</style>
