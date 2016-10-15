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
		}
		
	}

	public function login(){
		$username = $this->input->post('user');
		$pass = $this->input->post('pass'); //This pass will be encrypted
		$data["DataType"] = $this->input->post('DataType'); //Get the DataType post data
		if(($status = $this->Api_model->login($username, $pass))){ //Get the result from the login function in Api_model.php
			$data["Status"] = "ok"; 
		}else{
			$data["Status"] = "error";
			$data["Msg"] = "Incorrect user or password";
		}
		echo json_encode($data); //Send the data encoded as JSON
	}

	public function registerUser(){
		$name = $this->input->post('name');
		$cel = $this->input->post('cel');
		$email = $this->input->post('email');
		$pass = $this->input->post('pass');
		$data["DataType"] = $this->input->post('DataType');
		if(($status = $this->Api_model->registerUser($name, $cel, $email, $pass))){
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
}