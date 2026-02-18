<?php

defined("BASEPATH") or die("El acceso al script no está permitido");

define("USER_IS_ADMINISTRATOR", 1);
define("USER_IS_SUPERVISOR", 2);

/* Válido en PHP 7
define("USER_ROLES", array(
    1=>'Administrador',
    2=>'Tomador',
    3=>'Maquetador',
    4=>'Comercial',
));
*/

define("USER_ROLES", serialize(array(
        1 => 'Administrador',
        2 => 'Usuario',)));

class Auth_model extends MY_Model
{
    public $user_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function loadStructure()
    {
        $this->bbddStructure = array(
            'users' => array(
                'fields' => array(
                    'id' => array('Type' => 'int(10) unsigned', 'Key' => 'PRI', 'Extra' => 'auto_increment'),
                    'username' => array('Type' => 'varchar(100)'),
                    'email' => array('Type' => 'varchar(100)'),
                    'fastaccess' => array('Type' => 'int(13)'),
                    'password' => array('Type' => 'varchar(255)'),
                    'register_date' => array('Type' => 'timestamp', 'Default' => 'CURRENT_TIMESTAMP'),
                    'active' => array('Type' => 'tinyint(1)', 'Null' => 'YES', 'Default' => 0),
                ),
                'keys' => array('username'),
                'values' => array(
                    array(
                        'id' => 1,
                        'username' => "'shdental'",
                        'email' => "'info@shdental.es'",
                        'password' => "'5f4dcc3b5aa765d61d8327deb882cf99'",
                        'active' => 1),
                    array(
                        'id' => 2,
                        'username' => "'rsanjoseo'",
                        'email' => "'info@rsanjoseo.com'",
                        'password' => "'5f4dcc3b5aa765d61d8327deb882cf99'",
                        'active' => 1),
                )
            ),
            'user_roles' => array(
                'fields' => array(
                    'user_id' => array('Type' => 'int(10) unsigned'),
                    'role_id' => array('Type' => 'int(10) unsigned'),
                ),
                'values' => array(
                    array('user_id' => 1, 'role_id' => 1),
                    array('user_id' => 2, 'role_id' => 1),
                )
            ),
            'log_file' => array(
                'fields' => array(
                    'id' => array('Type' => 'int(11) unsigned', 'Key' => 'PRI', 'Extra' => 'auto_increment'),
                    'user_id' => array('Type' => 'int(10) unsigned', 'Default' => 0),
                    'event_id' => array('Type' => 'tinyint(3) unsigned', 'Null' => 'YES', 'Default' => 0),
                    'ip_address' => array('Type' => 'varchar(15)'),
                    'message' => array('Type' => 'varchar(100)'),
                    'timestamp' => array('Type' => 'timestamp', 'Default' => 'CURRENT_TIMESTAMP'),
                ),
            ),
        );
    }

    function get_last_log($user_id, $lines = 50)
    {
        $data = $this->qry2array("
			SELECT a.id, a.event_id, a.ip_address, a.message, a.timestamp 
			FROM log_file a
			WHERE a.user_id=$user_id
			ORDER BY a.timestamp DESC
			LIMIT $lines");
        return count($data) > 0 ? $data : false;
    }

    function log_entry($code, $message)
    {
        $this->user_id = (int)$this->user_id;
        $query = $this->db->query("INSERT INTO log_file (user_id, event_id, ip_address, message) VALUES ($this->user_id, $code, '$this->ip_address', '" . addslashes($message) . "')");
        return ($query);
    }

    function exist_user($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return ($query->num_rows() > 0);
    }

    function check_if_user_is($username, $profile)
    {
        $sql = "
			SELECT b.role_id
			FROM users a, user_roles b
			WHERE 
			a.id=b.user_id AND 
			b.role_id=$profile AND
			a.username='$username'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $_profile = false;
        if (count($result) > 0) {
            $_profile = $result[0]['role_id'] == $profile;
        }
        return $_profile;
    }

    function get_user_roles($id)
    {
        $query = $this->db->query("
			SELECT c.name AS role 
			FROM users a, user_roles b, roles_lang c 
			WHERE 
			a.id=b.user_id AND 
			b.role_id=c.id AND 
			c.lang='" . $this->lang->lang() . "' AND 
			a.username='$username'");
        $result = $query->result_array();
        return $result;
    }

    function get_user_id($username)
    {
        $query = $this->db->query("SELECT id FROM users WHERE username='$username' OR email='$username'");
        $result = $query->result_array();
        $user = null;
        if (count($result) > 0) {
            $user = $result[0]['id'];
        }
        return $user;
    }

    function get_user($username)
    {
        $query = $this->db->query("SELECT username FROM users WHERE username='$username' OR email='$username'");
        $result = $query->result_array();
        $user = null;
        if (count($result) > 0) {
            $user = $result[0]['username'];
        }
        return $user;
    }

    function get_mail_and_token($user, $pass)
    {
        $query = $this->db->query("
		SELECT 
			a.username, a.email, b.auth_code 
		FROM users a, user_auth b 
		WHERE 
			a.username='$user' AND 
			a.password=md5('$pass') AND 
			a.id = b.user_id AND 
			a.active=0
		");
        $result = $query->result_array();
        return $result;
    }

    function get_email($username)
    {
        $query = $this->db->query("SELECT email FROM users WHERE username='$username'");
        $result = $query->result_array(MYSQL_ASSOC);
        $email = null;
        if (count($result) > 0) {
            $email = $result[0]['email'];
        }
        return $email;
    }

    function user_new_auth($username, $token)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        if ($user = $query->row_array()) {
            $this->db->where('user_id', $user['id']);
            $query = $this->db->get('user_auth');
            $auth = $query->row_array();

            if (count($auth) > 0) { // Existe el registro, cambiamos el auth por el nuevo
                $query = $this->db->query("UPDATE user_auth SET auth_code='$token' WHERE user_id=" . $user['id']);
                return $query;
            } else {
                $query = $this->db->query("INSERT INTO user_auth VALUES (" . $user['id'] . ", '$token user_auth')");
                return $query;
            }
        }
        return false;
    }

    function set_password($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        if ($user = $query->row_array()) {
            $query = $this->db->query("UPDATE users SET password=md5('$password') WHERE id=" . $user['id']);
            return $query;
        }
        return false;
    }

    function is_active($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        $user = $query->row_array();
        return (isset($user) && $user['active']);
    }

    function activate($username, $token)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        if ($user = $query->row_array()) {
            if (!$user['active']) {
                $this->db->where('user_id', $user['id']);
                $query = $this->db->get('user_auth');
                $auth = $query->row_array();

                if ($token == $auth['auth_code']) {
                    $this->db->where('id', $user['id']);
                    return $this->db->update('users', array('active' => 1));
                }
            }
        }
        return false;
    }

    function check_user_token($username, $token)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        if ($user = $query->row_array()) {
            $this->db->where('user_id', $user['id']);
            $query = $this->db->get('user_auth');
            $auth = $query->row_array();

            return ($token == $auth['auth_code']);
        }
        return false;
    }

