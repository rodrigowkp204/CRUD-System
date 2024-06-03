<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegistroController extends CI_Controller {

    public function cadastrar() {
		//Carregar o banco de dados
        $this->load->database();

		//Configuração dos cabeçalhos CORS
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
        
        //Recupere os dados do formulário da requisição POST
        $nome = $this->input->post('nome');
        $telefone = $this->input->post('telefone');
        $email = $this->input->post('email');
        $nascimento = $this->input->post('nascimento');
		$idade = $this->input->post('age');

		//Verificação se o usuário já existe no banco de dados
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $response = array('error' => 'O usuário com esse e-mail já existe no banco de dados.');
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        //Verificação se a imagem foi enviada
        if(isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'])) {
            // Configurações para upload de imagem
            $config['upload_path'] = './uploads/imagens';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048; // 2MB
            
            // Carrega a biblioteca de upload
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('imagem')) {
                // Se a imagem foi carregada com sucesso, obtenha o nome do arquivo
                $imagem = $this->upload->data('file_name');
            } else {
                // Se houver um erro no upload, você pode tratar aqui
                $error = $this->upload->display_errors();
                $response = array('error' => $error);
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
                return;
            }
        } else {
            // Se nenhuma imagem foi enviada, defina $imagem como nulo
            $imagem = null;
        }

		$nascimento = date('d/m/Y', strtotime($this->input->post('nascimento')));
		//Adicionando os dados capturados na requisição POST no banco de dados
        $data = array(
            'nome' => $nome,
            'telefone' => $telefone,
            'email' => $email,
            'nascimento' => $nascimento,
			'idade'=> $idade,
            'imagem' => $imagem
        );
        $this->db->insert('users', $data);

        $response = array('message' => 'Usuário cadastrado com sucesso!');
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

	// Método para responder a solicitações OPTIONS para o método POST
    public function options_create() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Max-Age: 3600");
        exit;
    }
}
