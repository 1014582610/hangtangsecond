<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'url_helper'));
		$this->load->model('video_model');
	}	
	
	public function index(){
		$data['videos'] = $this->video_model->get_video();
		$this->load->view('video/index', $data);
	}	
	
	public function view($title = NULL){
		$data['video_item'] = $this->video_model->get_video($title);
		
		if(empty($data['video_item'])){
			show_404();
		}
		
		$this->load->view('video/view', $data);
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
			$this->load->view('video/add');
		}else{			
			if(!$this->upload->do_upload()){   
				$this->load->view('video/add');
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
				
				$this->video_model->add_video($data);

				redirect(prep_url(site_url('/video/index')));
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
			$this->load->view('video/update');
		}else{
			$this->video_model->update_video();
			redirect(prep_url(site_url('/video/index')));
		}
	}	
	
	public function delete($title = NULL){
		if($title === NULL){
			return 'title is null';
		}else{
			$this->video_model->delete_video($title);
			redirect(prep_url(site_url('/video/index')));
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
		} 
		else
		{
			//$data = array('upload_data' => $this->upload->data());
			$error = array('error' => $this->upload->data('full_path'));
   
			//return $file_path;
			$this->load->view('video/upload', $error);
		}
	}
}
?>