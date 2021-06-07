<template>
    <text-selector v-if="textFound === false"></text-selector>
    <typing-practice v-else></typing-practice>
</template>

<script>
import TextSelector from "./textSelector";
import TypingPractice from "./typingPractice";
export default {
name: "practiceRace",
    components: {TypingPractice, TextSelector},
    data: () => {
        return {
            textFound: false
        }
    }
}
</script>

<style scoped>


</style>
