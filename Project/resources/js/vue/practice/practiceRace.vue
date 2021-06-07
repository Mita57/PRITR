<template>
    <text-selector v-if="text === null" v-on:textReady="textFound"></text-selector>
    <typing-practice v-else :text="this.text"></typing-practice>
</template>

<script>
import TextSelector from "./textSelector";
import TypingPractice from "./typingPractice";
export default {
name: "practiceRace",
    components: {TypingPractice, TextSelector},
    data: () => {
        return {
            text: {
                "id": 7,
                "text": "If data is a stream resource, the remaining buffer of that stream will be copied to the specified file. This is similar with using stream_copy_to_stream().",
                "length": "smol",
                "topic": "php",
                "lang": "en",
                "source": "php"
            }
        }
    },
    methods: {
        textFound(response) {
            this.text = response;
        }
    }
}
</script>

<style scoped>


</style>
