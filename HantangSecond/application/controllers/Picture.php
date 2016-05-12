<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Picture extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'url_helper'));
		$this->load->model('picture_model');
	}
	
	public function index(){
		$data['pictures'] = $this->picture_model->get_picture();
		$this->load->view('picture/index', $data);
		//$this->load->view('picture/upload');
	}
	
	public function view($title = NULL){
		$data['picture_item'] = $this->picture_model->get_picture($title);
		
		if(empty($data['picture_item'])){
			show_404();
		}
		
		$this->load->view('content/view', $data);
	}
	
	public function add(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'gif|png|jpg';		
		$config['max_size'] = '100';
		$config['max_width'] = '4096';
		$config['max_height'] = '3072';
		
		$this->load->library('upload', $config);

		
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('page', 'page', 'required');
		//$this->form_validation->set_rules('address', 'address', 'required');
		//$this->form_validation->set_rules('preview', 'preview', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');

		if($this->form_validation->run() === FALSE){
			$this->load->view('picture/add');
		}else{
			//$this->picture_model->add_picture();
			
			
			if(!$this->upload->do_upload()){   
				$this->load->view('picture/add');
			} 
			else
			{
				$address = $this->upload->data('full_path');
				$data = array(
					'title' => $this->input->post('title'),
					'page' => $this->input->post('page'),
					'address' => $address,
					'preview' => 'test',
					'status' => 'true',
					'description' => $this->input->post('description')
				);
				
				$this->picture_model->add_picture($data);

				redirect(prep_url(site_url('/picture/index')));
			}
		}
	}
	
	public function update(){
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('page', 'page', 'required');
		$this->form_validation->set_rules('address', 'address', 'required');
		$this->form_validation->set_rules('preview', 'preview', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');

		if($this->form_validation->run() === FALSE){
			$this->load->view('picture/update');
		}else{
			$this->picture_model->update_picture();
			redirect(prep_url(site_url('/picture/index')));
		}
	}
	
	public function delete($title = NULL){
		if($title === NULL){
			return 'title is null';
		}else{
			$this->picture_model->delete_picture($title);
			redirect(prep_url(site_url('/picture/index')));
		}
	}
	
	function do_upload(){
		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'gif|png|jpg';
			
		$config['max_size'] = '100';
		$config['max_width'] = '4096';
		$config['max_height'] = '3072';
			
		$this->load->library('upload', $config);
			
		if(!$this->upload->do_upload()){
				
			$error = array('error' => $this->upload->display_errors());
   
			$this->load->view('picture/upload', $error);
		} 
		else
		{
			//$data = array('upload_data' => $this->upload->data());
			$error = array('error' => $this->upload->data('full_path'));
   
			//return $file_path;
			$this->load->view('picture/upload', $error);
		}
	}
	
	public function upload(){
		$this->load->view('picture/upload');
	}
}
?>