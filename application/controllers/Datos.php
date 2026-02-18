<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datos extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->public_page = false;

        $this->load->model('bbdd_model');
    }

    public function index($_crear = false)
    {
        $crear = isset($_crear) && ($_crear == "actualizar");

        echo "<p>Modificación de la base de datos: <strong>" . ($crear ? "Sí" : "No") . "</strong>.</p>";

        $database = DATABASE;

        if ($this->bbdd_model->database_exists($database)) {
            $this->load->model('auth_model');
            $this->auth_model->checkTables($crear);
            $this->load->model('protesis_model');
            $this->protesis_model->checkTables($crear);
            die("Proceso finalizado");
        } else
            die("No existe la base de datos $database");
    }
}
