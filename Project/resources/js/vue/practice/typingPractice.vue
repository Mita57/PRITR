<template>
    <div id="container">
        <h1>Напиши этот текст</h1>
        <div id="textDiv">
            <span id="goodTextSpan">{{goodText}}</span>{{textLeft}}
        </div>
        <div class="placeholder" :data-placeholder="currWord">
            <input type="text" @input="textThing()" v-model="inputText" id="textInput"
                   :placeholder="raceStarted ? '' : 'Пиши сюда текст сверху'" :disabled="!raceStarted">
        </div>
    </div>
</template>

<script>
export default {
    name: "typingPractice",
    props: ['text'],
    mounted() {
      this.textLeft = this.text.text;
      this.allWords = this.textLeft.split(" ");

      setTimeout(() => {
          this.currWord = this.allWords[this.currWordIndex]
          this.raceStarted = true;
      }, 3000);
    },
    data: () => {
        return {
            goodText: '',
            textLeft: '',
            inputText: '',
            currWord: '',
            currWordIndex: 0,
            raceStarted: false
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

.placeholder
{
    position: relative;
}

.placeholder::after
{
    position: absolute;
    left: 4px;
    top: 12px;
    font-family: "Noto Sans";
    color: rgba(106,101,104,0.6);
    content: attr(data-placeholder);
    pointer-events: none;
    opacity: 0.6;
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
    font-family: "Noto Sans";
    font-size: 12pt;
}


</style>
