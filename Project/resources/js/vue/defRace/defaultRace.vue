<template>
    <race-text-selector v-if="game == null" v-on:findGame="findGame"></race-text-selector>
    <typing-race v-else game="game"></typing-race>
</template>

<script>
import RaceTextSelector from "./raceTextSelector";
import TypingRace from "./typingRace";
export default {
    name: "defaultRace",
    components: {TypingRace, RaceTextSelector},

    data: () => {
        return {
            settingsSet: null,
            game: null
        }
    },

    methods: {
        findGame(params) {
            this.settingsSet = params;

        }
    }
}
</script>

<style scoped>

</style>
