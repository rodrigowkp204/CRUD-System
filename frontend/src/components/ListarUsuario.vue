<template>
    <div class="container">
      <div class="row search-container">
        <div class="input-container col s12 m4">
          <label for="nome">Buscar pelo nome</label>
          <input type="text" v-model="searchName" placeholder="Buscar por nome" @input="fetchUsers" />
        </div>
        <div class="input-container col s12 m4">
          <label for="nome">Buscar pela data de nascimento (Início)</label>
          <input type="date" v-model="searchBirthdateStart" @change="fetchUsers" placeholder="Data de nascimento (início)" />
        </div>
        <div class="input-container col s12 m4">
          <label for="nome">Buscar pela data de nascimento (Final)</label>
          <input type="date" v-model="searchBirthdateEnd" @change="fetchUsers" placeholder="Data de nascimento (final)" />
        </div>
        <div class="input-container col s12 m4">
          <label for="nome">Buscar pelo e-mail</label>
          <input type="text" v-model="searchEmail" placeholder="Buscar por e-mail" @input="fetchUsers" />
        </div>
      </div>
      <div class="row sort-container">
        <div class="col s12">
          <button class="btn waves-effect waves-light" @click="sortUsers('nome')">Ordenar por Nome</button>
          <button class="btn waves-effect waves-light" @click="sortUsers('nascimento')">Ordenar por Data de Nascimento</button>
          <button class="btn waves-effect waves-light" @click="sortUsers('data_cadastro')">Ordenar por Data de Cadastro</button>
        </div>  
      </div>
      <div class="user-list row">
        <table class="striped">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Telefone</th>
              <th>E-mail</th>
              <th>Data de Nascimento</th>
              <th>Idade</th>
              <th>Data de cadastro</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in filteredUsers" :key="user.id">   
              <td>{{ user.nome }}</td>
              <td>{{ user.telefone }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.nascimento }}</td>
              <td>{{ user.idade }}</td>
              <td>{{ user.data_cadastro }}</td>
              <td>
                <div class="div-btn">
                  <button class="btn-small waves-effect waves-light blue" @click="editUser(user)">Editar</button>
                  <button class="btn-small waves-effect waves-light red" @click="deleteUser(user.id)">Excluir</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="row">
      <button class="btn btn-create waves-effect waves-light btn-large">
        <router-link to="/" class="router-usuario">Criar Novo Usuário</router-link>
      </button>
    </div>
    </div>
    <div class="modal" :class="{ 'is-active': isEditModalActive }">
      <div class="modal-background" @click="closeEditModal"></div>
        <div class="modal-content">
          <div class="box">
            <h3>Editar Usuário</h3>
            <div class="field" v-if="editedUser">
              <label class="label">Nome</label>
              <div class="control">
                <input class="input" type="text" v-model="editedUser.nome">
              </div>
            </div>
            <div class="field" v-if="editedUser">
              <label class="label">Telefone</label>
              <div class="control">
                <input v-mask="['(##) ####-####', '(##) #####-####']" type="text" v-model="editedUser.telefone">
              </div>
            </div>
            <div class="field" v-if="editedUser">
              <label class="label">E-mail</label>
              <div class="control">
                <input class="input" type="text" v-model="editedUser.email">
              </div>
            </div>
            <div class="field" v-if="editedUser">
              <label class="label">Data de Nascimento</label>
              <div class="control">
                <input class="input" type="date" v-model="editedUser.nascimento">
              </div>
            </div>
            <div class="field" v-if="editedUser">
              <label class="label">Idade</label>
              <div class="control">
                <input class="input" type="text" v-model="editedUser.idade" readonly>
              </div>
            </div>
            <div class="file-field input-field">
                    <div class="btn btn-upload">
                        <span>Arquivo</span>
                        <input type="file" accept="image/*" @change="handleImageChange">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" v-model= "imagem" placeholder="Selecione uma imagem">
                    </div>
                </div>
            <div class="field" v-if="editedUser">
              <img :src="imagePreview || getImageUrl(editedUser.imagem)" alt="Image Preview" class="img1">
            </div>
            <div class="btn-modal">
              <button class="button is-primary" @click="saveEdit">SALVAR</button>
              <button class="modal-close is-large" aria-label="close" @click="closeEditModal">CANCELAR</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal-background-1" @click="closeEditModal" v-if="isEditModalActive"></div>
