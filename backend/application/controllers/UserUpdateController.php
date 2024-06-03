<?php

class UserUpdateController extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->database();
        $this->load->model('User_model');
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            return;
        }

		$email = $this->input->post('email');

		// Verificação de email duplicado
        $this->db->where('email', $email);
        $this->db->where('id !=', $id); //Ignorar o usuário atual
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $response = array('success' => false, 'message' => 'O usuário com esse e-mail já existe no banco de dados.');
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $data = array(
            'nome' => $this->input->post('nome'),
            'telefone' => $this->input->post('telefone'),
            'email' => $email,
            'nascimento' => $this->input->post('nascimento'),
            'idade' => $this->input->post('idade'),
        );
		
        if (!empty($_FILES['imagem']['name'])) {
            $config['upload_path'] = './uploads/imagens/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['file_name'] = time() . '_' . $_FILES['imagem']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('imagem')) {
                $uploadData = $this->upload->data();
                $data['imagem'] = $uploadData['file_name'];
            } else {
                echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                return;
            }
        }

        $result = $this->User_model->update_user($id, $data);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Usuário atualizado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar usuário']);
        }
    }
}
  