    function chg_user($old_username, $username, $password, $email, $fastaccess)
    {
        return $this->runqry("UPDATE users SET username='$username', email='$email', fastaccess=$fastaccess" . ($password = "" ? "" : ", password='" . md5($password) . "'") . " WHERE username='$old_username'");
    }

    function new_user($username, $password, $email, $tokenauth)
    {
        $data = array(
            'username' => $username,
            'password' => md5($password),
            'email' => $email,
        );
        if ($ok = $this->db->insert('users', $data)) {
            $id = $this->db->insert_id();
            $data = array(
                'user_id' => $id,
                'auth_code' => $tokenauth,
            );
            $ok = $this->db->insert('user_auth', $data);
        }
        return $ok;
    }

    function login($usr, $pass)
    {
        $this->db->where('username', $usr);
        $this->db->where('password', md5($pass));
        $query = $this->db->get('users');

        if ($query->num_rows() == 0) :
            //usuario no existe
            return false;
        else :
            $user = $query->row_array();
            if ($user['active']) {
                return $user['id'];
            } else {
                return -$user['id'];
            }
        endif;
    }

    function get_user_by_id($user_id)
    {
        $user_id = (int)$user_id;
        $result = $this->qry2array("SELECT * FROM users WHERE id=$user_id");
        if ($result === false) {
            return false;
        }
        return (count($result) > 0 ? $result[0] : false);
    }

    function get_user_by_name($user_name)
    {
        $result = $this->qry2array("SELECT * FROM users WHERE username='$user_name'");
        return (count($result) > 0 ? $result[0] : false);
    }

    function get_user_by_fastaccess($fastaccess)
    {
        $result = $this->qry2array("SELECT * FROM users WHERE fastaccess=$fastaccess");
        if ($result === false) {
            return false;
        }
        return reset($result);
    }

    /*
        function get_social_by_user($user_id)
        {
            $result=$this->qry2array("SELECT * FROM user_social WHERE user_id=$user_id");
            return $result;
        }

        function get_social_by_id($id)
        {
            $result=$this->qry2array("SELECT * FROM user_social WHERE id=$id");
            return (count($result) > 0 ? $result[0] : false);
        }

        function set_user_to_social($id, $user_id)
        {
            return $this->runqry("UPDATE user_social SET user_id=$user_id WHERE id=$id");
        }
    */

    /*
        function slogin($data, $user_id)
        {
            $id = $this->save_data(
                'user_social',
                array(
                    'id_network' => $data->id_network,
                    'identifier' => "'$data->identifier'",
                ),
                array(
                    'id_network' => $data->id_network,
                    'identifier' => "'$data->identifier'",
                    'website' => "'$data->webSiteURL'",
                    'profile' => "'$data->profileURL'",
                    'photo' => "'$data->photoURL'",
                    'display_name' => "'$data->displayName'",
                    'first_name' => "'$data->firstName'",
                    'last_name' => "'$data->lastName'",
                    'email' => "'$data->email'",
                    'active' => 1,
                )
            );

            $social=$this->get_social_by_id($id);

            if (isset($user_id) && (($social['user_id']) == 0))
            {
                $this->set_user_to_social($id, $user_id);
                $social['user_id']=$user_id;

            }

            //return $social['user_id'];
            return $social;
        }
    */
}
