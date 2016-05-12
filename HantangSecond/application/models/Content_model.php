<?php
class Content_model extends CI_Model {
	public function __construct(){
		$this->load->database();
	}
	
	public function get_content($title = FALSE){
		if($title == FALSE){
			$query = $this->db->get('content');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('content', array('title' => $title));
		return $query->row_array();
	}
	
	public function add_content(){
		$this->load->helper('url');
		
		$this->db->where('title', $this->input->post('title'));
		$result_count = $this->db->count_all_results('content');
		
		if($result_count == 0){
			$data = array(
				'title' => $this->input->post('title'),
				'module_id' => $this->input->post('module_id'),
				'link' => $this->input->post('link'),
				'source_id' => $this->input->post('source_id'),
				'description' => $this->input->post('description'),
				'sequence' => $this->input->post('sequence')
			);
			
			return $this->db->insert('content', $data);
		}else{
			return 'existing name';
		}
	}
	
	public function update_content(){
		$this->load->helper('url');
		
		$data = array(
			'title' => $this->input->post('title'),
			'module_id' => $this->input->post('module_id'),
			'link' => $this->input->post('link'),
			'source_id' => $this->input->post('source_id'),
			'description' => $this->input->post('description'),
			'sequence' => $this->input->post('sequence')
		);
		
		$this->db->where('title', $this->input->post('title'));
		$this->db->update('content', $data);
	}
	
	public function delete_content(){
		$this->load->helper('url');
		
		$this->db->where('title', $this->input->post('title'));
		$this->db->delete('content');
	}
}
?>