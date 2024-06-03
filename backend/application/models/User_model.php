<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_users() {
		//Consulta com o banco de dados e como retorno é os registros
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function insert_user($data) {
		//Inserção dos dados dos usuário no Banco de Dados
		return $this->db->insert('users', $data);
	}
		
	public function deleteUser($id) {
        //Exclusão do usuário de acordo com o ID
        $this->db->where('id', $id);
        $this->db->delete('users');

        //Verificação se a exclusão foi bem-sucedida
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

	public function update_user($id, $data) {
		//Atualização dos dados do usuário de acordo com o ID
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }
}
