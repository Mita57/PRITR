<template>
    <div id="race">
        <div id="rivalsInfo">
            <div v-for="rival in this.rivals">
                {{ rival.user.username }}: {{ rival.completion }}, CPM : {{ rival.cpm }}
            </div>
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
            <div id="bts" v-if="gameEnded">
                <button @click="$emit('changeSettings')">Поменять настройки</button>
                <button @click="$emit('newText')">Новая игра</button>
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
        this.getGameMembers();


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
        }, 100)

        this.update = setInterval(() => {
            this.getGameMembers();

            if (this.raceStarted) {
                this.sendTextData();
            }

        }, 2000);

        window.onbeforeunload = function () {
            this.startGameAxios();
        }

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
            update: null
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

        sendTextData() {
            axios({
                method: 'POST',
                url: '/api/v1/defaultRace/postTextData',
                data: {
                    gameId: Math.round(this.game.id),
                    cpm: Math.round(this.getCpm()),
                    completion: Math.round((this.charsEntered / this.game.text.text.length) * 100)
                }
            });
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

        startGameAxios() {
            axios({
                method: 'POST',
                url: '/api/v1/defaultRace/startGame',
                data: {
                    id: this.game.id
                }
            });
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
                    this.startGameAxios();
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
            clearInterval(this.update);
            axios({
                method: 'POST',
                url: 'api/v1/defaultRace/gameFinal',
                data: {
                    race_time: this.secsEllapsed,
                    gameId: this.game.id,
                    cpm: this.getCpm(),
                }
            });
        }
    }
}
</script>

<style scoped>
#rivalsInfo {
    width: 600px;
    text-align: left;
    background-color: #cdcdcd;
    padding: 16px;
    margin: 16px auto auto;
    border-radius: 8px;
}

#textContainer {
    width: 600px;
    text-align: center;
    background-color: #cdcdcd;
    padding: 16px;
    margin: 16px auto auto;
    border-radius: 8px;
}

.placeholder {
    position: relative;
}

.placeholder::after {
    position: absolute;
    left: 4px;
    top: 12px;
    font-family: "Noto Sans";
    color: rgba(106, 101, 104, 0.6);
    content: attr(data-placeholder);
    pointer-events: none;
    opacity: 0.6;
}

#textDiv {
    background-color: #f6f6f6;
    text-align: justify;
    font-size: 14pt;
    padding: 8px;
}

h1 {
    margin-top: 0;
}

#goodTextSpan {
    color: #00de2b;
    border-right: black 2px;
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

#speeds {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
}

#bts {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    margin-top: 8px;
}

#bts button {
    height: 40px;
    width: 200px;
    border: none;
    background-color: #530000;
    color: #FFFFFF;
    font-size: 14pt;
    transition: 0.3s;
    cursor: pointer;
}
</style>
