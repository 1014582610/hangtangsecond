<?php

class Module extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('module_model');
		$this->load->helper('url_helper');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		$data['news'] = $this->module_model->get_module();
		$data['title'] = "Test Module";

//		$this->load->view('templates/header', $data);
		$this->load->view('module/index', $data);
//		$this->load->view('templates/footer');
		//$this->load->view('welcome_message');
	}

	public function view($id = NULL){
		$data['module_item'] = $this->module_model->get_module($id);

		if (empty($data['module_item'])) {
			show_404();
		}

		$data['title'] = $data['module_item']['name'];

		$this->load->view('module/view', $data);
	}

  public function add(){
	  
    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->library('form_validation');

    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('description', 'Description', 'required');
    $this->form_validation->set_rules('page', 'Page', 'required');
    $this->form_validation->set_rules('link', 'Link', 'required');
    $this->form_validation->set_rules('contentnumber', 'Contentnumber', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->load->view('module/add');
    }
    else {
      echo $this->module_model->add_module();
      //redirect(prep_url(site_url('/module/index')));
    }
  }
  
  public function update(){
	$this->load->helper('url');
    $this->load->helper('form');
    $this->load->library('form_validation');
	
	$this->form_validation->set_rules('name', 'Name', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->load->view('module/update');
    }
    else {
      $this->module_model->update_module();
      redirect(prep_url(site_url('/module/index')));
    }
  }
  
  public function delete(){
	$this->load->helper('url');
    $this->load->helper('form');
    $this->load->library('form_validation');
	
	$this->form_validation->set_rules('name', 'Name', 'required');
	
	if ($this->form_validation->run() === FALSE){
		$this->load->view('module/delete');
	}
	else{
		$this->module_model->delete_module();
		redirect(prep_url(site_url('/module/index')));
	}
  }
}
