<template>
    <div id="container">
        <h2>Регистрация</h2>
        <label for="email">Email</label>
        <p><input type="email" id="email" v-model="email"></p>
        <label for="username">Имя пользователя</label>
        <p><input type="text" id="username" v-model="username"></p>
        <label for="">Пароль</label>
        <p><input type="password" id="pwrd" v-model="password"></p>
        <label for="pwrdRepeat">Повторите пароль</label>
        <p><input type="password" id="pwrdRepeat" v-model="repeaPassword"></p>
        <button id="register"> Зарегаться lmao </button>
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
            repeaPassword:'',
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

#register {
    height: 40px;
    width: 200px;
    background-color: #530000;
    color: #FFFFFF;
    font-size: 14pt;
    border: none;
    transition: 0.3s;
    cursor: pointer;
    margin-top: 8px;
}

#register:hover {
    background-color: #693838;
}

#register:disabled {
    background-color: #915656;
    color: #c8a4a4;
    cursor: default;
}

</style>
