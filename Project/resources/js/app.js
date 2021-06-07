import suggestText from "./vue/suggestText";
import practiceRace from "./vue/practice/practiceRace";

require('./bootstrap');
import Vue from 'vue';
import App from './vue/app';
import VueRouter from "vue-router";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        {
          path: '',
          name: 'Index',
          component: practiceRace
        },
        {
            path: '/texts',
            name: 'Texts',
            component: suggestText
        },
        {
            path: '/practiceRace',
            name: 'PracticeRace',
            component: practiceRace
        }
    ]
})

const app = new Vue({
    el: '#app',
    router,
    components: {App}
});
