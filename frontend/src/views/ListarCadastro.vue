<template>
  <div class="main-container">
    <h1>Lista de Usuários</h1>
    <ListarUsuario />
  </div>
</template>

<script>
import ListarUsuario from '@/components/ListarUsuario.vue'

export default {
  name: "Cadastro",
  components: {
      ListarUsuario
    } 
}
</script>

<style scoped>

</style>
