<?php
class Content extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('content_model');
		$this->load->helper('url_helper');
	}
	
	public function index()
	{
		$data['news'] = $this->content_model->get_content();

//		$this->load->view('templates/header', $data);
		$this->load->view('content/index', $data);
//		$this->load->view('templates/footer');
		//$this->load->view('welcome_message');
	}

	public function view($title = NULL){
		$data['content_item'] = $this->content_model->get_content($title);

		if (empty($data['content_item'])) {
			show_404();
		}

		$data['title'] = $data['content_item']['title'];

		$this->load->view('content/view', $data);
	}	
	
	public function add(){
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'title', 'required');		
		$this->form_validation->set_rules('module_id', 'module_id', 'required');
		$this->form_validation->set_rules('link', 'link', 'required');
		$this->form_validation->set_rules('source_id', 'source_id', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');
		$this->form_validation->set_rules('sequence', 'sequence', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('content/add');
		}
		else{
			$this->content_model->add_content();
			redirect(prep_url(site_url('/content/index')));
		}
	}
	
	public function update(){
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'title', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('content/update');
		}else{
			$this->content_model->update_content();
			redirect(prep_url(site_url('/content/index')));
		}
	}
	
	public function delete(){
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');	
		
		$this->form_validation->set_rules('title', 'title', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('content/delete');
		}else{
			$this->content_model->delete_content();
			redirect(prep_url(site_url('/content/index')));
		}
	}
	
}
?>