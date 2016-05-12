<?php
class Picture_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function get_picture($title = FALSE){
		if($title === FALSE){
			$query = $this->db->get('picture');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('picture', array('title' => $title));
		return $query->row_array();
	}
	
	public function add_picture($data){
		$this->load->helper('url');
		
		$this->db->where('title', $this->input->post('title'));
		$result_count = $this->db->count_all_results('picture');
		
		//某些字段可能需要修改传入方式，或者删除
		if($result_count == 0){
			//$data = array(
			//	'title' => $this->input->post('title'),
			//	'page' => $this->input->post('page'),
			//	'address' => $this->input->post('address'),
			//	'preview' => $this->input->post('preview'),
			//	'status' => 'true',
			//	'description' => $this->input->post('description')
			//);
			
			return $this->db->insert('picture', $data);
		}else{
			return 'existing name';
		}
	}
	
	public function update_picture(){
		$this->load->helper('url');

		$data = array(
			'title' => $this->input->post('title'),
			'page' => $this->input->post('page'),
			'address' => $this->input->post('address'),
			'preview' => $this->input->post('preview'),
			'status' => 'true',
			'description' => $this->input->post('description')
		);
		
		$this->db->where('title', $this->input->post['title']);
		$this->db->update('picture', $data);
	}
	
	public function delete_picture($title = FALSE){
		$this->load->helper('url');
		
		if($title === FALSE){
			return 'title is null';
		}else{
			$this->db->where('titie', $title);
			$this->db->update('picture', array('status' => 'false'));
		}
	}
}
?>