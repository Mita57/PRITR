<template>
    <div id="app">
        <div id="menu">
            <div class="menu-item" id="cock">
                <img id="moor"
                     src="moor.png">
                <h2 style="display: inline" id="title">Fast Boi Moor</h2>
            </div>
            <router-link to="/defaultRace" v-if="loggedIn">
                <div class="menu-item" :style="[($router.currentRoute.name === 'DefaultRace') ? {backgroundColor: '#960000'}: {}]">Обычная гонка</div>
            </router-link>
            <router-link to="/practiceRace">
                <div class="menu-item" :style="[($router.currentRoute.name === 'PracticeRace') ? {backgroundColor: '#960000'}: {}]" >
                    Тренировка</div>
            </router-link>
            <router-link to="/gameRoom" v-if="loggedIn">
            <div class="menu-item" :style="[($router.currentRoute.name === 'gameRoom') ? {backgroundColor: '#960000'}: {}]">Играть с друзьями</div>
            </router-link>
            <router-link v-if="loggedIn" to="/texts"><div class="menu-item" :style="[($router.currentRoute.name === 'Texts') ? {backgroundColor: '#960000'}: {}]">Предложить текст</div>
            </router-link>
            <div class="menu-item" id="acc" v-if="loggedIn" @mouseover="showStats = true" @mouseleave="showStats = false">
                <img class="user_pic"
                     src="https://sun9-10.userapi.com/s/v1/ig2/LS5dHm4PYRXUVKrOAaHT_tqVbPuykRwE8UDSQhez_Ek4c3PCwvyZAG_ZSMp28KSJz962LJVfb5On1uHIWLdSB-5-.jpg?size=200x0&quality=96&crop=116,0,692,692&ava=1">
                <span style="display: inline">{{ $store.getters.getUser.username }}</span>
                <div id="statsOverlay" v-if="showStats">
                    <p>CPM 10 последних гонок: {{$store.getters.getUser.cpm_last_10}}</p>
                    <p>CPM за все время: {{Math.round($store.getters.getUser.cpm_sum / $store.getters.getUser.classic_finished)}}</p>
                    <p>Гонок: {{$store.getters.getUser.classic_finished}}</p>
                    <p>Гонок выиграно: {{$store.getters.getUser.classic_won}}</p>
                </div>
            </div>
            <div class="menu-item" id="logOut" v-if="loggedIn" @click="logOut">
                <span>Выйти</span>
            </div>
            <div class="menu-item" v-if="loggedIn">
                CPM: <span style="display: inline">{{ $store.getters.getUser.cpm_last_10 }}</span>
            </div>
            <div class="menu-item" id="logIn" v-if="!loggedIn" @click="loginVisible = !loginVisible">
                <span>Войти</span>
            </div>
            <div class="menu-item" id="Register" v-if="!loggedIn">
                <router-link to="/register">Зарегаца</router-link>
            </div>
            <div id="logInOverlay" v-if="loginVisible">
                <h2>Вход</h2>
                <label for="email">Email</label>
                <p><input type="email" id="email" v-model="email" @input="validateInputs"></p>
                <label for="pwrd">Пароль</label>
                <p><input type="password" id="pwrd" v-model="password" @input="validateInputs"></p>
                <button id="loginButton" :disabled="loginBtnDisabled" @click="login">Войти</button>
            </div>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "app",
    data: () => {
        return {
            email: '',
            password: '',
            loginVisible: false,
            loginBtnDisabled: true,
            showStats: false
        }
    },

    created() {
        window.addEventListener('click', this.closeLogin);
    },

    destroyed() {
        window.removeEventListener('click', this.closeLogin);
    },

    methods: {
        closeLogin(e) {
            if (!e.path.includes(document.getElementById('logInOverlay')) &&
                !e.path.includes(document.getElementById('logIn'))) {
                this.loginVisible = false;
            }
        },

        validateInputs() {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (re.test(String(this.email).toLowerCase()) && this.password.length >= 6) {
                this.loginBtnDisabled = false;
            } else {
                this.loginBtnDisabled = true;
            }
        },

        login() {
            this.$store.dispatch('retrieveToken', {
                username: this.email,
                password: this.password,
            }).then(response => {
                this.loginVisible = false;
            });
        },

        logOut() {
            this.$store.dispatch('destroyToken')
                .then(response => {
                    //
                });
        }
    },

    computed: {
        loggedIn() {
            return this.$store.getters.loggedIn;
        },

        username() {
            return this.$store.getters.getUsername;
        }
    }
}
</script>

<style scoped>

#menu {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 48px;
    background-color: #530000;
    box-shadow: gray 0 5px 10px;
}

#moor {
    height: 40px;
    margin-right: 12px;
    margin-top: -8px;
    border-radius: 50%
}

a {
    text-decoration: none;
    color: #ffffff;
}

#logInOverlay {
    position: absolute;
    right: 0;
    background-color: #FFFFFF;
    height: 200px;
    padding: 16px;
    text-align: center;
    width: 350px;
    top: 48px;

}

#title {
    margin-top: -6px;
}

#statsOverlay {
    position: absolute;
    right: 130px;
    background-color: #FFFFFF;
    height: 130px;
    color: black;
    cursor: default;
    padding: 16px;
    text-align: left;
    width: 300px;
    top: 48px;

}

#statsOverlay p:first-of-type {
    margin: 0;
}

#logInOverlay input {
    width: 300px;
    height: 24px;
}

#logInOverlay p {
    margin: 4px;
}

.menu-item {
    padding: 12px 20px;
    transition: 0.3s;
    color: white;
}

.menu-item:hover {
    background-color: #790000;
    cursor: pointer;
}

#acc, #logIn {
    margin-left: auto;
    color: #ffffff;
    display: inline-flex;
}

#acc {
    cursor: default;
}


.user_pic {
    height: 40px;
    margin-right: 12px;
    margin-top: -8px;
    border-radius: 50%
}

h2 {
    margin: 0 0 8px;
}

#loginButton {
    height: 40px;
    width: 200px;
    background-color: #530000;
    color: #FFFFFF;
    font-size: 14pt;
    border: none;
    font-family: "Noto Sans";
    transition: 0.3s;
    cursor: pointer;
    margin-top: 8px;
}

#loginButton:hover {
    background-color: #693838;
}

#loginButton:disabled {
    background-color: #915656;
    color: #c8a4a4;
    cursor: default;
}

#cock {
    display: flex;
}

</style>
