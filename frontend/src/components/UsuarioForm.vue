<template>
    <div class="container">
        <div class="row">
            <form @submit.prevent="handleSubmit" id="user-form">
                <div class="row">
                    <div class="input-field">
                        <input type="text" id="nome" name="name" class="validate" v-model="nome">
                        <label for="nome">Nome</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <label for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="telefone" v-model="telefone" v-mask="['(##) ####-####', '(##) #####-####']">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <label for="nome">E-mail</label>
                        <input type="text" id="email" name="email" v-model="email">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input type="date" id="data" class="date" name="nascimento" v-model="nascimento" @change="calculateAge" placeholder=""/>
                        <label for="aniversario">Data de Nascimento</label>
                    </div>
                </div>
                <div class="row">
                    <label for="idade">Idade</label>
                    <input type="text" id="idade" class="validate" name="idade" :value="age" placeholder="Calculada automaticamente" readonly/>    
                </div>
                <div class="file-field input-field">
                    <div class="btn btn-upload">
                        <span>Arquivo</span>
                        <input type="file" accept="image/*" @change="previewImage">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" v-model= "imagem" placeholder="Selecione uma imagem">
                    </div>
                </div>
                <div v-if="imagePreview">
                    <img :src="imagePreview" alt="Image Preview" class="img1">
                </div>
                <button class="btn btn-create waves-effect waves-light" type="submit">Cadastrar</button>
            </form>
        </div>  
    </div>  
</template>
  
<script>
  import axios from 'axios';
  import { mask } from 'vue-the-mask';
  import 'materialize-css/dist/css/materialize.min.css';
  import M from 'materialize-css/dist/js/materialize.min.js';

  export default {
    name: "UsuarioFrom",
    directives: { mask },
    props: {
        user: {
            type: Object,
            default: () => ({ name: '', telefone: '', email: '', nascimento: '', image: null }),
        },
        buttonText: {
            type: String,
            default: 'Submit',
        },
        handleSubmit: {
            type: Function,
            required: true,
        },
    },
    data(){
        return {
            name: '',
            telefone: '',
            email: '',
            nascimento: '',
            age: '',
            image: null,
            imagem: '',
            imagePreview: null,
        };
    },
    mounted(){
        M.AutoInit();
    },
    methods: {
        previewImage(event) {
            const file = event.target.files[0];
            this.image = file;
            this.imagePreview = URL.createObjectURL(file);
        },
        calculateAge() {
            if(this.nascimento) {
                const today = new Date();
                const aniversarioData = new Date(this.nascimento);
                let age = today.getFullYear() - aniversarioData.getFullYear();
                const diferencaMes = today.getMonth() - aniversarioData.getMonth();

                //Se o mês atual for anterior ao mês de nascimento, ou
                //se estivermos no mesmo mês, mas o dia atual é anterior ao dia de nascimento,
                //então ainda não completou anos, portanto subtrai 1 da idade
                if (diferencaMes < 0 || (diferencaMes === 0 && today.getDate() < aniversarioData.getDate())) {
                    age--;
                }
                this.age = age + " ano(s)";
            }
        },
        watch: {
            'nascimento': 'calculateAge'
        },
        async handleSubmit() {
            //Verificar se todos os campos estão preenchidos
            if (!this.nome || !this.telefone || !this.email || !this.nascimento || !this.image) {
                this.$toast.error('Por favor, preencha todos os campos.');
                return;
            }
            try {
                const formData = new FormData();
                formData.append('nome', this.nome);
                formData.append('telefone', this.telefone);
                formData.append('email', this.email);
                formData.append('nascimento', this.nascimento);
                formData.append('age', this.age);
                formData.append('imagem', this.image);

                //Requisição POST para o cadastro de usuário
                const response = await axios.post('http://localhost/CRUD-System-main/backend/index.php/registro', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.error) {
                    this.$toast.error(response.data.error);
                } else {
                    this.$toast.success('Usuário cadastrado com sucesso!');
                    this.clearForm();
                }
            } catch (error) {
                if (error.response && error.response.data && error.response.data.error) {
                    this.$toast.error(error.response.data.error);
                } else {
                    this.$toast.error('Ocorreu um erro ao processar a solicitação.');
                }
            }
        },
        clearForm(){
            this.nome = '';
            this.telefone = '';
            this.email = '';
            this.nascimento = '';
            this.age = '';
            this.image = '';
            this.imagePreview = '';
            this.imagem = '';
            this.$nextTick(() =>{
                M.updateTextFields();
            })
        }
    },
  }
</script>
  
<style scoped>
    .img1 {
        max-width: 100%;
        margin-top: 10px;
        border-radius: 20px;
    }
    #user-form {
        max-width: 400px;
        margin: 0 auto;
    }
    .input-container {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }
    input {
        padding: 10px 10px;
        width: 100%;
        border-radius: 20px;
        border: 1px solid #222;
    }
    button {
        align-items: center;
        display: block;
        width: 100%;
        margin-top: 20px;
    }
    .btn-create {
        font-size: 15px;
        font-family: 'Signika', sans-serif;
        color: #090909;
        background-color: #1CE28E;
        margin-top: 10px;
        padding: 8px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-create:hover {
        cursor: pointer;
        transition: .5s;
        color: #FFF;
        background-color: #18433A;
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
    .btn-upload:hover {
        cursor: pointer;
        transition: .5s;
        color: #FFF;
        background-color: #18433A;
    }
</style>
  