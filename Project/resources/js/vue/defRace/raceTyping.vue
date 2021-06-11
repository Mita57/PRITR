<template>
    <div id="race">
        <div id="rivalsInfo">
        </div>

        <div id="textContainer">
            <h1>Напиши этот текст {{ !raceStarted ? '(' + secsTillGameStarts.toFixed(1) + ')' : "" }}</h1>
            <h3 v-if="raceStarted">Время: {{ secsEllapsed.toFixed(1) }} сек</h3>
            <div id="textDiv">
                <span id="goodTextSpan">{{ goodText }}</span>{{ textLeft }}
            </div>
            <div class="placeholder" :data-placeholder="currWord">
                <input type="text" @input="textThing()" v-model="inputText" id="textInput"
                       :style="getStyle()" v-if="!gameEnded"
                       :placeholder="raceStarted ? '' : 'Пиши сюда текст сверху'" :disabled="!raceStarted">
            </div>
            <div id="speeds" v-if="raceStarted">
                <div>CPM: {{ Math.round(getCpm()) }}</div>
                <div>WPM: {{ Math.round(getWpm()) }}</div>
                <div>CPS: {{ Math.round(getCps()) }}</div>
                <div>Acc: {{ Math.round(getAcc()) }}</div>
            </div>
            <div id="bts">
                <button @click="$emit('newText')">Новый текст</button>
                <button @click="$emit('changeSettings')">Поменять настройки</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "raceTyping",

    props: ['game'],

    mounted() {
        this.textLeft = this.game.text.text;
        this.allWords = this.textLeft.split(" ");


        this.intervalThing = setInterval(() => {
            if (this.countDown && !this.raceStarted) {
               this.secsTillGameStarts -= 0.1;
            }

            if (this.raceStarted) {
                if (!this.gameEnded) {
                    this.charsEntered += 0.0000000001;
                    this.secsEllapsed += 0.1;
                }
            }
        },)

    },

    data: () => {
        return {
            goodText: '',
            textLeft: '',
            inputText: '',
            currWord: '',
            allWords: [],
            currWordIndex: 0,
            raceStarted: false,
            hasError: false,
            raceBegin: null,
            gameEnded: false,
            charsEntered: 0,
            allCharsEntered: 0,
            secsTillGameStarts: 10,
            intervalThing: null,
            secsEllapsed: 0,
            errors: 0,
            rivals: [],
            countDown: false,
        }
    },
    methods: {
        textThing() {
            const re = new RegExp(this.inputText + '.*');
            if (this.inputText.indexOf(' ') >= 0 && re.test(this.currWord + " ")) {
                this.nextWord();
            }

            if (this.currWordIndex === this.allWords.length - 1 && this.currWord === this.inputText) {
                this.nextWord();
                this.gameOver();
            }

            this.hasError = !(re.test(this.currWord) || this.inputText === '');

            this.allCharsEntered++;


            if (this.hasError) {
                this.errors++;
            }
        },

        getCpm() {
            return this.getCps() * 60;
        },

        getWpm() {
            return this.getCpm() / 5;
        },

        getCps() {
            const secsPassed = (Date.now() - this.raceBegin) / 1000;
            return this.charsEntered / secsPassed;
        },

        getAcc() {
            return 100 - ((this.errors / this.allCharsEntered) * 100);
        },

        getStyle() {
            if (this.hasError) {
                return {
                    backgroundColor: 'tomato'
                };
            }
            return {
                backgroundColor: 'white'
            };
        },

        getGameMembers() {
            axios({
                method: 'GET',
                url: '/api/v1/defaultRace/getGameMembers',
                params: {
                    gameId: this.game.id
                }
            }).then((response) => {
                this.rivals = response.data;
            }).catch((response) => {
                console.log(response);
            });

            if (this.rivals.length >= 2 && !this.countDown) {


                this.countDown = true;

                setTimeout(() => {
                    axios({
                        method: 'POST',
                        url: '/api/v1/defaultRace/startGame',
                        data: {
                            id: this.game.id
                        }
                    });
                }, 5000);

                setTimeout(() => {
                    this.currWord = this.allWords[this.currWordIndex]
                    this.raceBegin = Date.now();
                    this.raceStarted = true;
                }, 10000);

                setTimeout(() => {
                    document.getElementById('textInput').focus();
                }, 10010);
            }
        },

        nextWord() {
            this.goodText += this.allWords[this.currWordIndex] + ' ';
            this.textLeft = this.game.text.text.slice(this.goodText.length);
            this.charsEntered += this.currWord.length;

            this.currWordIndex++;
            this.currWord = this.allWords[this.currWordIndex];
            this.inputText = '';
        },

        gameOver() {
            this.gameEnded = true;
            clearInterval(this.intervalThing);
        }
    }
}
</script>

<style scoped>

</style>
