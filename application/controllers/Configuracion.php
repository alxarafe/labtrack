<?php

defined("BASEPATH" or die("El acceso al script no está permitido"));

class Configuracion extends MY_Controller
{
    public $users_model;

    public function __construct()
    {
        parent::__construct();

        if (!$this->is_admin) {
            redirect('/');
        }
        $this->public_page = false;

        $this->data['title'] = 'Configuración de la aplicación';
        $this->data['description'] = 'Configuración de la aplicación';
        $this->data['keywords'] = '';

        $this->data['css'][] = 'configuracion';
        $this->data['js'][] = 'configuracion';
        $this->load->model(array('protesis_model'));

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $page = 'index';

        $this->load->view('templates/header', $this->data);
        $this->load->view('configuracion/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function usuarios()
    {
        if (isset($_POST['cancelar'])) {
            redirect('configuracion');
        }

        $this->load->model(array('users_model'));

        $usuarios = $this->users_model->get_users(true);
        if (isset($_POST['guardar'])) {
            $arr = $_POST['id'];
            $res = array_diff($arr, array_diff(array_unique($arr), array_diff_assoc($arr, array_unique($arr))));
            $cad = '';
            foreach (array_unique($res) as $v) {
                $cad .= "Duplicado $v en la posicion: " . implode(', ', array_keys($res, $v)) . '<br />';
            }
            if ($cad != '') {
                unset($usuarios);
                $this->data['message'] = $cad;
                foreach ($_POST['oldid'] as $key => $value) {
                    $usuarios[$value] = array(
                        'oldid' => $value,
                        'id' => $_POST['id'][$key],
                        'username' => $_POST['nombre'][$key],
                        'admin' => isset($_POST['admin'][$key]) ? 1 : null,
                        'supervisor' => isset($_POST['supervisor'][$key]) ? 1 : null,
                        'active' => isset($_POST['off'][$key]) ? null : 1,
                    );
                }
            } else {
                foreach ($_POST['oldid'] as $key => $oldid) {
                    $id = $_POST['id'][$key];
                    $active = $_POST['nombre'][$key] != '' && !isset($_POST['off'][$key]);
                    $nombre = $_POST['nombre'][$key] != '' ? $_POST['nombre'][$key] : (isset($usuarios[$key]) ? $usuarios[$key]['username'] : 'Usuario #' . $key);
                    //$faccess=$_POST['fastaccess'][$key]!=''?$_POST['fastaccess'][$key]:(isset($usuarios[$key])?$usuarios[$key]['fastaccess']:'');
                    $faccess = $id;
                    $admin = isset($_POST['admin'][$key]) ? 1 : 0;
                    $supervisor = isset($_POST['supervisor'][$key]) ? 1 : 0;
                    $password = isset($usuarios[$key]) && $usuarios[$key]['password'] != '' ? $usuarios[$key]['password'] : md5('password');

                    if ($oldid > 0) {
                        $this->users_model->change_user_id($oldid, $id);
                    }

                    $this->users_model->save_data(
                        'users',
                        array('id' => $id),
                        array(
                            'id' => $id,
                            'username' => "'$nombre'",
                            'fastaccess' => "'$faccess'",
                            'password' => "'$password'",
                            'active' => $active ? 1 : 0,
                        )
                    );

                    $this->users_model->user_rol_active(1, $id, $admin);
                    $this->users_model->user_rol_active(2, $id, $supervisor);
                }
                /*
                foreach($_POST['id'] as $key=>$id) {
                    $active=$_POST['nombre'][$key]!='' && !isset($_POST['off'][$key]);
                    $nombre=$_POST['nombre'][$key]!=''?$_POST['nombre'][$key]:(isset($usuarios[$key])?$usuarios[$key]['username']:'Usuario #'.$key);
                    $faccess=$_POST['fastaccess'][$key]!=''?$_POST['fastaccess'][$key]:(isset($usuarios[$key])?$usuarios[$key]['fastaccess']:'');
                    $admin=isset($_POST['admin'][$key])?1:0;
                    $supervisor=isset($_POST['supervisor'][$key])?1:0;
                    $password=isset($usuarios[$key]) && $usuarios[$key]['password']!=''?$usuarios[$key]['password']:md5('password');

                    $this->users_model->save_data(
                        'users',
                        array('id'=>$id),
                        array(
                            'id'            => $id,
                            'username'      => "'$nombre'",
                            'fastaccess'    => "'$faccess'",
                            'password'      => "'$password'",
                            'active'        => $active?1:0,
                        )
                    );

                    $this->users_model->user_rol_active(1,$id,$admin);
                    $this->users_model->user_rol_active(2,$id,$supervisor);
                }
                */
                $usuarios = $this->users_model->get_users(true);
            }
        }

        $this->data['usuarios'] = $usuarios;

        $page = 'usuarios';

        $this->load->view('templates/header', $this->data);
        $this->load->view('configuracion/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function centros()
    {
        if (isset($_POST['cancelar'])) {
            redirect('configuracion');
        }

        $centros = $this->protesis_model->get_centros(true);
        if (isset($_POST['guardar'])) {
            foreach ($_POST['id'] as $key => $id) {
                $orden = $_POST['orden'][$key] == 0 ? $id : $_POST['orden'][$key];
                $active = $_POST['nombre'][$key] != '' && !isset($_POST['off'][$key]);
                $nombre = $_POST['nombre'][$key] != '' ? $_POST['nombre'][$key] : (isset($centros[$key]) ? $centros[$key]['nombre'] : '');
                $boton = $_POST['nombre_boton'][$key] == '' ? $nombre : $_POST['nombre_boton'][$key];
                $this->protesis_model->save_data(
                    'centroscosto',
                    array('id' => $id),
                    array(
                        'id' => $id,
                        'orden' => $orden,
                        'nombre' => "'$nombre'",
                        'nombre_boton' => "'$boton'",
                        'estado' => $active ? 1 : 0,
                    )
                );
            }
            $centros = $this->protesis_model->get_centros(true);
        }

        $this->data['centros'] = $centros;

        $page = 'centros';

        $this->load->view('templates/header', $this->data);
        $this->load->view('configuracion/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function familias($id = null)
    {
        if (isset($_POST['cancelar'])) {
            redirect('configuracion');
        }

        $centros = $this->protesis_model->get_centros(true);
        $familias = $this->protesis_model->get_familias(true);
        if (isset($_POST['guardar'])) {
            foreach ($_POST['id'] as $key => $id) {
                $id_centro = isset($_POST['centro'][$key]) && $_POST['centro'][$key] > 0 ? $_POST['centro'][$key] : 0;
                $orden = $_POST['orden'][$key] == 0 ? $id : $_POST['orden'][$key];
                $active = $_POST['nombre'][$key] != '' && !isset($_POST['off'][$key]);
                $nombre = $_POST['nombre'][$key] != '' ? $_POST['nombre'][$key] : (isset($centros[$key]['nombre']) ? $centros[$key]['nombre'] : "Centro #$key");
                $boton = $_POST['nombre_boton'][$key] == '' ? $nombre : $_POST['nombre_boton'][$key];
                $this->protesis_model->save_data(
                    'familias',
                    array('id' => $id),
                    array(
                        'id' => $id,
                        'id_centro' => $id_centro,
                        'orden' => $orden,
                        'nombre' => "'$nombre'",
                        'nombre_boton' => "'$boton'",
                        'estado' => $active ? 1 : 0,
                    )
                );
            }
            $familias = $this->protesis_model->get_familias(true);
        }

        $this->data['centros'] = $centros;
        $this->data['familias'] = $familias;

        $page = 'familias';

        $this->load->view('templates/header', $this->data);
        $this->load->view('configuracion/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function procesos($proceso_id = null)
    {
        if (isset($_POST['cancelar'])) {
            if (isset($proceso_id)) {
                redirect('configuracion/procesos');
            } else {
                redirect('configuracion');
            }
        }

        if (isset($proceso_id)) {
            $this->data['proceso'] = $this->protesis_model->get_proceso($proceso_id);

            $familias = $this->protesis_model->get_familias(true);
            $marcadas = $this->protesis_model->get_familias_del_proceso($proceso_id);

            $page = "select_families";

            if (isset($_POST['guardar'])) {
                $page = 'procesos';

                foreach ($familias as $value) {
                    $this->protesis_model->set_familia_proceso($value['id'], $proceso_id, isset($_POST['check'][$value['id']]));
                }

                $procesos = $this->protesis_model->get_procesos(true);
            }
        } else {
            $procesos = $this->protesis_model->get_procesos(true);
            if (isset($_POST['guardar'])) {
                foreach ($_POST['id'] as $key => $id) {
                    $orden = $_POST['orden'][$key] == 0 ? $id : $_POST['orden'][$key];
                    $active = $_POST['nombre'][$key] != '' && !isset($_POST['off'][$key]);
                    $nombre = $_POST['nombre'][$key] != '' ? $_POST['nombre'][$key] : (isset($centros[$key]) ? $centros[$key]['nombre'] : '');
                    $boton = $_POST['nombre_boton'][$key] == '' ? $nombre : $_POST['nombre_boton'][$key];
                    $this->protesis_model->save_data(
                        'procesos',
                        array('id' => $id),
                        array(
                            'id' => $id,
                            'orden' => $orden,
                            'nombre' => "'$nombre'",
                            'nombre_boton' => "'$boton'",
                            'estado' => $active ? 1 : 0,
                        )
                    );
                }
                $procesos = $this->protesis_model->get_procesos(true);
            }

            $page = 'procesos';
        }

        if (isset($familias)) {
            $this->data['familias'] = $familias;
        }
        if (isset($marcadas)) {
            $this->data['marcadas'] = $marcadas;
        }
        if (isset($procesos)) {
            $this->data['procesos'] = $procesos;
        }

        $this->load->view('templates/header', $this->data);
        $this->load->view('configuracion/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function secuencias($secuencia_id = null)
    {
        if (isset($_POST['cancelar'])) {
            if (isset($secuencia_id)) {
                redirect('configuracion/secuencias');
            } else {
                redirect('configuracion');
            }
        }

        if (isset($secuencia_id)) {
            $this->data['secuencia'] = $this->protesis_model->get_secuencia($secuencia_id);

            $procesos = $this->protesis_model->get_procesos(true);
            $marcados = $this->protesis_model->get_procesos_de_la_secuencia($secuencia_id);

            $page = "select_procesos";

            if (isset($_POST['guardar'])) {
                $page = 'secuencias';

                foreach ($procesos as $value) {
                    $this->protesis_model->set_proceso_secuencia($value['id'], $secuencia_id, isset($_POST['check'][$value['id']]));
                }

                $secuencias = $this->protesis_model->get_secuencias(true);
            }
        } else {
            $secuencias = $this->protesis_model->get_secuencias(true);
            if (isset($_POST['guardar'])) {
                foreach ($_POST['id'] as $key => $id) {
                    $orden = $_POST['orden'][$key] == 0 ? $id : $_POST['orden'][$key];
                    $active = $_POST['nombre'][$key] != '' && !isset($_POST['off'][$key]);
                    $nombre = $_POST['nombre'][$key] != '' ? $_POST['nombre'][$key] : (isset($secuencias[$key]) ? $secuencias[$key]['nombre'] : "Secuencia #$key");
                    $boton = $_POST['nombre_boton'][$key] == '' ? $nombre : $_POST['nombre_boton'][$key];
                    $duracion = $_POST['duracion'][$key] != '' ? $_POST['duracion'][$key] : (isset($secuencias[$key]) ? $secuencias[$key]['duracion'] : '');
                    $editable = isset($_POST['editable'][$key]) ? 1 : 0;
                    $this->protesis_model->save_data(
                        'secuencias',
                        array('id' => $id),
                        array(
                            'id' => $id,
                            'orden' => $orden,
                            'nombre' => "'$nombre'",
                            'nombre_boton' => "'$boton'",
                            'duracion' => $duracion,
                            'duracionedit' => $editable,
                            'estado' => $active ? 1 : 0,
                        )
                    );
                }
                $secuencias = $this->protesis_model->get_secuencias(true);
            }

            $page = 'secuencias';
        }

        if (isset($procesos)) {
            $this->data['procesos'] = $procesos;
        }
        if (isset($marcados)) {
            $this->data['marcados'] = $marcados;
        }
        if (isset($secuencias)) {
            $this->data['secuencias'] = $secuencias;
        }

        $this->load->view('templates/header', $this->data);
        $this->load->view('configuracion/' . $page, $this->data);
        $this->load->view('templates/footer');
    }


    /*
    public function familias()
    {
        $_familias=$this->protesis_model->get_familias();
        foreach($_familias as $value) {
            $familias[$value['id']]=$value;
        }
        $this->data['familias']=$familias;
        $this->data['subfamilias']=$this->protesis_model->get_subfamilias();

        $page='familias';

        $this->load->view('templates/header', $this->data);
        $this->load->view('familias/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function nuevo()
    {
        $this->edit();
    }

    function getpostdata($p, $id) {
        return isset($_POST[$id])?$_POST[$id]:(isset($p[$id])?$p[$id]:'');
    }

    public function edit($id=Null)
    {
        if (isset($_POST['cancelar'])) redirect('productos');

        if ($id)
        {
            $p=$this->protesis_model->get_producto($id);
            if (!$p) redirect('/productos');    // Vaya "algo" ha pasado que no he podido recuperar el producto solicitado
            $this->protect_close=true;
        }
        else
        {
            $id=$this->protesis_model->next_id('productos');
            $this->protesis_model->save_data(
                'productos',
                array('id'=>$id),
                array(
                    'id'            => $id,
                )
            );
            redirect('/productos/edit/'.$id);
        }
        $page='producto';

        $producto['id']=$this->getpostdata($p, 'id');
        $producto['nombre']=$this->getpostdata($p, 'nombre');
        $producto['foto']=$this->getpostdata($p, 'foto');
        $producto['estado']=$this->getpostdata($p, 'estado');
        $producto['minlargo']=$this->getpostdata($p, 'minlargo');
        $producto['maxlargo']=$this->getpostdata($p, 'maxlargo');
        $producto['minfondo']=$this->getpostdata($p, 'minfondo');
        $producto['maxfondo']=$this->getpostdata($p, 'maxfondo');

        $this->data['lineas']=$this->protesis_model->get_lineas($id);
        $this->data['tipos']=$this->protesis_model->get_tipos_madera();
        $this->data['series']=$this->protesis_model->get_series();
        $this->data['material']=$this->protesis_model->get_material();

        if (isset($_POST['guardar']) /*$this->form_validation->run() === true* /)
        {
            $id     = $producto['id'];
            $nombre = $producto['nombre'];
            $foto   = $producto['foto'];
            $estado = $producto['estado'];

            $this->protesis_model->save_data(
                'productos',
                array('id'=>$id),
                array(
                    'nombre'    => "'$nombre'",
                    'foto'      => "'$foto'",
                    'estado'    => $estado?1:0,
                )
            );

            $this->protesis_model->erase_lineas($id);

            foreach($_POST['partida'] as $key=>$value)
            {
                if ($_POST['elemento'][$key] != '')
                {
                    $this->protesis_model->save_data(
                        'lineas_producto',
                        array('id'),
                        array(
                            'id_producto'       => $id,
                            'id_partida'        => $_POST['partida'][$key],
                            'id_orden'          => $_POST['orden'][$key],
                            'id_tipo'           => $_POST['tipo'][$key],
                            'id_serie'          => $_POST['serie'][$key],
                            'id_opcional'       => isset($_POST['opcional'][$key])?1:0,
                            'id_exclusion'      => $_POST['exclusion'][$key],
                            'id_material'       => $_POST['material'][$key],
                            'elemento'          => '"'.$_POST['elemento'][$key].'"',
                            'cantidad'          => '"'.$_POST['cantidad'][$key].'"',
                            'largo'             => '"'.$_POST['largo'][$key].'"',
                            'grueso'            => $_POST['grueso'][$key],
                            'ancho'             => $_POST['ancho'][$key],
                        )
                    );
                }
            }


            redirect('productos');
        }

        $this->data['producto']=$producto;

        $this->load->view('templates/header', $this->data);
        $this->load->view('productos/'.$page, $this->data);
        $this->load->view('templates/footer');
    }
    */

    public function import()
    {
        if (!$this->is_admin) {
            redirect('familias');
        }

        $dir = "import/";
        $cfile = "centroscosto.csv";
        $ffile = "familias.csv";
        $pfile = "procesos.csv";
        $sfile = "secuencias.csv";

        if (is_dir($dir)) {
            if (
                file_exists($dir . $cfile) &&
                file_exists($dir . $ffile) &&
                file_exists($dir . $pfile) &&
                file_exists($dir . $sfile)
            ) {
                if (ENVIRONMENT == 'development') {
                    $this->protesis_model->truncate_familias();
                }

                // INCORPORACIÓN DEL FICHERO DE CENTROS DE COSTO

                $fp = fopen($dir . $cfile, "r");

                $line = fgetcsv($fp, 0, ";"); // Leer la cabecera para comprobar los campos
                // $fields = array();   // Array con la posición de los campos
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

                // INCORPORACIÓN DEL FICHERO DE FAMILIAS

                $fp = fopen($dir . $ffile, "r");

                // Se lee la cabecera y se toman los nombres en el array $names

                $line = fgetcsv($fp, 0, ";"); // Leer la cabecera para comprobar los campos
                // $fields = array();   // Array con la posición de los campos
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
                            'id_centro' => $data['id_centro'],
                            'nombre' => "'" . $data['nombre'] . "'",
                            'estado' => $data['estado'],
                        )
                    );

                    unset($data);
                }
                fclose($fp);

                // INCORPORACIÓN DEL FICHERO DE PROCESOS

                $fp = fopen($dir . $pfile, "r");

                $line = fgetcsv($fp, 0, ";"); // Leer la cabecera para comprobar los campos
                // $fields = array();   // Array con la posición de los campos
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

                    echo "<h5>Procesando proceso " . $data['id'] . "-" . $data['nombre'] . "</h5>";

                    $this->protesis_model->save_data(
                        'procesos',
                        array(
                            'id' => $data['id'],
                        ),
                        array(
                            'id' => $data['id'],
                            'nombre' => "'" . $data['nombre'] . "'",
                            'estado' => $data['estado'],
                        )
                    );

                    $familias = array_map('trim', explode(',', $data['id_familia']));
                    foreach ($familias as $familia) {
                        $this->protesis_model->set_familia_proceso($familia, $data['id'], 1);
                    }

                    unset($data);
                }
                fclose($fp);

                // INCORPORACIÓN DEL FICHERO DE SECUENCIAS

                $fp = fopen($dir . $sfile, "r");

                $line = fgetcsv($fp, 0, ";"); // Leer la cabecera para comprobar los campos
                // $fields = array();   // Array con la posición de los campos
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

                    echo "<h5>Procesando secuencia " . $data['id'] . "-" . $data['nombre'] . "</h5>";

                    $this->protesis_model->save_data(
                        'secuencias',
                        array(
                            'id' => $data['id'],
                        ),
                        array(
                            'id' => $data['id'],
                            'nombre' => "'" . $data['nombre'] . "'",
                            'duracion' => $data['duracion'],
                            'duracionedit' => $data['duracionedit'],
                            'estado' => $data['estado'],
                        )
                    );

                    $procesos = array_map('trim', explode(',', $data['id_proceso']));
                    foreach ($procesos as $proceso) {
                        $this->protesis_model->set_proceso_secuencia($proceso, $data['id'], 1);
                    }

                    unset($data);
                }
                fclose($fp);
            } else {
                echo "No existen archivos $cfile o $dfile en $dir";
            }
        } else {
            echo "No se encuentra el directorio $dir";
        }
    }
}
