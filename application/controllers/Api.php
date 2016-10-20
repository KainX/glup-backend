<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function index(){
		$this->load->model('Api_model');
		$dataType = $this->input->post('DataType');
		if($dataType == "login"){
			$this->login();
		}else if($dataType == "registerUser"){
			$this->registerUser();
		}elseif ($dataType == "getAllProducts") {
			$this->getAllProducts();
		}elseif ($dataType == "encode") {
			$this->encode_string();
		}elseif ($dataType == "decode") {
			$this->decode_string();
		}else{
			echo "Invalid parama";
		}
		
	}

	public function login(){
		require_once('AES.php');		
		$aes = new AES();
		$encrypted_user = $this->input->post('user');
		$encrypted_pass = $this->input->post('pass');

		$username = $aes->decrypt($encrypted_user);
		$pass = $aes->decrypt($encrypted_pass);

		$data["DataType"] = $this->input->post('DataType'); //Get the DataType post data
		if(password_verify($pass, $this->Api_model->getHashPass($username))){//($status = $this->Api_model->login($username, $pass))){ //Get the result from the login function in Api_model.php
			$data["Status"] = "ok"; 
		}else{
			$data["Status"] = "error";
			$data["Msg"] = "Incorrect user or password";
		}
		echo json_encode($data); //Send the data encoded as JSON
	}

	public function registerUser(){
		require_once('AES.php');		
		$aes = new AES();
		$encrypted_name = $this->input->post('name');
		$encrypted_cel = $this->input->post('cel');
		$encrypted_email = $this->input->post('email');
		$encrypted_pass = $this->input->post('pass');

		$name = $aes->decrypt($encrypted_name);
		$cel = $aes->decrypt($encrypted_cel);
		$email = $aes->decrypt($encrypted_email);
		$pass = $aes->decrypt($encrypted_pass);
		$pass_hash = password_hash($pass, PASSWORD_DEFAULT); //Password is hashed before is stored in DB

		$data["DataType"] = $this->input->post('DataType');
		if(($status = $this->Api_model->registerUser($name, $cel, $email, $pass_hash))){
			$data["Status"] = "ok";
		}else{
			$data["Status"] = "error";
			$data["Msg"] = "Error registering new user, try again later";
		}
		echo json_encode($data);
	}

	public function getAllProducts(){
		$data["DataType"] = $this->input->post('DataType');
		$products = $this->Api_model->getAllProducts();
		if($products != false){
			if($products->num_rows()>0){
				$post = array();
				foreach ($products->result_array() as $row) {				
					$cat_id = $row['categorias_id'];
					$name = $row['productos_nombre'];
					$img_url = $row['foto_portada'];
					$post[] = array('cat_id' => $cat_id, 'name' => $name, 'img_url' => $img_url);
				}
				$data["Status"] = "ok";
				$data["Products"] = $post;
			}else{
				$data["Status"] = "error";
				$data["Msg"] = "Empty result";
			}
		}else{
			$data["Status"] = "error";
			$data["Msg"] = "Error retrieving info";
		}
		echo json_encode($data);
	}

	public function encode_string(){
		require_once('AES.php');	
		$aes = new AES();
		echo $aes->encrypt($this->input->post('str'));
	}

	public function decode_string(){
		require_once('AES.php');	
		$aes = new AES();
		echo $aes->decrypt($this->input->post('str'));
	}
/*
	public function pass(){
		$email = $this->input->post('email');
		$pass = $this->input->post('pass');
		if(password_verify($pass, $this->Api_model->prueba($email))){
			echo 'Correcto!';
		}else{
			echo 'Falló';
		}
		//echo password_hash("hola", PASSWORD_DEFAULT);
	}
	*/
}