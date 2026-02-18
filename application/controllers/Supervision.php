<?php defined("BASEPATH" or die("El acceso al script no está permitido"));

class Supervision extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->is_supervisor) redirect('/');
        $this->public_page = false;

        $this->data['title'] = 'Supervisión de movimientos';
        $this->data['description'] = 'Supervisión de movimientos';
        $this->data['keywords'] = '';

        $this->data['css'][] = 'supervision';
        $this->data['js'][] = 'supervision';
        $this->load->model(array('protesis_model'));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->data['movimientos'] = $this->protesis_model->get_movimientos_pendientes();
    }

    public function index($orden = null, $id_centro = null, $id_familia = null, $id_proceso = null, $id_secuencia = null, $id_movimiento = null)
    {
        $page = 'index';

        $this->load->view('templates/header', $this->data);
        $this->load->view('supervision/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function validar($id)
    {
        $this->protesis_model->save_data(
            'movimientos',
            array(
                'id' => $id
            ),
            array(
                'id' => $id,
                'supervisado' => $this->user_id,
            )
        );
        redirect('supervision');
    }

    public function repetir($id_centro, $id_familia, $id_proceso, $id_secuencia, $id_movimiento)
    {
        if (isset($_POST['volver'])) {
            redirect("/ordenes/repetir/$id_centro/$id_familia/$id_proceso/$id_secuencia/$id_movimiento");
        }

        if (isset($_POST['orden'])) {
            $orden = $this->data['orden'] = $_POST['orden'];
            $this->data['expediente'] = $this->protesis_model->get_orden($orden);
        } else {
            $this->data['expediente'] = false;
        }

        $this->data['centro'] = $id_centro;
        $this->data['familia'] = $this->protesis_model->get_familia($id_familia);
        $this->data['proceso'] = $this->protesis_model->get_proceso($id_proceso);
        $this->data['secuencia'] = $this->protesis_model->get_secuencia($id_secuencia);
        $this->data['movimiento'] = $this->protesis_model->get_movimiento($id_movimiento);

        if (isset($_POST['buscar'])) {
            if ($this->data['expediente']) {
                $this->data['movimientos'] = $this->protesis_model->get_movimientos($_POST['orden'], true);    // true descendente
            } else {
                if (isset($orden)) $this->data['message'] = "La orden $orden no está dada de alta";
            }

        }

        if (isset($_POST['guardar'])) {
            $id_movimiento = $this->protesis_model->save_data(
                'movimientos',
                array('id'),
                array(
                    'id_orden' => $_POST['orden'],
                    'id_operador' => $this->user_id,
                    'id_centrocosto' => $id_centro, //$_POST['centrocosto'],
                    'id_familia' => $id_familia,
                    'id_proceso' => $id_proceso,
                    'id_secuencia' => $id_secuencia,
                    'unidades' => $_POST['cantidad'],
                    'duracion' => $_POST['duracion'],
                    'repetido' => isset($_POST['repetido']) ? (isset($_POST['fallointerno']) ? 2 : 1) : 0,
                    'supervisado' => $_POST['duracion'] == $this->data['secuencia']['duracion'] ? $this->user_id : 0,
                    'notas' => '"' . $_POST['notas'] . '"',
                )
            );
            redirect("/ordenes/repetir/$id_centro/$id_familia/$id_proceso/$id_secuencia/$id_movimiento");
        }

        $page = 'repetirorden';

        $this->load->view('templates/header', $this->data);
        $this->load->view('ordenes/' . $page, $this->data);
        $this->load->view('templates/footer');


        return;

        if (!isset($id_movimiento) && isset($_POST['id_movimiento'])) $id_movimiento = $_POST['id_movimiento'];
        if (isset($id_movimiento)) {
            if (isset($_POST['borrar'])) {
                $this->protesis_model->delete_data(
                    'movimientos',
                    array('id' => $id_movimiento)
                );
                redirect('/ordenes/index/' . $orden);
            }
            $this->data['movimiento'] = $this->protesis_model->get_movimiento($id_movimiento);
            $this->data['cantidad'] = $this->data['movimiento']['unidades'];
            $this->data['duracion'] = $this->data['movimiento']['duracion'];
            $this->data['repetido'] = $this->data['movimiento']['repetido'];
            $this->data['notas'] = $this->data['movimiento']['notas'];
        }

        if (isset($_POST['cancelar'])) {
            $this->set_cookie(COOKIE_USER_ID, Null, 0);    // De existir una cookie, se elimina
            $this->session->set_userdata('user_id', Null);
            redirect('/');
        }

        if (isset($id_secuencia)) {
            $this->data['secuencia'] = $this->protesis_model->get_secuencia($id_secuencia);
        }

        if (isset($_POST['guardar']) || isset($_POST['repetir'])) {
            $duracion = isset($this->data['secuencia']) && isset($this->data['secuencia']['duracion']) ? $this->data['secuencia']['duracion'] : -1;

            if (isset($id_movimiento)) {
                $this->protesis_model->save_data(
                    'movimientos',
                    array('id' => $id_movimiento),
                    array(
                        'id' => $id_movimiento,
                        'id_orden' => $orden,
                        'id_operador' => $this->user_id,
                        'id_centrocosto' => $id_centro, //$_POST['centrocosto'],
                        'id_familia' => $id_familia,
                        'id_proceso' => $id_proceso,
                        'id_secuencia' => $id_secuencia,
                        'unidades' => $_POST['cantidad'],
                        'duracion' => $_POST['duracion'],
                        'repetido' => isset($_POST['repetido']) ? (isset($_POST['fallointerno']) ? 2 : 1) : 0,
                        'supervisado' => $_POST['duracion'] == $duracion ? $this->user_id : 0,
                        'notas' => '"' . $_POST['notas'] . '"',
                    )
                );
                redirect('/ordenes/index/' . $orden);
            } else {
                $this->protesis_model->save_data(
                    'movimientos',
                    array('id'),
                    array(
                        'id_orden' => $orden,
                        'id_operador' => $this->user_id,
                        'id_centrocosto' => $id_centro, //$_POST['centrocosto'],
                        'id_familia' => $id_familia,
                        'id_proceso' => $id_proceso,
                        'id_secuencia' => $id_secuencia,
                        'unidades' => $_POST['cantidad'],
                        'duracion' => $_POST['duracion'],
                        'repetido' => isset($_POST['repetido']) ? (isset($_POST['fallointerno']) ? 2 : 1) : 0,
                        'supervisado' => $_POST['duracion'] == $duracion ? $this->user_id : 0,
                        'notas' => '"' . $_POST['notas'] . '"',
                    )
                );
            }

            if (isset($_POST['guardar'])) redirect('/');
            if (isset($_POST['repetir'])) redirect("/ordenes/repetir/$id_centro/$id_familia/$id_proceso/$id_secuencia");
        }

        if (!isset($orden) && isset($_POST['orden'])) $orden = $_POST['orden'];

        if (isset($orden) && ($orden != '')) {
            if ($orden == 0 || // Estamos en un guardar y repetir...
                $this->data['orden'] = $this->protesis_model->get_orden($orden)) {
                $this->data['centro'] = $id_centro;
                //$this->data['familia']=$id_familia;

                if (isset($id_proceso)) {
                    $this->data['secuencias'] = $this->protesis_model->get_secuencias_del_proceso($id_proceso);
                    $this->data['proceso'] = $this->protesis_model->get_proceso($id_proceso);
                }

                if (isset($id_familia)) {
                    $this->data['familia'] = $this->protesis_model->get_familia($id_familia);
                    $this->data['procesos'] = $this->protesis_model->get_procesos_de_la_familia($id_familia);
                } else {
                    if (isset($id_centro)) $this->data['familias'] = $this->protesis_model->get_familia_del_centro($id_centro);
                }

                if ($orden == 0) {
                    $this->data['orden']['id'] = 0;
                    $this->data['orden']['nombre'] = 'asigne una nueva orden para repetir';
                } else {
                    $this->data['movimientos'] = $this->protesis_model->get_movimientos($orden, true);    // true descendente
                }

                $page = 'editarorden';
            } else {
                $page = 'altaorden';
                $this->data['orden'] = $orden;
            }
        } else {
            if (isset($orden)) $this->data['message'] = 'Introduzca el número de orden';
            $page = 'index';
        }

        if (isset($centro)) $this->data['centro'] = $centro;

        $this->load->view('templates/header', $this->data);
        $this->load->view('ordenes/' . $page, $this->data);
        $this->load->view('templates/footer');

    }


    /*
    public function index($orden=null, $centro=null)
    {
        if (!$this->data['centros']) $this->data['message']='No hay centros de costo definidos';

        if (isset($_POST['cancelar']))
        {
            $this->set_cookie(COOKIE_USER_ID, Null, 0);	// De existir una cookie, se elimina
            $this->session->set_userdata('user_id', Null);
            redirect('/');
        }

        //if (isset($_POST['centro'])) $centro=key($_POST['centro']);

        if (!isset($orden) && isset($_POST['orden'])) $orden=$_POST['orden'];

        if (isset($orden) && ($orden != '') && isset($centro))
        {
            if($this->data['orden']=$this->protesis_model->get_orden($orden))
            {
                //redirect("/ordenes/itemorden/$orden/$centro");
                redirect("/ordenes/itemorden/$orden");
            }
            else
            {
                $page='altaorden';
                $this->data['orden']=$orden;
            }
        }
        else
        {
            //if (isset($centro)) $this->data['message']='Introduzca el número de orden, antes de seleccionar el centro de costo';
            $page='index';
        }

        if (isset($centro)) $this->data['centro']=$centro;

        $this->load->view('templates/header', $this->data);
        $this->load->view('ordenes/'.$page, $this->data);
        $this->load->view('templates/footer');
    }
    */

    function itemorden($orden/*, $centro*/)
    {
        if (isset($_POST['cancelar'])) redirect('ordenes');

        if (!$exp = $this->protesis_model->get_orden($orden)) redirect('ordenes');

        $this->data['orden'] = $exp;
        //$this->data['centro']=$centro;
        $this->data['familias'] = $this->protesis_model->get_familias();
        $this->data['subfamilias'] = $this->protesis_model->get_subfamilias();

        //if (!isset($_POST['centrocosto'])) $_POST['centrocosto']=$this->data['centros'][0]['id'];
        if (!isset($_POST['familia'])) $_POST['familia'] = $this->data['familias'][0]['id'];
        if (!isset($_POST['subfamilia'])) $_POST['subfamilia'] = $this->data['subfamilias'][0]['id'];

        $page = 'itemorden';
        $id_subfamilia = $this->protesis_model->get_subfamilia($_POST['familia'], $_POST['subfamilia']);
        if (isset($_POST['guardar']) && $id_subfamilia) {
            $this->protesis_model->save_data(
                'movimientos',
                array('id'),
                array(
                    'id_orden' => $orden,
                    'id_operador' => $this->user_id,
                    'id_centrocosto' => $centro, //$_POST['centrocosto'],
                    'id_familia' => $_POST['familia'],
                    'id_subfamilia' => $_POST['subfamilia'],
                    'unidades' => $_POST['cantidad'],
                    'duracion' => $_POST['duracion'],
                    'repetido' => isset($_POST['repetido']) ? (isset($_POST['fallointerno']) ? 2 : 1) : 0,
                )
            );
        }

        $this->data['secuencias'] = $this->protesis_model->get_secuencias($orden);

        $message = '';
        if (!$id_subfamilia) $message = 'Seleccione una familia y una subfamilia' . ($message == '' ? '' : '<br />');
        if ($message != '') $this->data['message'] = $message;

        $this->load->view('templates/header', $this->data);
        $this->load->view('ordenes/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function centros()
    {
        $this->data['centros'] = $this->protesis_model->get_centros();

        $page = 'centros';

        $this->load->view('templates/header', $this->data);
        $this->load->view('familias/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

//---

    public function familias()
    {
        $_familias = $this->protesis_model->get_familias();
        foreach ($_familias as $value) {
            $familias[$value['id']] = $value;
        }
        $this->data['familias'] = $familias;
        $this->data['subfamilias'] = $this->protesis_model->get_subfamilias();

        $page = 'familias';

        $this->load->view('templates/header', $this->data);
        $this->load->view('familias/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function nuevo()
    {
        $this->edit();
    }

    function edit($id /*, $centro */)
    {
        if (isset($_POST['cancelar'])) redirect('ordenes');

        if (isset($_POST['aceptar']))
            $this->protesis_model->save_data(
                'ordenes',
                array('id' => $id),
                array(
                    'id' => $id,
                    'nombre' => "'" . $_POST['nombre'] . "'",
                )
            );
        //redirect("/ordenes/index/$id/$centro");
        redirect("/ordenes/index/$id");
    }

    public function _edit($id = Null)
    {
        if (isset($_POST['cancelar'])) redirect('productos');

        if ($id) {
            $p = $this->protesis_model->get_producto($id);
            if (!$p) redirect('/productos');    // Vaya "algo" ha pasado que no he podido recuperar el producto solicitado
            $this->protect_close = true;
        } else {
            $id = $this->protesis_model->next_id('productos');
            $this->protesis_model->save_data(
                'productos',
                array('id' => $id),
                array(
                    'id' => $id,
                )
            );
            redirect('/productos/edit/' . $id);
        }
        $page = 'producto';

        $producto['id'] = $this->getpostdata($p, 'id');
        $producto['nombre'] = $this->getpostdata($p, 'nombre');
        $producto['foto'] = $this->getpostdata($p, 'foto');
        $producto['estado'] = $this->getpostdata($p, 'estado');
        $producto['minlargo'] = $this->getpostdata($p, 'minlargo');
        $producto['maxlargo'] = $this->getpostdata($p, 'maxlargo');
        $producto['minfondo'] = $this->getpostdata($p, 'minfondo');
        $producto['maxfondo'] = $this->getpostdata($p, 'maxfondo');

        $this->data['lineas'] = $this->protesis_model->get_lineas($id);
        $this->data['tipos'] = $this->protesis_model->get_tipos_madera();
        $this->data['series'] = $this->protesis_model->get_series();
        $this->data['material'] = $this->protesis_model->get_material();

        if (isset($_POST['guardar']) /*$this->form_validation->run() === true*/) {
            $id = $producto['id'];
            $nombre = $producto['nombre'];
            $foto = $producto['foto'];
            $estado = $producto['estado'];

            $this->protesis_model->save_data(
                'productos',
                array('id' => $id),
                array(
                    'nombre' => "'$nombre'",
                    'foto' => "'$foto'",
                    'estado' => $estado ? 1 : 0,
                )
            );

            $this->protesis_model->erase_lineas($id);

            foreach ($_POST['partida'] as $key => $value) {
                if ($_POST['elemento'][$key] != '') {
                    $this->protesis_model->save_data(
                        'lineas_producto',
                        array('id'),
                        array(
                            'id_producto' => $id,
                            'id_partida' => $_POST['partida'][$key],
                            'id_orden' => $_POST['orden'][$key],
                            'id_tipo' => $_POST['tipo'][$key],
                            'id_serie' => $_POST['serie'][$key],
                            'id_opcional' => isset($_POST['opcional'][$key]) ? 1 : 0,
                            'id_exclusion' => $_POST['exclusion'][$key],
                            'id_material' => $_POST['material'][$key],
                            'elemento' => '"' . $_POST['elemento'][$key] . '"',
                            'cantidad' => '"' . $_POST['cantidad'][$key] . '"',
                            'largo' => '"' . $_POST['largo'][$key] . '"',
                            'grueso' => $_POST['grueso'][$key],
                            'ancho' => $_POST['ancho'][$key],
                        )
                    );
                }
            }


            redirect('productos');
        }

        $this->data['producto'] = $producto;

        $this->load->view('templates/header', $this->data);
        $this->load->view('productos/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    function getpostdata($p, $id)
    {
        return isset($_POST[$id]) ? $_POST[$id] : (isset($p[$id]) ? $p[$id] : '');
    }

    public function import()
    {
        return;
        if (!$this->is_admin) redirect('familias');

        $dir = "import/";
        $ffile = "familias.csv";
        $sfile = "subfamilias.csv";
        $cfile = "centroscosto.csv";

        if (is_dir($dir)) {
            if (file_exists($dir . $ffile) && file_exists($dir . $sfile) && file_exists($dir . $cfile)) {
                if (ENVIRONMENT == 'development') $this->protesis_model->truncate_familias();

                // INCORPORACIÓN DEL FICHERO DE FAMILIAS

                $fp = fopen($dir . $ffile, "r");

                // Se lee la cabecera y se toman los nombres en el array $names

                $line = fgetcsv($fp, 0, ";"); // Leer la cabecera para comprobar los campos
                // $fields = array();	// Array con la posición de los campos
                $names = array();  // Array con los nombres de los campos
                $i = 0;
                foreach ($line as $nombre) {
                    $names[$i++] = $nombre;
                }

                // Se leen el resto de líneas del archivo, a registro por línea

                $r = 0;
                while ($line = fgetcsv($fp, 0, ";")) { // Mientras hay líneas que leer...
                    $data = array();

                    $i = 0;
                    $r++;
                    foreach ($line as $row) {
                        $data[$names[$i]] = addslashes($line[$i]);
                        $i++;
                    }

                    echo "<h5>Procesando familia " . $data['id'] . "-" . $data['nombre'] . "</h5>";

                    $this->protesis_model->save_data(
                        'familias',
                        array('id' => $data['id']),
                        array(
                            'id' => $data['id'],
                            'nombre' => "'" . $data['nombre'] . "'",
                            'estado' => $data['estado'],
                        )
                    );

                    unset($data);
                }
                fclose($fp);

                // INCORPORACIÓN DEL FICHERO DE DETALLES DE SUBFAMILIAS

                $fp = fopen($dir . $sfile, "r");

                $line = fgetcsv($fp, 0, ";"); // Leer la cabecera para comprobar los campos
                // $fields = array();	// Array con la posición de los campos
                $names = array();  // Array con los nombres de los campos
                $i = 0;
                foreach ($line as $nombre) {
                    $names[$i++] = $nombre;
                }

                $r = 0;
                while ($line = fgetcsv($fp, 0, ";")) { // Mientras hay líneas que leer...
                    $data = array();

                    $i = 0;
                    $r++;
                    foreach ($line as $row) {
                        $data[$names[$i]] = addslashes($line[$i]);
                        $i++;
                    }

                    echo "<h5>Procesando subfamilia " . $data['id'] . "-" . $data['nombre'] . "</h5>";

                    $this->protesis_model->save_data(
                        'subfamilias',
                        array(
                            'id' => $data['id'],
                        ),
                        array(
                            'id' => $data['id'],
                            'id_familia' => $data['id_familia'],
                            'nombre' => "'" . $data['nombre'] . "'",
                            'estado' => $data['estado'],
                        )
                    );

                    unset($data);
                }
                fclose($fp);

                // INCORPORACIÓN DEL FICHERO DE CENTROS DE COSTO

                $fp = fopen($dir . $cfile, "r");

                $line = fgetcsv($fp, 0, ";"); // Leer la cabecera para comprobar los campos
                // $fields = array();	// Array con la posición de los campos
                $names = array();  // Array con los nombres de los campos
                $i = 0;
                foreach ($line as $nombre) {
                    $names[$i++] = $nombre;
                }

                $r = 0;
                while ($line = fgetcsv($fp, 0, ";")) { // Mientras hay líneas que leer...
                    $data = array();

                    $i = 0;
                    $r++;
                    foreach ($line as $row) {
                        $data[$names[$i]] = addslashes($line[$i]);
                        $i++;
                    }

                    echo "<h5>Procesando centro de costo " . $data['id'] . "-" . $data['nombre'] . "</h5>";

                    $this->protesis_model->save_data(
                        'centroscosto',
                        array(
                            'id' => $data['id'],
                        ),
                        array(
                            'id' => $data['id'],
                            'nombre' => "'" . $data['nombre'] . "'",
                            'estado' => $data['estado'],
                        )
                    );

                    unset($data);
                }
                fclose($fp);
            } else {
                echo "No existen archivos $cfile o $dfile en $dir";
            }

        } else
            echo "No se encuentra el directorio $dir";
    }

}