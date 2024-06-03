<template>
  <Navbar :logo="logo_src" :alt="app_name"/>
  <router-view/>
  <Footer/>
</template>

<script>
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';

export default {
  components: {
    Navbar,
    Footer
  },
  data() {
    return{
      logo_src: "/img/logo-sistema-crud.png",
      app_name: "CRUD System"
    }
  }
}

</script>


<style>
@import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Signika:wght@400;700&display=swap');

  *{
    font-family: Helvetica;
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }
  .main-container{
    margin:  50px;
    min-height: 250px;
  }
  h1{
    text-align: center;
    font-size: 42px;
    margin-bottom: 30px;
    color: #222 
  }
  body, p, label, input, label{
    font-family: 'Open Sans', sans-serif;
  }

  h1, h2, h3, h4, h5, h6, button, a, span{
    font-family: 'Signika', sans-serif;
  }
</style>