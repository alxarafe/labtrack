<?php

defined("BASEPATH") or die("El acceso al script no está permitido");

class Protesis_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function loadStructure()
    {
        $this->bbddStructure = array(
            'centroscosto' => array(
                'fields' => array(
                    'id' => array('Type' => 'int(10) unsigned', 'Key' => 'PRI', 'Extra' => 'auto_increment'),
                    'orden' => array('Type' => 'int(4) unsigned'),
                    'nombre' => array('Type' => 'varchar(100)'),
                    'nombre_boton' => array('Type' => 'varchar(100)'),
                    'estado' => array('Type' => 'tinyint(1)', 'Default' => 1),
                ),
            ),
            'familias' => array(
                'fields' => array(
                    'id' => array('Type' => 'int(10) unsigned', 'Key' => 'PRI', 'Extra' => 'auto_increment'),
                    'id_centro' => array('Type' => 'int(10) unsigned'),
                    'orden' => array('Type' => 'int(4) unsigned'),
                    'nombre' => array('Type' => 'varchar(100)'),
                    'nombre_boton' => array('Type' => 'varchar(100)'),
                    'estado' => array('Type' => 'tinyint(1)', 'Default' => 1),
                ),
            ),
            'procesos' => array(
                'fields' => array(
                    'id' => array('Type' => 'int(10) unsigned', 'Key' => 'PRI', 'Extra' => 'auto_increment'),
                    'orden' => array('Type' => 'int(4) unsigned'),
                    'nombre' => array('Type' => 'varchar(100)'),
                    'nombre_boton' => array('Type' => 'varchar(100)'),
                    'estado' => array('Type' => 'tinyint(1)', 'Default' => 1),
                ),
            ),
            'familias_procesos' => array(
                'fields' => array(
                    'id_familia' => array('Type' => 'int(10) unsigned'),
                    'id_proceso' => array('Type' => 'int(10) unsigned'),
                ),
            ),
            'secuencias' => array(
                'fields' => array(
                    'id' => array('Type' => 'int(10) unsigned', 'Key' => 'PRI', 'Extra' => 'auto_increment'),
                    'orden' => array('Type' => 'int(4) unsigned'),
                    'nombre' => array('Type' => 'varchar(100)'),
                    'nombre_boton' => array('Type' => 'varchar(100)'),
                    'duracion' => array('Type' => 'int(3) unsigned', 'Default' => 0),
                    'duracionedit' => array('Type' => 'int(1) unsigned', 'Default' => 0),
                    'repetida' => array('Type' => 'int(1) unsigned', 'Default' => 0),    // 0 no, 1 si, 2 si y facturable
                    'estado' => array('Type' => 'tinyint(1)', 'Default' => 1),
                ),
            ),
            'procesos_secuencias' => array(
                'fields' => array(
                    'id_proceso' => array('Type' => 'int(10) unsigned'),
                    'id_secuencia' => array('Type' => 'int(10) unsigned'),
                ),
            ),
            /*
            'costosecuencia' => array(
                'fields' => array(
                    'id'            => array('Type' => 'int(10) unsigned', 'Key' => 'PRI', 'Extra' => 'auto_increment'),
                    'id_costo'      => array('Type' => 'int(10)'),
                    'id_secuencia'  => array('Type' => 'int(10)'),
                    'id_familia'    => array('Type' => 'int(10)'),
                    'id_subfamilia' => array('Type' => 'int(10)'),
                    'estado'        => array('Type' => 'tinyint(1)', 'Default' => 1),
                ),
            ),
            */
            'ordenes' => array(
                'fields' => array(
                    'id' => array('Type' => 'int(10) unsigned', 'Key' => 'PRI', 'Extra' => 'auto_increment'),
                    'nombre' => array('Type' => 'varchar(50)'),
                ),
            ),
            'movimientos' => array(
                'fields' => array(
                    'id' => array('Type' => 'int(10) unsigned', 'Key' => 'PRI', 'Extra' => 'auto_increment'),
                    'id_operador' => array('Type' => 'int(10) unsigned'),
                    'id_orden' => array('Type' => 'int(10) unsigned'),
                    'id_centrocosto' => array('Type' => 'int(10) unsigned'),
                    'id_familia' => array('Type' => 'int(10) unsigned'),
                    'id_proceso' => array('Type' => 'int(10) unsigned'),
                    'id_secuencia' => array('Type' => 'int(10) unsigned'),
                    'hora' => array('Type' => 'timestamp', 'Default' => 'CURRENT_TIMESTAMP'),
                    'unidades' => array('Type' => 'int(5) unsigned'),
                    'duracion' => array('Type' => 'int(3) unsigned', 'Default' => 0),
                    'repetido' => array('Type' => 'int(1) unsigned', 'Default' => 0),    // 0 no, 1 si, 2 si y facturable
                    'supervisado' => array('Type' => 'int(10) unsigned', 'Default' => 0),    // 0 si necesita supervisión
                    'notas' => array('Type' => 'text'),
                ),
            ),
        );
    }

    /*
    INFORMACIÓN A GUARDAR AL TERMINAR CADA SECUENCIA:
        Secuencia, código.
        Cantidad
        Operario
        Fecha/hora
        Núm. Control orden de trabajo
        Centro de coste
        Familia
        Tiempo editable?
        Repetido, si/no
        Fallo interno
        Tiempo repetir producción si/no.

    INFORMES A SUMINISTRAR
        Orden de trabajo determinada, secuencias/tiempos/operarios/etc.
        Operarios, producción individualizada en un período determinado.
        Centro de costes, secuencias/tiempos invertidos en un período determinado.
    */

    public function truncate_familias()
    {
        $query = $this->db->query("TRUNCATE TABLE centroscosto");
        $query = $this->db->query("TRUNCATE TABLE familias");
        $query = $this->db->query("TRUNCATE TABLE procesos");
        $query = $this->db->query("TRUNCATE TABLE secuencias");
        $query = $this->db->query("TRUNCATE TABLE familias_procesos");
        $query = $this->db->query("TRUNCATE TABLE procesos_secuencias");
    }

    public function get_centros($todos = false)
    {
        return $this->qry2array('SELECT * FROM centroscosto' . ($todos ? '' : ' WHERE estado>0') . ' ORDER BY orden');
    }

    public function get_familias($todos = false)
    {
        return $this->qry2array('SELECT * FROM familias' . ($todos ? '' : ' WHERE estado>0') . ' ORDER BY orden');
    }

    public function get_familia($id)
    {
        $x = $this->qry2array('SELECT * FROM familias WHERE id=' . $id);
        return $x ? $x[0] : false;
    }

    public function get_familia_del_centro($centro)
    {
        return $this->qry2array("SELECT * FROM familias WHERE id_centro=$centro ORDER BY orden");
    }

    public function get_procesos_de_la_familia($id_familia)
    {
        return $this->qry2array("
SELECT * 
FROM familias_procesos a
LEFT JOIN procesos b ON a.id_proceso=b.id AND b.estado=1
WHERE a.id_familia=$id_familia
ORDER BY b.orden");
    }

    public function get_familias_del_proceso($id_proceso)
    {
        return $this->qry2array("
SELECT * 
FROM familias_procesos a
LEFT JOIN familias b ON a.id_familia=b.id AND b.estado=1
WHERE a.id_proceso=$id_proceso
ORDER BY b.orden");
    }

    public function get_secuencias_del_proceso($id_proceso)
    {
        return $this->qry2array("
SELECT * 
FROM procesos_secuencias a
LEFT JOIN secuencias b ON a.id_secuencia=b.id AND b.estado=1
WHERE a.id_proceso=$id_proceso
ORDER BY b.orden");
    }

    public function get_procesos_de_la_secuencia($id_secuencia)
    {
        return $this->qry2array("
SELECT * 
FROM procesos_secuencias a
LEFT JOIN procesos b ON a.id_proceso=b.id AND b.estado=1
WHERE a.id_secuencia=$id_secuencia
ORDER BY b.orden");
    }

    public function set_familia_proceso($id_familia, $id_proceso, $estado)
    {
        $this->runqry("DELETE FROM familias_procesos WHERE id_familia=$id_familia AND id_proceso=$id_proceso");
        if ($estado) {
            $this->runqry("INSERT INTO familias_procesos (id_familia, id_proceso) VALUES ($id_familia, $id_proceso)");
        }
    }

    public function set_proceso_secuencia($id_proceso, $id_secuencia, $estado)
    {
        $this->runqry("DELETE FROM procesos_secuencias WHERE id_proceso=$id_proceso AND id_secuencia=$id_secuencia");
        if ($estado) {
            $this->runqry("INSERT INTO procesos_secuencias (id_proceso, id_secuencia) VALUES ($id_proceso, $id_secuencia)");
        }
    }

    public function get_procesos($todos = false)
    {
        return $this->qry2array('SELECT * FROM procesos' . ($todos ? '' : ' WHERE estado>0') . ' ORDER BY orden');
    }

    public function get_proceso($id)
    {
        $x = $this->qry2array('SELECT * FROM procesos WHERE id=' . $id);
        return $x ? $x[0] : false;
    }

    public function get_secuencias($todos = false)
    {
        return $this->qry2array('SELECT * FROM secuencias' . ($todos ? '' : ' WHERE estado>0') . ' ORDER BY orden');
    }

    public function get_secuencia($id)
    {
        $x = $this->qry2array('SELECT * FROM secuencias WHERE id=' . $id);
        return $x ? $x[0] : false;
    }

    public function get_orden($id)
    {
        $x = $this->qry2array("SELECT * FROM ordenes WHERE id=$id");
        return $x ? $x[0] : false;
    }

    public function get_subfamilia($id_familia, $id_subfamilia)
    {
        $x = $this->qry2array("SELECT * FROM subfamilias WHERE id=$id_subfamilia AND id_familia=$id_familia");
        return $x ? $x[0] : false;
    }

    public function get_movimiento($id)
    {
        $x = $this->qry2array("SELECT * FROM movimientos WHERE id=$id");
        return $x ? $x[0] : false;
    }

    public function get_movimientos_detallados($id, $descendente = false)
    {
        return $this->qry2array("
		SELECT 
			a.*,
			ord.nombre as orden,
			usr.username as usuario,
			cc.nombre as centrocosto,
			fam.nombre as familia,
			sec.nombre as secuencia,
			proc.nombre as proceso,
			sup.username as supervisor
		FROM movimientos a
		LEFT OUTER JOIN users usr ON a.id_operador=usr.id
		LEFT OUTER JOIN ordenes ord ON a.id_orden=ord.id
		LEFT OUTER JOIN centroscosto cc ON a.id_centrocosto=cc.id
		LEFT OUTER JOIN familias fam ON a.id_familia=fam.id
		LEFT OUTER JOIN secuencias sec ON a.id_secuencia=sec.id
		LEFT OUTER JOIN procesos proc ON a.id_proceso=proc.id
		LEFT OUTER JOIN users sup ON a.supervisado=sup.id
		WHERE a.id_orden=$id
		ORDER BY a.hora " . ($descendente ? 'DESC' : 'ASC'));
    }

    public function get_movimientos($id, $descendente = false)
    {
        return $this->qry2array("
		SELECT 
			b.nombre as secuencia, a.*
		FROM movimientos a
		LEFT OUTER JOIN secuencias b ON a.id_secuencia=b.id
		WHERE a.id_orden=$id ORDER BY a.hora " . ($descendente ? 'DESC' : 'ASC'));
    }

    public function get_movimientos_pendientes($descendente = false)
    {
        $userid = $this->user_id;
        return $this->qry2array("
		SELECT 
			c.nombre as orden,
			b.nombre as secuencia, 
			a.*
		FROM movimientos a
		LEFT OUTER JOIN secuencias b ON a.id_secuencia=b.id
		LEFT OUTER JOIN ordenes c ON a.id_orden=c.id
		WHERE a.supervisado=0 ORDER BY a.hora " . ($descendente ? 'DESC' : 'ASC'));
    }

    public function get_user_report($user, $desde, $hasta)
    {
        if (is_array($user)) {
            $str = 'in (' . join(',', $user) . ')';
        } else {
            $str = "=$user";
        }
        /*
                return $this->qry2array("
                SELECT
                    a.*,
                    ord.nombre as orden,
                    usr.username as usuario,
                    cc.nombre as centrocosto,
                    fam.nombre as familia,
                    sec.nombre as secuencia,
                    proc.nombre as proceso,
                    sup.username as supervisor
                FROM movimientos a
                LEFT OUTER JOIN users usr ON a.id_operador=usr.id
                LEFT OUTER JOIN ordenes ord ON a.id_orden=ord.id
                LEFT OUTER JOIN centroscosto cc ON a.id_centrocosto=cc.id
                LEFT OUTER JOIN familias fam ON a.id_familia=fam.id
                LEFT OUTER JOIN secuencias sec ON a.id_secuencia=sec.id
                LEFT OUTER JOIN procesos proc ON a.id_proceso=proc.id
                LEFT OUTER JOIN users sup ON a.supervisado=sup.id
                WHERE a.id_operador $str AND a.hora BETWEEN '$desde' AND '$hasta 23:59:59'
                ORDER BY usuario, centrocosto, familia, secuencia, proceso
                ");
            }
        */
        return $this->qry2array("
		SELECT 
			a.*,
			ord.nombre as orden,
			usr.username as usuario,
			cc.nombre as centrocosto,
			fam.nombre as familia,
			sec.nombre as secuencia,
			proc.nombre as proceso,
			sup.username as supervisor
		FROM movimientos a
		LEFT OUTER JOIN users usr ON a.id_operador=usr.id
		LEFT OUTER JOIN ordenes ord ON a.id_orden=ord.id
		LEFT OUTER JOIN centroscosto cc ON a.id_centrocosto=cc.id
		LEFT OUTER JOIN familias fam ON a.id_familia=fam.id
		LEFT OUTER JOIN secuencias sec ON a.id_secuencia=sec.id
		LEFT OUTER JOIN procesos proc ON a.id_proceso=proc.id
		LEFT OUTER JOIN users sup ON a.supervisado=sup.id
		WHERE a.id_operador $str AND a.hora BETWEEN '$desde' AND '$hasta 23:59:59'
		ORDER BY usuario, centrocosto, secuencia, familia, proceso
		");
    }

//---

    public function erase_lineas($id)
    {
        $this->runqry("DELETE FROM lineas_producto WHERE id_producto=$id");
    }

    public function get_productos()
    {
        return $this->qry2array('SELECT * FROM productos WHERE estado>0');
    }

    public function get_tipos_madera()
    {
        return $this->qry2array('SELECT * FROM tipos_madera');
    }

    public function get_material($id = null)
    {
        if ($id) {
            $ret = $this->qry2array("SELECT * FROM tipos_material WHERE id=$id");
            return count($ret) > 0 ? $ret[0]['nombre'] : false;
        } else {
            return $this->qry2array('SELECT * FROM tipos_material');
        }
    }

    public function get_series()
    {
        return $this->qry2array('SELECT * FROM serie_productos');
    }

    public function get_producto($id)
    {
        $ret = $this->qry2array("SELECT * FROM productos WHERE id=$id");
        return count($ret) > 0 ? $ret[0] : false;
    }

    public function get_lineas($id)
    {
        return $this->qry2array("SELECT * FROM lineas_producto WHERE id_producto=$id ORDER BY id_partida, id_orden");
    }
}
