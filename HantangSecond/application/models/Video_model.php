<?php
class Video_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	public function get_video($title = FALSE){
		if($title === FALSE){
			$query = $this->db->get('video');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('video', array('title' => $title));
		return $query->row_array();
	}

	public function add_video($data){
		$this->load->helper('url');
		
		$this->db->where('title', $this->input->post('title'));
		$result_count = $this->db->count_all_results('video');
		
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
			
			return $this->db->insert('video', $data);
		}else{
			return 'existing name';
		}
	}

	public function update_video(){
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
		$this->db->update('video', $data);
	}

	public function delete_video($title = FALSE){
		$this->load->helper('url');
		
		if($title === FALSE){
			return 'title is null';
		}else{
			$this->db->where('titie', $title);
			$this->db->update('video', array('status' => 'false'));
		}
	}
}
?>