<?php

defined("BASEPATH" or die("El acceso al script no está permitido"));

define('SENDER_NAME', _APPNAME);
define('SENDER_EMAIL', 'info@rsanjoseo.com');

class Auth extends MY_Controller
{
// public static $PROVIDERS;

    function __construct()
    {
        $this->isauthpage = true;

        parent::__construct();

        $this->public_page = false;    // Esta página no debe de indexarse en los buscadores

        $this->data['title'] = lang('auth_title');
        $this->data['description'] = lang('auth_description');
        $this->data['keywords'] = lang('auth_keywords');

        $this->data['css'][] = 'auth';

        $this->load->model('auth_model');
        $this->load->helper('form');
        $this->load->library(array('session', 'form_validation'));

        $this->form_validation->set_message('required', lang('form_required'));
        $this->form_validation->set_message('is_unique', lang('form_is_unique'));
        $this->form_validation->set_message('alpha_numeric', lang('form_alpha_numeric'));
        $this->form_validation->set_message('numeric', lang('form_numeric'));
        $this->form_validation->set_message('min_length', lang('form_min_length'));
        $this->form_validation->set_message('max_length', lang('form_max_length'));
        $this->form_validation->set_message('matches', lang('form_matches'));
        $this->form_validation->set_message('valid_email', lang('form_valid_email'));
        $this->form_validation->set_message('user_mail_check', lang('form_is_unique'));
        $this->form_validation->set_message('password_check', lang('form_bad_password'));
    }

    public function user_mail_check($str)
    {
        if (($str == $this->user['username']) || ($str == $this->user['email'])) {
            return true;
        } else {
            $user = $this->auth_model->get_user_by_name($this->auth_model->get_user($str));
            return ($user == false);
        }
    }

    public function fastaccess_check($str)
    {
        $user = $this->auth_model->get_user_by_fastaccess($str);
        return ($user == false || $this->user['fastaccess'] == $str);
    }

    public function password_check($str)
    {
        return (md5($str) == $this->user['password']);
    }

    function index()
    {
        $this->login();
    }

