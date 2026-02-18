<?php
define('LOG_CHG_USER', 20);

defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends MY_Model
{

    public function loadStructure()
    {
    }

    public function get_users($inactives = false)
    {
        return $this->qry2array('
SELECT *, b.role_id as admin, c.role_id as supervisor
FROM users a 
LEFT OUTER JOIN user_roles b ON a.id=b.user_id AND b.role_id=1
LEFT OUTER JOIN user_roles c ON a.id=c.user_id AND c.role_id=2
' . ($inactives ? '' : 'WHERE active=1') . ' ORDER BY username');
    }

    function get_user_roles($id)
    {
        $_roles = $this->qry2array("SELECT role_id FROM user_roles WHERE user_id=$id");
        $roles = array();
        if ($_roles)
            foreach ($_roles as $rol)
                $roles[$rol['role_id']] = 1;
        $result = array();
        foreach (unserialize(USER_ROLES) as $key => $value) {    // Unserialize sólo es necesario en PHP v5. PHP v7 permite definir la constante como array
            $x = unserialize(USER_ROLES);    // PHP v5
            $result[$key] = array(
                'name' => $x[$key], //'name'=>USER_ROLES[$key],	// Sólo PHP v5
                'active' => isset($roles[$key]) ? 1 : 0
            );
        }
        return $result;
    }

    function change_user_id($oldid, $newid)
    {
        if ($oldid == $newid) return true;
        $exists = $this->get_username_by_id($newid);
        if ($exists) die("Ya existe el usuario con id $newid");

        $this->runqry("UPDATE log_file SET user_id=$newid WHERE user_id=$oldid");
        $this->runqry("UPDATE movimientos SET id_operador=$newid WHERE id_operador=$oldid");
        $this->runqry("UPDATE movimientos SET supervisado=$newid WHERE supervisado=$oldid");
        $this->runqry("UPDATE user_roles SET user_id=$newid WHERE user_id=$oldid");
        $this->runqry("UPDATE users SET id=$newid WHERE id=$oldid");
    }

    function get_username_by_id($user_id)
    {
        $query = $this->db->query("SELECT username FROM users WHERE id=$user_id");
        $result = $query->result_array();
        $user = Null;
        if (count($result) > 0) {
            $user = $result[0]['username'];
        }
        return $user;
    }

    public function user_status_active($user_id, $estado)
    {
        $this->runqry("UPDATE users SET active=$estado WHERE id=$user_id");
        $nombre = $this->get_username_by_id($user_id);
        $this->auth_model->log_entry(LOG_CHG_USER, "$nombre: " . ($estado == 1 ? "active=true" : "active=false"));
    }

    public function user_rol_active($role_id, $user_id, $estado)
    {
        $this->runqry("DELETE FROM user_roles WHERE user_id=$user_id AND role_id=$role_id");
        if ($estado) {
            $this->runqry("INSERT INTO user_roles (user_id, role_id) VALUES ($user_id, $role_id)");
        }
        $nombre = $this->get_username_by_id($user_id);
        $x = unserialize(USER_ROLES);
        $rol = "$role_id (" . $x[$role_id] . ')';
        //$rol="$role_id (".USER_ROLES[$role_id].')';
        $this->auth_model->log_entry(LOG_CHG_USER, "$nombre: " . ($estado == 1 ? "alta" : "baja") . " de rol " . $rol);
    }

    public function user_delete($user_id)
    {
        $nombre = $this->get_username_by_id($user_id);

        $this->runqry("DELETE FROM users WHERE id=$user_id");
        $this->runqry("DELETE FROM user_roles WHERE user_id=$user_id");

        $this->auth_model->log_entry(LOG_CHG_USER, "$nombre: Usuario eliminado");
    }

}