</template>

<script>
  import axios from 'axios';
  import { mask } from 'vue-the-mask';
  import moment from 'moment';
  import 'materialize-css/dist/css/materialize.min.css';
  import M from 'materialize-css/dist/js/materialize.min.js';

  export default {
    name: 'ListarUsuario',
    directives: { mask },
    data() {
      return {
        users: [],
        searchName: '',
        searchBirthdateStart: '',
        searchBirthdateEnd: '',
        searchEmail: '',
        age: '',
        isEditModalActive: false,
        editedUser: null,
        imagePreview: null,
        sortKey: '',
        sortAsc: true
      };
    },
    mounted(){
      M.AutoInit();
    },
    computed: {
      filteredUsers() {
        return this.users.filter(user => {
          //Verificar se o nome do usuário ou o email corresponde ao critério de pesquisa.
          const nameMatches = user.nome ? user.nome.toLowerCase().includes(this.searchName.toLowerCase()) : false;
          const emailMatches = user.email ? user.email.toLowerCase().includes(this.searchEmail.toLowerCase()) : false;

          //Converter as datas de pesquisa para objetos Moment.js
          const startDate = this.searchBirthdateStart ? moment(this.searchBirthdateStart) : null;
          const endDate = this.searchBirthdateEnd ? moment(this.searchBirthdateEnd) : null;

          //Converter a data de nascimento do usuário para objetos Moment.js
          const birthdate = user.nascimento ? moment(user.nascimento, 'DD/MM/YYYY') : null;

          //Verificar se a data de nascimento do usuário está dentro do intervalo de datas
          const birthdateInRange = !birthdate ||
                                  (!startDate || birthdate.isSameOrAfter(startDate, 'day')) &&
                                  (!endDate || birthdate.isSameOrBefore(endDate, 'day'));

          return nameMatches && emailMatches && birthdateInRange;
        });
      },
    },
    mounted() {
      this.fetchUsers();
    },
    methods: {
      async fetchUsers() {
        try {
          //Requisição GET para listar os usuários cadastrados no banco de dados
          const response = await axios.get('http://localhost/CRUD-System-main/backend/index.php/users');
          this.users = response.data;
        } catch (error) {
          console.error('Erro ao buscar usuários:', error);
        }
      },
      editUser(user) {
        this.editedUser = { ...user };
        this.originalUser = { ...user };
        this.isEditModalActive = true;
        // Converter a data de nascimento para o formato de entrada "date"
        this.editedUser.nascimento = moment(user.nascimento, 'DD/MM/YYYY').format('YYYY-MM-DD');

        //Verificar se a imagem do usuário é uma URL do banco de dados ou um arquivo
        if (typeof user.imagem === 'string') {
          //Se for uma URL do banco de dados, definir imagePreview como a URL direta
          this.imagePreview = this.getImageUrl(user.imagem);
        } else if (user.imagem instanceof File) {
          //Se for um arquivo, usar a URL gerada pelo FileReader
          const reader = new FileReader();
          reader.onload = () => {
            this.imagePreview = reader.result;
          };
          reader.readAsDataURL(user.imagem);
        } else {
          //Se não for nem uma URL nem um arquivo, imagePreview é nulo
          this.imagePreview = null;
        }

        if (this.editedUser.nascimento) {
          const today = new Date();
          const dataNascimento = new Date(this.editedUser.nascimento);
          let age = today.getFullYear() - dataNascimento.getFullYear();
          const diferencaMes = today.getMonth() - dataNascimento.getMonth();
          
          //Se o mês atual for anterior ao mês de nascimento, ou
          //se estivermos no mesmo mês, mas o dia atual é anterior ao dia de nascimento,
          //então ainda não completou anos, portanto subtrai 1 da idade
          if (diferencaMes < 0 || (diferencaMes === 0 && today.getDate() < dataNascimento.getDate())) {
            age--;
          }

          this.editedUser.idade = age + " ano(s)";
        }
      },
      closeEditModal() {
        this.isEditModalActive = false;
        this.editedUser = { ...this.originalUser };
        this.imagePreview = null;
      },
      handleImageChange(event) {
        const file = event.target.files[0];
        
        //Verificar se um novo arquivo foi selecionado
        if (file) {
          this.editedUser.imagem = file;
          this.imagem = file.name;

          //Usar o FileReader para ler o arquivo selecionado
          const reader = new FileReader();
          reader.onload = () => {
            this.imagePreview = reader.result;
          };
          reader.readAsDataURL(file);
        }
      },
      getImageUrl(imageName) {
        //Recuperar a imagem que está cadastrada no banco de dados para aparecer no preview
        return `http://localhost/CRUD-System-main/backend/uploads/imagens/${imageName}`;
      },
      async saveEdit() {
          try {
              const formData = new FormData();
              formData.append('nome', this.editedUser.nome);
              formData.append('telefone', this.editedUser.telefone);
              formData.append('email', this.editedUser.email);
              //Converter a data para o formato "DD/MM/YYYY"
              const formattedDate = moment(this.editedUser.nascimento).format('DD/MM/YYYY');
              formData.append('nascimento', formattedDate);
              formData.append('idade', this.editedUser.idade);
              if (this.editedUser.imagem instanceof File) {
                formData.append('imagem', this.editedUser.imagem);
              }

              //Verificar se todos os campos estão preenchidos
              if (!this.editedUser.nome || !this.editedUser.telefone || !this.editedUser.email || !this.editedUser.nascimento) {
                this.$toast.error('Por favor, preencha todos os campos.');
                return;
              }

              //Requisição POST para a atualização do usuário
              const response = await axios.post(`http://localhost/CRUD-System-main/backend/index.php/users/update/${this.editedUser.id}`, formData);
              if (response.data.success) {
                  this.$toast.success('Usuário atualizado com sucesso!');
                  this.fetchUsers();
                  this.closeEditModal();
              } else {
                  this.$toast.error(response.data.message);
                  console.error('Erro ao atualizar usuário:', response.data.message);
                }
          } catch (error) {
              console.error('Erro ao atualizar usuário:', error);
          }
      },
      async deleteUser(userId) {
        try {
          //Requisição DELETE para a exclusão do usuário
          await axios.delete(`http://localhost/CRUD-System-main/backend/index.php/users/delete/${userId}`);
          this.$toast.success('Usuário deletado com sucesso!');
          await this.fetchUsers();
        } catch (error) {
          console.error('Erro ao excluir usuário:', error);
        }
      },
      sortUsers(key) {
        //Verificar da chave de ordenação
        if (this.sortKey === key) {
          //Se for igual a chave nova, alterna a direção da ordenação
          this.sortAsc = !this.sortAsc;
        } else {
          //Se não for, define uma nova chave de ordenação e define a orientação como ascendente
          this.sortKey = key;
          this.sortAsc = true;
        }

        //Criar uma nova lista de usuários filtrados
        const users = this.filteredUsers.slice();

        if (this.sortKey) {
          //Ordenar os usuários com base na chave de ordenação
          users.sort((a, b) => {
            let aValue = a[this.sortKey];
            let bValue = b[this.sortKey];

            //Se a chave for 'nascimento', converte os valores para o tipo 'DD/MM/YYYY'
            if (this.sortKey === 'nascimento') {
              aValue = moment(aValue, 'DD/MM/YYYY'); 
              bValue = moment(bValue, 'DD/MM/YYYY');

              // Comparar os valores para determinar a ordem
              if (aValue.isBefore && aValue.isBefore(bValue)) return this.sortAsc ? -1 : 1;
              if (aValue.isAfter && aValue.isAfter(bValue)) return this.sortAsc ? 1 : -1;
              return 0;
            }

            //Se a chave for 'data_cadastro', converte os valores para objeto Date
            if (this.sortKey === 'data_cadastro') {
              aValue = new Date(aValue);
              bValue = new Date(bValue);
            }

            //Comparar os valores para determinar a ordem
            if (aValue < bValue) return this.sortAsc ? -1 : 1;
            if (aValue > bValue) return this.sortAsc ? 1 : -1;
            return 0;
          });
        }
        //Atualizar a lista de usuários
        this.users = users;
      }
    },
    watch: {
      'editedUser.nascimento': function(newValue, oldValue) {
      if (this.editedUser) {
        if (newValue) {
          const today = new Date();
          const birthDate = new Date(newValue);
          let age = today.getFullYear() - birthDate.getFullYear();
          const monthDiff = today.getMonth() - birthDate.getMonth();
          
          if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
          }

          this.editedUser.idade = age + " ano(s)";
        } else {
          this.editedUser.idade = '';
        }
      }
    }
    }
  };
