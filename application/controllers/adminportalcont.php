<?php

class adminportalcont extends CI_Controller{

	public function __construct(){

		parent::__construct();

		$this->load->library('session');

		$this->load->helper('url');

		$this->load->model('adminportalmodel');
	}

	public function index(){

		$threshPriv = $this->session->userdata('threshpriv');

		if($this->session->userdata('privilege') < $threshPriv)

			$this->showHome();

		else{

			echo $this->load->view('templates/header.html', array(), TRUE);

			echo "<h2>You don't have the privileges to view this page. Contact Site Admin, if you think you should have privileges.</h2>";

			var_dump($this->session->all_userdata());
			
			echo $this->load->view('templates/footer.html', array(), TRUE);

			die;

		}

	}

	public function showHome(){

		$data = $this->adminportalmodel->homeData();

		$final_data = array('data'=>$data);

		$this->load->view('templates/header.html');
		$this->load->view('admin/adminportalview.php', $final_data);
		$this->load->view('templates/footer.html');

	}

	public function showPost($postid){

		$data = $this->adminportalmodel->postData($postid);

		// var_dump($data);

		$filename = $data['tempid'].'.cms';

		$filepath = POSTS_LOCATION.$filename;

		if(file_exists($filepath)){

			$output_arr = file($filepath);

			$output_arr = $output_arr[0];

			// echo '<br/><br/>Json Decoded array:<br/><br/>';

			$decodedString = json_decode($output_arr, true); // convert the Json encoded string to an array

			var_dump($decodedString);

			echo $decodedString['postcontent'];

			// $postArr = array_values($decodedString);

			// var_dump($postArr);

			// var_dump($output_arr);

			$final_data = array('data'=>$decodedString);

			$final_data = array_merge($final_data, array('postid'=>$postid));

			$this->load->view('templates/header.html');
			$this->load->view('admin/adminpostview.php', $final_data);
			$this->load->view('templates/footer.html');

		}

		else{

			echo "The post can't be found. Contact site admin.";

		}

	}

	public function editstatus($postid, $status){

		if($this->adminportalmodel->editstatus($postid, $status)){

			echo "<script>alert('Status changed successfully. Redirecting you to the admin portal.'); </script>";

			redirect('adminportalcont', 'refresh');

		}

		else{

			echo "<script>alert('Error. Please try again after some time.'); </script>";

			redirect('adminportalcont', 'refresh');
		}

	}
}
