<template>
    <div id="main-banner">
    </div>
</template>

<script>
export default {
    name: "Banner"
}

</script>

<style scoped>
    #main-banner {
        background-image: url('/public/img/banner_sistema.jpg');
        background-position: 0 -250px;
        background-size: cover;
        height: 500px;
        border-radius: 0px 0px 45px 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #main-banner h1{
        color: #FFF;
        text-align: center;
        font-size: 60px;
    }
</style>
