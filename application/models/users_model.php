<?php
	
	class Users_model extends CI_Model{

		public function __construct(){
		    parent::__construct();
		}		

		public function validate(){

		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', sha1($this->input->post('password')));
		$query = $this->db->get('users');

			if ($query->num_rows == 1) {

				return true;

			}
		}
	}

