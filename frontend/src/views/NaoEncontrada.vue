<template>
  <div class="not-found">
    <h1>Página não encontrada</h1>
    <p>A página que você está procurando não foi encontrada.</p>
      <button class="btn btn-no waves-effect waves-light btn-large">
        <router-link to="/">Voltar para a página inicial</router-link>
      </button>
  </div>
</template>

<script>
export default {
  name: 'NaoEncontrada'
};
</script>

<style scoped>
.not-found {
  text-align: center;
  margin-top: 50px;
}
.not-found h1 {
  font-family: 'Signika', sans-serif;
  font-size: 4em;
  color: #333;
}
.not-found p {
  font-size: 1.2em;
  color: #666;
}
.btn{
  margin-top: 20px;
  margin-bottom: 20px;
  border-radius: 10px;
}
button{
  background-color: #1CE28E;
  color: #0909
}
a{
  cursor: pointer;
  color: #333;
}
button:hover{
  background-color: #1CE28E;
}
</style>
