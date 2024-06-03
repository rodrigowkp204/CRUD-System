<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('User_model');
	}

	public function index() {
		// Handle GET request to list users
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		$users = $this->User_model->get_all_users();
		echo json_encode($users);
	}
	// Método para responder a solicitações OPTIONS para o método GET
    public function options_index() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Max-Age: 3600");
        exit;
    }
}
