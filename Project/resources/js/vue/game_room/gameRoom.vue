<template>
    <div id="container">
        <div id="create" class="bigBtn">
            <button>Создать комнату</button>
        </div>
        <div id="join" class="bigBtn">
            Войти в комнату 
            <p><input type="text" id="roomIDInput" autocomplete="off" placeholder="ID комнаты / URL"> </p>
            <button>Войти</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "gameRoom"
}
</script>

<style scoped>

#container {
    width: 600px;
    text-align: center;
    margin: 16px auto auto;
}

.bigBtn {
    background-color: #cdcdcd;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
}

button {
    height: 40px;
    width: 200px;
    background-color: #530000;
    color: #FFFFFF;
    font-size: 14pt;
    border: none;
    transition: 0.3s;
    cursor: pointer;
}

button:hover {
    background-color: #693838;
}

button:disabled {
    background-color: #915656;
    color: #c8a4a4;
    cursor: default;
}

#roomIDInput {
    width: 500px;
    height: 28px;
}

</style>
