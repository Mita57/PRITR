import suggestText from "./vue/suggestText";
import practiceRace from "./vue/practice/practiceRace";

require('./bootstrap');
import Vue from 'vue';
import App from './vue/app';
import VueRouter from "vue-router";
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        token: localStorage.getItem('access_token') || null
    },

    getters: {
        loggedIn(state) {
            return state.token !== null;
        }
    },

    mutations: {
        retrieveToken(state, token) {
            state.token = token;
        },
        destroyToken(state) {
            state.token = null;
        },
    },

    actions: {
        register(context, data) {
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/register', {
                    name: data.name,
                    email: data.email,
                    password: data.password,
                })
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        destroyToken(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

            if (context.getters.loggedIn) {
                return new Promise((resolve, reject) => {
                    axios.post('/api/v1/logout')
                        .then(response => {
                            localStorage.removeItem('access_token');
                            context.commit('destroyToken');
                            resolve(response);
                        })
                        .catch(error => {
                            localStorage.removeItem('access_token');
                            context.commit('destroyToken');
                            reject(error);
                        })
                })
            }
        },
        retrieveToken(context, credentials) {

            return new Promise((resolve, reject) => {
                axios.post('/api/v1/login', {
                    username: credentials.username,
                    password: credentials.password,
                })
                    .then(response => {
                        const token = response.data.access_token;

                        localStorage.setItem('access_token', token);
                        context.commit('retrieveToken', token);
                        resolve(response);
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error);
                    })
            })
    }
})

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
