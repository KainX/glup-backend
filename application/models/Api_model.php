<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function login($user, $pass){
		$result = $this->db->query("SELECT email FROM clientes WHERE email ='$user' AND password = '$pass'");
		if($result->num_rows()>0){
			return true;
		}
		return false;
	}
}
/* End of file Api_model.php */
/* Location: ./application/models/Api_model.php */