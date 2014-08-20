<?php

class newpostcont extends CI_Controller{

	public function __construct(){

		parent::__construct();

		$this->load->library('session');

		$this->load->helper('url');

		$this->load->model('newpostmodel');
	}

	public function index(){

		$this->write();
	}

	public function write(){

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->load->view('templates/header.html');
		$this->load->view('newpost/newpost.php');
		$this->load->view('templates/footer.html');
	}

	public function addpost(){

		echo 'We will talk with the model now.';

		if($this->newpostmodel->addNewPost()){

			echo "<script>alert('The blog post was added. One of our administrators will verify it, after which the	post will be shown online.')</script>";

			redirect('blogcont/', 'refresh');

		}


	}
}
