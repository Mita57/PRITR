import suggestText from "./vue/suggestText";
import practiceRace from "./vue/practice/practiceRace";
import register from "./vue/register";

require('./bootstrap');
import Vue from 'vue';
import App from './vue/app';
import VueRouter from "vue-router";
import Vuex from 'vuex';
import axios from 'axios';
import defaultRace from "./vue/defRace/defaultRace";

Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        token: localStorage.getItem('access_token') || null,
        userName: localStorage.getItem('username') || null
    },

    getters: {
        loggedIn(state) {
            return state.token !== null;
        },

        getUsername(state) {
            return state.userName;
        }
    },

    mutations: {
        retrieveToken(state, token) {
            state.token = token;
        },
        destroyToken(state) {
            state.token = null;
        },
        setUsername(state, name) {
            state.userName = name;
        }
    },

    actions: {
        register(context, data) {
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/register', {
                    username: data.name,
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
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;

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
                    email: credentials.username,
                    password: credentials.password,
                })
                    .then(response => {
                        const token = response.data.access_token;
                        const username = response.data.nick;

                        localStorage.setItem('access_token', token);
                        localStorage.setItem('username', username);
                        context.commit('retrieveToken', token);
                        context.commit('setUsername', username);
                        resolve(response);
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error);
                    })
            })
        }
    }
})

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '',
            redirect: '/defaultRace',
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
        },
        {
            path: '/register',
            name: 'Register',
            component: register,
            meta: {
                requiresVisitor: true
            }
        },
        {
            path: '/defaultRace',
            name: 'DefaultRace',
            component: defaultRace
        }
    ]
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresVisitor)) {
        if (store.getters.loggedIn) {
            next({
                path: '/practiceRace',
            })
        } else {
            next();
        }
    } else {
        next();
    }
})

const app = new Vue({
    el: '#app',
    router,
    store: store,
    components: {App}
});
