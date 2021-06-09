<template>
    <div id="app">
        <div id="menu">
            <div class="menu-item">
                <router-link to="/texts">Обычная гонка</router-link>
            </div>
            <div class="menu-item">
                <router-link to="/texts">Ошибки</router-link>
            </div>
            <div class="menu-item">
                <router-link to="/practiceRace">Тренировка</router-link>
            </div>
            <div class="menu-item">
                <router-link to="/texts">Играть с друзьями</router-link>
            </div>
            <div class="menu-item">
                <router-link to="/texts">Предложить текст</router-link>
            </div>
            <div class="menu-item" id="acc" v-if="loggedIn">
                <img class="user_pic" src="https://sun9-10.userapi.com/s/v1/ig2/LS5dHm4PYRXUVKrOAaHT_tqVbPuykRwE8UDSQhez_Ek4c3PCwvyZAG_ZSMp28KSJz962LJVfb5On1uHIWLdSB-5-.jpg?size=200x0&quality=96&crop=116,0,692,692&ava=1">
                <span style="display: inline">Account</span>
            </div>
            <div class="menu-item" id="logOut" v-if="loggedIn">
                <span>Выйти</span>
            </div>
            <div class="menu-item" id="logIn" v-if="!loggedIn" @click="loginVisible = !loginVisible">
                <span>Войти</span>
            </div>
            <div class="menu-item" id="Register" v-if="!loggedIn">
                <span>Зарегаца</span>
            </div>
            <div id="logInOverlay" v-if="loginVisible">
                <h2>Вход</h2>
                <label for="email">Email</label>
                <p><input type="email" id="email" v-model="email"></p>
                <label for="pwrd">Пароль</label>
                <p><input type="password" id="pwrd" v-model="password"></p>
                <button>Войти</button>
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
          }
        },

        computed: {
            loggedIn() {
                return this.$store.getters.loggedIn;
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

a {
    text-decoration: none;
    color: #ffffff;
}

#logInOverlay {
    position: absolute;
    right: 0;
    background-color: #FFFFFF;
    height: 160px;
    padding: 16px;
    text-align: center;
    width: 350px;
    top: 48px;

}

#logInOverlay input {
    width: 300px;
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


.user_pic {
    height: 40px;
    margin-right: 12px;
    margin-top: -8px;
    border-radius: 50%
}

h2 {
    margin: 0 0 8px;
}

</style>