    function login()
    {
        if ($user_id = $this->session->userdata('user_id')) {
            redirect('auth/edit', 'refresh');
        } else {
            $this->form_validation->set_rules('username', lang('form_username'), 'trim|required|min_length[4]|max_length[12]');
            //$this->form_validation->set_rules('password', lang('form_password'), 'required|trim|password|xss_clean');

            /*
            $this->form_validation->set_message('required',     lang('form_required'));
            $this->form_validation->set_message('min_length',   lang('form_min_length'));
            $this->form_validation->set_message('max_length',   lang('form_max_length'));
            */

            if ($this->form_validation->run()) {
                $user = strtolower($this->input->post('username'));
                $pass = $this->input->post('password');

                if ($id_user = $this->auth_model->login($user, $pass)) {
                    if ($id_user > 0) {
                        $this->user_id = $id_user;

                        /*
                        if (isset($social)) $this->auth_model->set_user_to_social($social['id'], $this->user_id);
                        */

                        $this->session->set_userdata('user_id', $id_user);
                        if ($this->input->post('remember-me')) {
                            $this->set_cookie(COOKIE_USER_ID, $id_user, 30 * (24 * 60 * 60));
                        } else {
                            $this->set_cookie(COOKIE_USER_ID, $id_user, 60 * 60);    // De existir una cookie, se elimina
                        }

                        //$this->data['username'] = $user;

                        $this->auth_model->log_entry(LOG_LOGIN_OK, "User $user logged correctly");

                        //redirect('main', 'refresh');
                        redirect('/', 'refresh');
                    } else {
                        $page = 'auth/login';
                        if ($_user = $this->auth_model->get_mail_and_token($user, $pass)) {
                            if (count($_user) > 0) {
                                $__user = $_user[0];
                                $this->send_activation_mail($__user['email'], $user, $__user['auth_code']);
                                $this->data['message'] = lang('auth_user_not_activated');
                                $this->auth_model->log_entry(LOG_LOGIN_USER_NOT_ACTIVATED, "Login fail! User $user not activated");
                            }
                        }
                    }
                } else {
                    if (ENVIRONMENT == 'development') {
                        echo "[$user=$pass(" . md5($pass) . ")]";
                    }
                    $this->data['message'] = lang('auth_user_not_authenticated');
                    $page = 'auth/login';
                    $this->auth_model->log_entry(LOG_LOGIN_FAILED, "Login fail! User $user");
                }
            } else {
                $page = 'auth/login';
            }
        }

        $this->getUser();

        $this->load->view('templates/header', $this->data);
        $this->load->view($page, $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    function send_activation_mail($email, $username, $tokenauth)
    {
        $url = base_url() . /*$this->lang->lang()  .*/
            "/auth/conf/$username/$tokenauth";
        $subject = lang('auth_email_user_confirmation');
        $message = "
		<p>" . lang('auth_email_user_confirmation2') . "</p>
		<p><a href='$url'>{unwrap}$url{/unwrap}</a></p>
		<p>" . lang('auth_email_user_confirmation3') . "</p>
		";

        return $this->sendmail($email, $subject, $message);
    }

    function sendmail($email, $subject, $body)
    {
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';

        $this->load->library('email');
        $this->email->initialize($config);

        $this->email->from(SENDER_EMAIL, SENDER_NAME);
        $this->email->to($email);
        if (ENVIRONMENT == 'development') {
            $this->email->cc('r_sanjose@hotmail.com');
        }

        $this->email->subject($subject);

        $message = '
<!DOCTYPE html>
<html lang="' . /*$this->lang->lang() .*/
            '">
<head>
<meta charset="utf-8">
<title>' . $subject . '</title>
</head>
<body>' . $body . '
<img src="' . base_url("img/logomail.png") . '" />
<p>' . lang('auth_email_noreply') . '</p>
</body>
</html>';

        $this->email->message($message);
        $result = $this->email->send();

        if (ENVIRONMENT == 'development') {
            echo $this->email->print_debugger();
        }

        return $result;
    }

    function newuser()
    {
    // Alta de usuario
        $pagina = 'contact';

        /*

        $this->form_validation->set_rules('username', lang('form_username'), 'trim|required|alpha_numeric|min_length[4]|max_length[12]|is_unique[users.username]');
        $this->form_validation->set_rules('password', lang('form_password'), 'trim|required|matches[passconf]');
        $this->form_validation->set_rules('passconf', lang('form_password2'), 'trim|required');
        $this->form_validation->set_rules('email', lang('form_email'), 'trim|required|valid_email|is_unique[users.email]');

        if($this->form_validation->run() === true) {
            $username = strtolower($this->input->post('username'));
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $tokenauth = md5(rand());

            $this->auth_model->new_user($username, $password, $email, $tokenauth);

            $this->user=$this->auth_model->get_user_by_name($username);

            if ($this->send_activation_mail($email, $username, $tokenauth))
            {
                $this->auth_model->log_entry(LOG_LOGIN_ACTIVATION_MAIL_SEND, "Activation mail sended for $username");
            }
            else
            {
                $this->auth_model->log_entry(LOG_ERROR_MESSAGE, "Sending activation mail error for $username");
            };

            $this->data['message'] = lang('auth_new_account_confirm');

            $pagina = 'login';
        } else {
            $pagina = 'newuser';
        }
        */

        $this->load->view('templates/header', $this->data);
        $this->load->view("auth/" . $pagina, $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    function reset($user = null, $auth = null)
    {
    // Reinicio de contraseña
        if ($user) {    // Se ha pasado un usuario, si ok, pedir contraseña
            $pagina = 'newpassword';
            $this->data['user'] = $user;
            $this->data['auth'] = $auth;

            if ($this->auth_model->check_user_token($user, $auth)) {
                /*
                $this->form_validation->set_rules('password', lang('form_password'), 'trim|required|matches[passconf]');
                $this->form_validation->set_rules('passconf', lang('form_password2'), 'trim|required');
                $this->form_validation->set_message('matches', lang('form_matches'));
                */
                if ($this->form_validation->run()) {
                    $pass = $this->input->post('password');
                    if ($this->auth_model->set_password($user, $pass)) {
                        $this->data['message'] = lang('auth_password_changed');
                        $this->auth_model->log_entry(LOG_PASSWORD_RECOVERED, "Password changed for $user");
                    } else {
                        $this->data['message'] = lang('auth_password_chg_error');
                        $this->auth_model->log_entry(LOG_ERROR_MESSAGE, "Error changing password for $user");
                    }
                    $pagina = "login";
                }
            } else {
                $this->data['message'] = lang('auth_token_error');
                $pagina = 'userpswlost';
                $this->auth_model->log_entry(LOG_PASSWORD_TOKEN_ERROR, "$user password recovery token error");
            }
        } else // Si no se ha pasado usuario, hay que pedir usuario o mail para reenviar enlace
        {
            $this->form_validation->set_rules('mail_name', lang('form_user_or_email'), 'trim|required');
            $pagina = 'userpswlost';

            if ($this->form_validation->run() === true) {
                $mail_name = $this->input->post('mail_name');
                $tokenauth = md5(rand());

                if ($username = $this->auth_model->get_user($mail_name)) {
                    $email = $this->auth_model->get_email($username);
                }

                if ($username && $email) {
                    if ($this->auth_model->user_new_auth($username, $tokenauth)) {
                        $to = $email;
                        $url = base_url() . $this->lang->lang() . "/auth/reset/$username/$tokenauth";
                        $subject = lang('auth_email_password');
                        $message = "
						<p>" . lang('auth_email_password1') . "</p>
						<p><a href='$url'>{unwrap}$url{/unwrap}</a></p>
						<p>" . lang('auth_email_password2') . "</p>
						<p>" . lang('auth_email_password3') . "</p>
						";

                        $this->sendmail($to, $subject, $message);
                        $this->auth_model->log_entry(LOG_PASSWORD_RECOVERY_REQUEST, "Password recovery request for $username");
                    } else {
                        $this->data['message'] = lang('auth_db_error');
                        $this->auth_model->log_entry(LOG_ERROR_MESSAGE, "Error requesting recovery password for $username");
                    }
                } else {
                    $this->data['message'] = lang('auth_user_not_found');
                    $this->auth_model->log_entry(LOG_LOGIN_USER_NOT_EXIST, "$mail_name don't exist");
                }
            }
        }
        $this->load->view('templates/header', $this->data);
        $this->load->view("auth/" . $pagina, $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    function conf($username = null, $token = null)
    {
        $pagina = "login";

        if (isset($username) && $this->auth_model->exist_user($username)) {
            if ($this->auth_model->is_active($username)) {
                $this->data['message'] = lang('auth_already_activated');
                $this->auth_model->log_entry(LOG_WARNING_MESSAGE, "$mail_name don\'t exist");
            } else {
                if ($this->auth_model->activate($username, $token)) {
                    $this->data['message'] = lang('auth_activated');
                    $this->auth_model->log_entry(LOG_USER_ACTIVATED, "$username has been activated");
                } else {
                    $this->data['message'] = lang('auth_token_error');
                    $this->auth_model->log_entry(LOG_ACTIVATION_TOKEN_ERROR, "$username don\'t has been activated");
                }
            }
        } else {
            $this->auth_model->log_entry(LOG_LOGIN_USER_NOT_EXIST, "$username don\'t exist");
            $this->data['message'] = lang('auth_user_not_found');
            $pagina = 'newuser';
        }

        $this->load->view('templates/header', $this->data);
        $this->load->view("auth/" . $pagina, $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    public function edit($_username = null)
    {
        $_username = urldecode($_username);

        $page = "edit";

        if (!$_username && isset($this->user)) {
            $_username = $this->user['username'];
        }

        if ($_username && ($this->user['username'] == $_username) || $this->is_admin) {
            $this->data['user'] = $this->auth_model->get_user_by_name($_username);
            //$this->data['social']=$this->auth_model->get_social_by_user($this->data['user']['id']);
        } else {
            $page = "denied";
        }

        $this->form_validation->set_rules('username', lang('form_username'), "trim|required|alpha_numeric|min_length[4]|max_length[12]|callback_user_mail_check");
        $this->form_validation->set_rules('password', lang('form_password'), 'trim|required|callback_password_check');
        $this->form_validation->set_rules('newpassword', lang('form_newpassword'), 'trim|matches[passconf]');
        $this->form_validation->set_rules('passconf', lang('form_password2'), 'trim');
        $this->form_validation->set_rules('email', lang('form_email'), 'trim|required|valid_email|callback_user_mail_check');
        $this->form_validation->set_rules('fastaccess', 'Acceso rápido', "trim|numeric|min_length[0]|max_length[13]|callback_fastaccess_check");

        if ($this->form_validation->run()) {
            $username = strtolower($this->input->post('username'));
            $password = ($this->input->post('newpassword') == "" ? $this->input->post('password') : $this->input->post('newpassword'));
            $email = $this->input->post('email');
            $fastaccess = $this->input->post('fastaccess');

            $this->auth_model->chg_user($_username, $username, $password, $email, $fastaccess);

            if ($password == "") {
                $this->auth_model->log_entry(LOG_INFO, "$_username (" . $this->user['email'] . ") as $username ($email)");
            } else {
                $this->auth_model->log_entry(LOG_INFO, "ChgPsw. $_username (" . $this->user['email'] . ") as $username ($email)");
            }

            redirect('auth/edit/' . $username);
        }


        $this->load->view('templates/header', $this->data);
        $this->load->view('auth/' . $page, $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    public function log($_username = null)
    {
        $page = "log";

        if (!$_username && isset($this->user)) {
            $_username = $this->user['username'];
        }

        if ($_username && ($this->user['username'] == $_username) || $this->is_admin) {
            $this->data['user'] = $this->auth_model->get_user_by_name($_username);
            //$this->data['social']=$this->auth_model->get_social_by_user($this->data['user']['id']);
            $this->data['log'] = $this->auth_model->get_last_log($this->user_id);
        } else {
            $page = "denied";
        }

        $this->load->view('templates/header', $this->data);
        $this->load->view("auth/$page", $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    public function logout()
    {
        if (isset($this->user) && $this->user !== false) {
            $user = $this->user['username'];
            $this->auth_model->log_entry(LOG_LOGOUT, "Logout: $user disconnected!");
            $this->data['message'] = lang('auth_logout');
        }
        $this->set_cookie(COOKIE_USER_ID, null, 0);    // De existir una cookie, se elimina
        $this->session->set_userdata('user_id', null);
        //$this->session->set_userdata('social_id', Null);

        $this->user = null;
        $this->is_admin = false;

        $this->load->view('templates/header', $this->data);
        $this->load->view("auth/fastaccess", $this->data);
        $this->load->view('templates/footer', $this->data);
    }
}
