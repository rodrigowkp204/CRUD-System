<h1>Sistema CRUD</h1>
<h2>Requisitos</h2>
<h3>É de extrema importância que esses softwares estejam instalados no seu computador.</h3>
    <ul>
        <li><a href="https://www.apachefriends.org/index.html">XAMPP</a></li>
        <li><a href="https://code.visualstudio.com/">Visual Studio Code</a></li>
    </ul>

<h2>Instalação</h2>

<h3>1. Instalar XAMPP</h3>
<p>Baixe e instale o <a href="https://www.apachefriends.org/index.html">XAMPP</a>.</p>

<h3>2. Instalar Visual Studio Code</h3>
<p>Baixe e instale o <a href="https://code.visualstudio.com/">Visual Studio Code</a>.</p>

<h3>3. Baixar o Repositório</h3>
<p>Baixe o repositório do projeto, na extensão .zip, logo em seguida extraia os arquivos e mova o repositório para a pasta htdocs do XAMPP.</p>
<p>Faça a verificação se o nome do repositório esta correto, é para ter esse nome: "CRUD-System-main".</p>

<h3>4. Abrir o XAMPP</h3>
<p>Inicie o servidor apache e o banco de dados mysql, conforme a imagem a baixo:</p>
![image](https://github.com/rodrigowkp204/CRUD-System/assets/93540875/6c362866-fb6e-4ed7-bb8e-da21e539988e)

<h3>5. Abrir o repositório no Visual Studio Code</h3>
<p>Abra o repositório no Visual Studio e vá até o terminal para rodar os seguintes comandos:</p>
<pre><code># Navegar para a pasta do frontend
cd frontend
# Instalar o npm
npm install
</code></pre>

<h3>6. Configuração do Banco de Dados</h3>
<h4>a. Criar o Banco de Dados e a Tabela</h4>
<ol>
  <li>Abra o phpMyAdmin através do XAMPP.</li>
  <li>Execute o seguinte script SQL para criar o banco de dados e a tabela <code>users</code>:</li>
</ol>
<pre><code>-- Criação do banco de dados
CREATE DATABASE users_db;

-- Seleciona o banco de dados criado
USE users_db;

-- Criação da tabela `users`
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nascimento VARCHAR(10) NOT NULL,
    imagem VARCHAR(255) DEFAULT NULL,
    idade INT(11) DEFAULT NULL,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);
</code></pre>

<h4>b. Configurar a Conexão com o Banco de Dados</h4>
<ol>
  <li>Abra o arquivo <code>backend/application/config/database.php</code> no Visual Studio Code.</li>
  <li>Configure as seguintes informações de acordo com o seu ambiente:</li>
</ol>
<pre><code>$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'users_db',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
</code></pre>

<h3>7. Reinicie os Servidores</h3>

<h4>a. Reiniciar o Apache e MySQL no XAMPP</h4>
<p>Abra o painel de controle do XAMPP e desligue e ligue novamente os módulos Apache e MySQL.</p>
<h4>b. Iniciar o Servidor do Frontend</h4>
<p>No terminal do Visual Studio Code, navegue até a pasta do frontend e execute:</p>
<pre><code># Navegar para a pasta do frontend
cd frontend
# Iniciar o servidor do frontend
npm run serve
</code></pre>

<h3>8. Acessar o Projeto</h3>
<p>Abra o navegador e acesse o endereço fornecido pelo comando <code>npm run serve</code>, geralmente <code>http://localhost:8080</code>.</p>

<p>Pronto! O seu sistema CRUD deve estar funcionando corretamente.</p>
