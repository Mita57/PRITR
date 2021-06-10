<template>
    <race-text-selector v-if="!settingsSet" v-on:findGame=""></race-text-selector>
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
            settingsSet: false,
            game: null
        }
    }
}
</script>

<style scoped>

</style>
