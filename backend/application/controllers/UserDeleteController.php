<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UserDeleteController extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('User_model');
	}
	
	public function deleteUser($id) {
		// Configuração dos cabeçalhos CORS
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: DELETE");
		header("Access-Control-Allow-Headers: Content-Type, Authorization");
	
		// Verifica se a solicitação é do tipo OPTIONS
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			http_response_code(200);
			exit();
		}

		$result = $this->User_model->deleteUser($id); // Chama o método no modelo para excluir o usuário

		if ($result) {
			// Se a exclusão for bem-sucedida, retorna uma resposta 200
			$this->output->set_status_header(200);
			echo json_encode(array('message' => 'Sucesso ao excluir usuário'));
		} else {
			// Se houver um erro, retorna uma resposta 500 com uma mensagem de erro
			$this->output->set_status_header(500);
			echo json_encode(array('message' => 'Erro ao excluir usuário'));
		}
	}
}
