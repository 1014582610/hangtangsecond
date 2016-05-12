<?php
  class Module_model extends CI_Model {
    public function __construct(){
      $this->load->database();
    }

    public function get_module($name = FALSE){
      if ($name === FALSE) {
        $query = $this->db->get('module');
        return $query->result_array();
      }

      $query = $this->db->get_where('module', array('name' => $name));
      return $query->row_array();
    }

    public function add_module(){
      $this->load->helper('url');
	  
	  $this->db->where('name', $this->input->post('name'));
	  $result_count = $this->db->count_all_results('module');
	  
	  if($result_count == 0){
		  
		$data = array(
			'name'=>$this->input->post('name'),
			'description'=>$this->input->post('description'),
			'page'=>$this->input->post('page'),
			'link'=>$this->input->post('link'),
			'contentnumber'=>$this->input->post('contentnumber')
		);
		
		return $this->db->insert('module', $data);

	  }else{
		  return 'existing name';
	  }
    }
	
	public function update_module(){
	    $this->load->helper('url');
		

		$data = array(
			'name'=>$this->input->post('name'),
			'description'=>$this->input->post('description'),
			'page'=>$this->input->post('page'),
			'link'=>$this->input->post('link'),
			'contentnumber'=>$this->input->post('contentnumber')
		);

		$this->db->where('name', $this->input->post('name'));
        $this->db->update('module', $data);
	}
	
	public function delete_module(){
		$this->load->helper('url');
		
		$this->db->where('name', $this->input->post('name'));
		$this->db->delete('module');
	}
  }
?>
