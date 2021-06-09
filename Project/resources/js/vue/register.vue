<template>
    <div id="container" @input="validateInputs">
        <h2>Регистрация</h2>
        <label for="email">Email</label>
        <p><input type="email" id="email" v-model="email"> {{emailError ? 'Email уже занят' : ''}}</p>
        <label for="username">Имя пользователя</label>
        <p><input type="text" id="username" v-model="username"></p>
        <label for="">Пароль</label>
        <p><input type="password" id="pwrd" v-model="password"></p>
        <label for="pwrdRepeat">Повторите пароль</label>
        <p><input type="password" id="pwrdRepeat" v-model="repeatPassword"></p>
        <button id="registerBtn" @click="register" :disabled="regBtnDisabled"> Зарегаться lmao</button>
    </div>
</template>

<script>
export default {
    name: "register",

    data: () => {
        return {
            email: '',
            username: '',
            password: '',
            repeatPassword: '',
            regBtnDisabled: true,
            emailError:false,
        }
    },

    methods: {
        validateInputs() {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            const email = re.test(String(this.email).toLowerCase());
            const userName = this.username.length >= 3;
            const pwrd = this.password === this.repeatPassword && this.password.length >= 6;
            if (email && userName && pwrd) {
                this.regBtnDisabled = false;
            } else {
                this.regBtnDisabled = true;
            }
        },

        register() {
            this.$store.dispatch('register', {
                name: this.username,
                email: this.email,
                password: this.password,
            }).then(response => {
                this.$store.dispatch('retrieveToken', {
                    username: this.email,
                    password: this.password,
                }).then(response => {
                    this.$router.push((''));
                });
            }).catch(response => {
                this.emailError = true;
            });
        }
    }
}
</script>

<style scoped>

#container {
    width: 600px;
    text-align: center;
    background-color: #cdcdcd;
    padding: 16px;
    margin: 16px auto auto;
    border-radius: 8px;
}

h2 {
    margin: 0 0 8px;
}

input {
    width: 550px;
    height: 24px;
}

p {
    margin: 4px;
}

#registerBtn {
    height: 40px;
    width: 200px;
    background-color: #530000;
    color: #FFFFFF;
    font-size: 14pt;
    border: none;
    transition: 0.3s;
    font-family: "Noto Sans";
    cursor: pointer;
    margin-top: 8px;
}

#registerBtn:hover {
    background-color: #693838;
}

#registerBtn:disabled {
    background-color: #915656;
    color: #c8a4a4;
    cursor: default;
}

</style>
