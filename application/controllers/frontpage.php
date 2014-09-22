<?php if (!defined('BASEPATH')) die();

class Frontpage extends Main_Controller {

   public function index(){

   	$this->load->model('common_model');
 
 	$data['list_sites'] = $this->common_model->list_sites();
	
	$data['menu'] = 'templates/menubar';		
	$data['main_content'] = 'frontpage';
	$this->load->view('include/template', $data);

	}
   
}
/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
