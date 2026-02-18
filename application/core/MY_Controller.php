<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define('DEFAULT_JS', _APPNAME);
define('DEFAULT_CSS', _APPNAME);
define('COOKIE_NAME', _APPNAME);
define('COOKIE_USER_ID', 'USER_ID');

include('includes/miniutils.php');

define("LOG_INFO_MESSAGE", 0);
define("LOG_WARNING_MESSAGE", 1);
define("LOG_ERROR_MESSAGE", 2);
define("LOG_FATAL_MESSAGE", 3);
define("LOG_LOGIN_OK", 200);
define("LOG_LOGOUT", 201);
define("LOG_LOGIN_FAILED", 202);
define("LOG_LOGIN_USER_NOT_ACTIVATED", 203);
define("LOG_LOGIN_USER_NOT_EXIST", 204);
define("LOG_LOGIN_USER_IS_BLOCKED", 205);
define("LOG_USER_NOT_EXIST", 210);
define("LOG_LOGIN_ACTIVATION_MAIL_SEND", 211);
define("LOG_USER_ACTIVATED", 212);
define("LOG_ACTIVATION_TOKEN_ERROR", 213);
define("LOG_PASSWORD_RECOVERY_REQUEST", 214);
define("LOG_PASSWORD_RECOVERED", 215);
define("LOG_PASSWORD_TOKEN_ERROR", 216);

class MY_Controller extends CI_Controller
{
    public $config;

    public $ip_address, $user_id, $user, $social, $is_admin, $is_supervisor, $public_page, /*$readonly,*/
        $isauthpage = false;

    public $session;
    public $lang;
    public $input;
    public $encryption;
    public $auth_model;
    public $data;
    public $protesis_model;
    public $form_validation;

    function __construct()
    {
        parent::__construct();

        if (isset($this->lang)) {
            $this->lang->load('auth');
            $this->lang->load('header');
        }

        //$this->ip_address = get_real_ip();
        if (isset($this->input) && !empty($this->ip_address)) {
            $this->ip_address = $this->input->ip_address();
        }

        $this->load->model("auth_model");
        //$this->load->model('section_model');

        $this->getUser();
        $this->load->helper('security');

        $this->data['title'] = '';
        $this->data['description'] = '';

        // $this->data['url']			= base_url(uri_string());
        // $this->data['sections']		= $this->section_model->get_sections();
        $this->data['image'] = '';

        //$this->data['readonly']	= $this->readonly;

        $this->data['js'][] = DEFAULT_JS;
        $this->data['css'][] = DEFAULT_CSS;

        $this->public_page = true;

        //if (!$this->user_id && !$this->isauthpage) redirect("/auth");
    }

    function getUser()
    {
        // Si no existe al tabla de usuarios es que es la primera vez que se ejecuta, así que hay que generar las tablas
        if (!$this->auth_model->table_exists('users')) {
            $this->auth_model->checkTables(true);
            redirect('/');
        }

        $this->user_id = $this->session->userdata('user_id');
        if (!$this->user_id) {
            if ($this->user_id = $this->get_cookie(COOKIE_USER_ID)) {
                $this->session->set_userdata('user_id', $this->user_id);
            }
        }

        if (!$this->user_id) {
            $this->user_id = 0;
        }

        $this->user = $this->auth_model->get_user_by_id($this->user_id);
        $this->is_admin = isset($this->user['username']) && $this->auth_model->check_if_user_is($this->user['username'], USER_IS_ADMINISTRATOR);
        $this->is_supervisor = $this->is_admin || (isset($this->user['username']) && $this->auth_model->check_if_user_is($this->user['username'], USER_IS_SUPERVISOR));

        //$this->readonly = !$this->is_admin && $this->auth_model->check_if_user_is($this->user['username'], USER_IS_COMERCIAL);

        /*
        $this->social_id = $this->session->userdata('social_id');
        if (!isset($this->social_id) && isset($this->user)) $this->social_id=$this->user['social_id'];

        if ($this->social_id) $this->social = $this->auth_model->get_social_by_id($this->social_id);
        */
    }

    function get_cookie($name)
    {
        $cookies = $this->get_all_cookies();
        $result = (isset($cookies) && isset($cookies[$name]) ? $cookies[$name] : false);
        return $result;
    }

    function get_all_cookies()
    {
        $cookies = $this->input->cookie(COOKIE_NAME, TRUE);
        if (empty($cookies)) {
            return [];
        }
        $decoded = $this->encryption->decrypt($cookies);
        if (empty($decoded)) {
            return [];
        }
        $cookies = json_decode($decoded, TRUE);
        return $cookies;
    }

    /*
    function changeLanguage($language)
    {
        return base_url($this->lang->switch_uri($language));
    }
    */

    function set_cookie($name, $value, $time = 30 * (24 * 60 * 60))
    {
        $cookies = $this->get_all_cookies();
        if ($value == Null) {
            unset($cookies[$name]);
        } else {
            $cookies[$name] = $value;
        }
        $this->input->set_cookie(COOKIE_NAME, $this->encryption->encrypt(json_encode($cookies)), $time);
    }

}

class MY_Page_Controller extends MY_Controller
{

    public $items, $offset, $page, $total_pages;

    function __construct()
    {
        parent::__construct();

        $this->data['js'][] = 'responsive-paginate';

        $this->items = (isset($this->items) ? $this->items : 12);
        $this->page = (isset($_GET['page']) ? $_GET['page'] : 1);
    }

    public function view()
    {
        if (!isset($this->data['query'])) die ("Debe de asignarse a query el resultado de la consulta antes de llamar al view de MY_Page_Controller.");

        $this->offset = ($this->page - 1) * $this->items;
        $this->total_pages = ceil(count($this->data['query']) / $this->items);

        return array_slice($this->data['query'], $this->offset, $this->items, true);
    }

}