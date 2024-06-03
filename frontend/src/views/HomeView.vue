<template>
  <Banner />
  <div class="main-container">
    <h1>Cadastrar Usuário</h1>
    <UsuarioForm/>
  </div>
</template>

<script>
import UsuarioForm from '@/components/UsuarioForm.vue'
import Banner from "../components/Banner.vue"

  export default {
    name: "Home",
    components: {
      Banner,
      UsuarioForm
    }
  }
</script>
