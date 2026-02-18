<?php

class Index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->data['title'] = 'Identificación rápida de usuarios';
        $this->data['description'] = 'Escriba su código de usuario y pulse Intro';
        $this->data['keywords'] = '';
        $this->load->helper('form');
    }

    public function index()
    {
        if ($this->user_id) {
            $page = "logged";
            redirect('ordenes');
        } else {
            $page = "fastaccess";
            $fs = isset($_POST['username']) ? $_POST['username'] : false;
            if ($fs) {
                if ($user = $this->auth_model->get_user_by_fastaccess($fs)) {
                    if ($user['active'] == 1) {
                        $id_user = $user['id'];
                        $user = $user['username'];
                        $this->user_id = $id_user;
                        $this->session->set_userdata('user_id', $id_user);
                        $this->auth_model->log_entry(LOG_LOGIN_OK, "User $user logged correctly (fastaccess)");
                        redirect('ordenes');
                    } else {
                        $this->data['message'] = $user['username'] . ' está desactivado';
                    }
                }
            }
        }

        $this->load->view('templates/header', $this->data);
        $this->load->view('auth/' . $page, $this->data);
        $this->load->view('templates/footer', $this->data);
    }

}