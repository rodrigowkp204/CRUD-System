<template>
    <div id="nav">
        <router-link to="/" id="logo-url">
            <img :src="logo" :alt="alt" id="logo">
        </router-link>
        <router-link to="/" class="nav-1">Cadastro de Usuário</router-link>
        <router-link to="/listarcadastro" class="nav-1">Listar Usuários</router-link>
    </div>
</template>

<script>
    export default{
        name: "Navbar",
        props: ["logo","alt"]
    }

</script>

<style scoped>
    #nav{
        background-color: #222;
        border-bottom: 4px solid #111;
        padding: 15px 50px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    #nav #logo-url {
        margin: auto;
        margin-left: 0;
    }
    #logo{
        width: 80px;
        height: 80px;
    }
    #nav a{
        color: #FFF !important;
        text-decoration: none;
        margin: 12px;
        transition: .5s;
        font-size: 20px;
    }
    #nav .nav-1:hover{
        border-bottom: 4px solid #1CE28E;
    }
</style>