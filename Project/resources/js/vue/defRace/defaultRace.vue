<template>
    <race-text-selector v-if="game == null" v-on:findGame="findGame"></race-text-selector>
    <race-typing v-else game="game"></race-typing>
</template>

<script>
import RaceTextSelector from "./raceTextSelector";
import RaceTyping from "./raceTyping";
import axios from "axios";

export default {
    name: "defaultRace",
    components: {RaceTyping, RaceTextSelector},

    data: () => {
        return {
            settingsSet: null,
            game: null
        }
    },

    methods: {
        findGame(params) {
            this.settingsSet = params;
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token;
            axios({
                method: 'GET',
                url: 'api/v1/defaultRace/getRace',
                params: params
            }).then((response) => {
                this.game = response.data;
                axios({
                    method: 'POST',
                    url: 'api/v1/defaultRace/joinGame',
                    data: {
                        gameId: this.game.id
                    }
                });
            }).catch((response) => {
                console.log(response);
            })

        }
    }
}
</script>

<style scoped>

</style>
