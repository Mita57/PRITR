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
            <div class="menu-item" id="acc">
                <img class="user_pic" src="https://sun9-10.userapi.com/s/v1/ig2/LS5dHm4PYRXUVKrOAaHT_tqVbPuykRwE8UDSQhez_Ek4c3PCwvyZAG_ZSMp28KSJz962LJVfb5On1uHIWLdSB-5-.jpg?size=200x0&quality=96&crop=116,0,692,692&ava=1">
                <span style="display: inline">Account</span>
            </div>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "app"
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

.menu-item {
    padding: 12px 20px;
    transition: 0.3s;
}

.menu-item:hover {
    background-color: #790000;
    cursor: pointer;
}

#acc {
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

</style>