</script>

<style scoped>

  h3 {
    text-align: center;
  }
  .img1{
    max-width: 100%;
    margin-top: 10px;
    border-radius: 20px;
  }
  .search-container, .sort-container {
    margin-bottom: 20px;
  }
  .sort-container {
    display: flex;
    align-items: center;
    align-content: center;
    justify-content: space-evenly;
  }
  .sort-container button{
    font-family: 'Signika', sans-serif;
    font-size: 13px;
    color: #090909;
    background-color: #1CE28E;
    margin-top: 10px;
    padding: 8px;
    border-radius: 20px;
    display: flex;
    align-items: center;
  }
  .sort-container button:hover {
    cursor: pointer;
    transition: .5s;
    color: #FFF;
    background-color: #18433A;
  }
  .btn, .btn-small {
    border-radius: 10px;
  }
  .row .col.s12 {
    display: flex;
    justify-content: space-evenly;
  }
  .search-container{
      display: flex;
      align-content: center;
      justify-content: space-evenly;
  }
  .input-container {
      display: flex;
      flex-direction: column;
  }
  .input-container label {
      font-weight: bold;
      font-size: 15px;
  }
  .input-container input {
      margin-top: 10px;
      padding: 5px 5px;
      width: 60%;
  }
  .user-list table {
    width: 100%;
    border-collapse: collapse;
  }
  .user-list th, .user-list td {
    padding: 10px;
    border: 1px solid #ccc;
  }
  .user-list table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  .user-list th, .user-list td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
  }
  .user-list th {
    background-color: #f4f4f4;
  }
  .user-list td {
    background-color: #fff;
  }
  .div-btn {
    display: flex;
    align-content: center;
    justify-content: center;
    gap: 5px;
  }
  .btn-create {
    font-size: 15px;
    color: #090909;
    background-color: #1CE28E;
    margin-top: 10px;
    padding: 0px 20px 0px 20px;
    border-radius: 20px;
    display: flex;
    align-items: center;
  }
  .btn-create:hover {
    cursor: pointer;
    transition: .5s;
    color: #FFF;
    background-color: #18433A;
  }
  .router-usuario {
    text-decoration: none;
    color: #090909;
  }
  .router-usuario:hover {
    text-decoration: none;
    color: #FFF;
  }
  .modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60%;
    max-width: 400px;
    margin: 0;
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    z-index: 9999;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
  }
  .modal-content {
    position: relative;
    background-color: rgba(0, 0, 0, 0.0);
  }
  .field {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
  }
  .label {
    font-weight: bold;
    font-size: 15px;
    margin-bottom: 15px;
    color: #222;
    padding: 5px 10px;
    border-left: 4px solid #1CE28E;
  }
  .modal-control {
    margin-top: 5px;
  }
  .input {
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  .modal.is-active {
    display: block;
  }
  .modal-open {
    overflow: hidden;
  }
  .modal-background-1 {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9998;
  }
  .btn-modal {
    display: flex;
    justify-content: space-around;
  }
  .btn-upload {
    font-size: 15px;
    color: #090909;
    background-color: #1CE28E;
    margin-top: 10px;
    padding: 8px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .btn-modal button {
    font-family: 'Signika', sans-serif;
    font-size: 17px;
    color: #090909;
    background-color: #1CE28E;
    padding: 10px 15px 10px 15px;
    border-radius: 10px;
    border: 0px;
  }
  .btn-modal button:hover {
    cursor: pointer;
    transition: .5s;
    color: #FFF;
    background-color: #18433A;
  }
</style>
