<?php
//URL para fazer a verificação: http://localhost/CRUD-System-main/backend/index.php/testdatabase
defined('BASEPATH') OR exit('No direct script access allowed');

class TestDatabase extends CI_Controller {
    
    public function index() {
        $this->load->database();
        if ($this->db->conn_id) {
            echo "Conexão com o banco de dados bem-sucedida!";
        } else {
            echo "Falha ao conectar ao banco de dados!";
        }
    }
}
