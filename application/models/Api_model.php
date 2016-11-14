<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	/*
	public function login($user, $pass){
		$result = $this->db->query("SELECT email FROM clientes WHERE email ='$user' AND password = '$pass'");
		if($result->num_rows()>0){
			return true;
		}
		return false;
	}
	*/
	public function registerUser($name, $cel, $email, $pass){
		$result = $this->db->query("INSERT INTO clientes(clientes_nombre, celular, email, password) VALUES('$name', '$cel', '$email', '$pass')") or die(mysql_error());
		if($result){
			return true;
		}
		return false;
	}

	public function getAllProducts(){
		$result = $this->db->query("SELECT * FROM productos");
		return $result;
	}

	public function login($user){
		$pass = $this->db->query("SELECT password, clientes_nombre FROM clientes WHERE email = '$user'");
		$row = $pass->row();
		return $row;
	}
}
/* End of file Api_model.php */
/* Location: ./application/models/Api_model.php */