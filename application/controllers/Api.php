<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function index(){
		$this->load->model('Api_model');
		$this->login();
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
}