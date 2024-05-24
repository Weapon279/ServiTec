<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function index()
	{
		$this->load->view('index');
	}
	public function servicios()
	{
		$this->load->view('servicios');
	}



}
