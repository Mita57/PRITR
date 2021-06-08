<template>
    <text-selector v-if="!text" v-on:searchText="searchText"></text-selector>
    <typing-practice v-else :text="this.text" v-on:changeSettings="text=null"
                     v-on:newText="searchText">
    </typing-practice>
</template>

<script>
import TextSelector from "./textSelector";
import TypingPractice from "./typingPractice";
export default {
name: "practiceRace",
    components: {TypingPractice, TextSelector},
    data: () => {
        return {
            text: null,
            settings : null
        }
    },
    methods: {
        searchText(pars) {
            let params = pars;
            if (pars === undefined) {
                params = this.settings;
            }
            this.text = null;
            axios({
                method: 'GET',
                url: 'api/v1/text/getRandom',
                params: params,
            }).then((response) => {
                this.text = response.data;
                this.settings = params;
            }).catch((response) => {
                console.error(response);
            });
        }
    }
}
</script>

<style scoped>


</style>
