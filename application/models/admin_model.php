<?php
	
	class Admin_model extends CI_Model{

	   public function __construct(){
	      parent::__construct();
	   }

		# Drop the wpadmin_localhost  db
		public function drop_wps_database(){

			$this->load->dbforge();
			$this->dbforge->drop_database('wpadmin_localhost');
		}

		# Get a list and detail of all the plugins in the wordpress_default_plugins db
		public function get_plugins(){

			# Get the credentials from the database to populate the database below.
	    	$this->load->model('download_model');	

			$query = $this
						->download_model
						->get_site_credentials();

			$host = $query[0]->admin_host;
			$user = $query[0]->admin_user;
			$pass = $query[0]->admin_password;				

			$config['hostname'] = "localhost";
		    $config['username'] = $user;
		    $config['password'] = $pass;
		    $config['database'] = "wordpress_default_plugins";
		    $config['dbdriver'] = "mysql";
		    $config['dbprefix'] = "";
		    $config['pconnect'] = FALSE;
		    $config['db_debug'] = TRUE;
		    $config['cache_on'] = FALSE;
		    $config['cachedir'] = "";
		    $config['char_set'] = "utf8";
		    $config['dbcollat'] = "utf8_general_ci";

		   	$db2 = $this->load->database($config,TRUE);

			$query = $db2->get('default_plugins');

			$query = $query->result();	

			return $query;   
		}

		public function add_plugin($plugin_name, $plugin_url, $checked){
			
			# Get the credentials from the database to populate the database below.
	    	$this->load->model('download_model');	

			$query = $this
						->download_model
						->get_site_credentials();

			$host = $query[0]->admin_host;
			$user = $query[0]->admin_user;
			$pass = $query[0]->admin_password;				

			$config['hostname'] = "localhost";
		    $config['username'] = $user;
		    $config['password'] = $pass;
		    $config['database'] = "wordpress_default_plugins";
		    $config['dbdriver'] = "mysql";
		    $config['dbprefix'] = "";
		    $config['pconnect'] = FALSE;
		    $config['db_debug'] = TRUE;
		    $config['cache_on'] = FALSE;
		    $config['cachedir'] = "";
		    $config['char_set'] = "utf8";
		    $config['dbcollat'] = "utf8_general_ci";

		   	$db2 = $this->load->database($config,TRUE);

			$data = array(
			   'plugin_name' => $plugin_name,
			   'plugin_path' => $plugin_url ,
			   'checked' => $checked
			);

			$db2->insert('default_plugins', $data); 
			
			return true;		

		}

		public function delete_plugin($plugin_name){

			# Get the credentials from the database to populate the database below.
	    	$this->load->model('download_model');	

			$query = $this
						->download_model
						->get_site_credentials();

			$host = $query[0]->admin_host;
			$user = $query[0]->admin_user;
			$pass = $query[0]->admin_password;				

			$config['hostname'] = "localhost";
		    $config['username'] = $user;
		    $config['password'] = $pass;
		    $config['database'] = "wordpress_default_plugins";
		    $config['dbdriver'] = "mysql";
		    $config['dbprefix'] = "";
		    $config['pconnect'] = FALSE;
		    $config['db_debug'] = TRUE;
		    $config['cache_on'] = FALSE;
		    $config['cachedir'] = "";
		    $config['char_set'] = "utf8";
		    $config['dbcollat'] = "utf8_general_ci";

		   	$db2 = $this->load->database($config,TRUE);			

			# Delete the plugin
			$db2->delete('default_plugins', array('plugin_name' => $plugin_name));

			return true;

		}

		public function get_plugin_details($plugin_name){

			# Get the credentials from the database to populate the database below.
	    	$this->load->model('download_model');	

			$query = $this
						->download_model
						->get_site_credentials();

			$host = $query[0]->admin_host;
			$user = $query[0]->admin_user;
			$pass = $query[0]->admin_password;				

			$config['hostname'] = "localhost";
		    $config['username'] = $user;
		    $config['password'] = $pass;
		    $config['database'] = "wordpress_default_plugins";
		    $config['dbdriver'] = "mysql";
		    $config['dbprefix'] = "";
		    $config['pconnect'] = FALSE;
		    $config['db_debug'] = TRUE;
		    $config['cache_on'] = FALSE;
		    $config['cachedir'] = "";
		    $config['char_set'] = "utf8";
		    $config['dbcollat'] = "utf8_general_ci";

		   	$db2 = $this->load->database($config,TRUE);

			$query = $db2->get_where('default_plugins', array('plugin_name' => $plugin_name));

			$query = $query->result();	

			return $query;   
		}

		public function update_plugin($plugin_name, $plugin_path, $checked){


			# Get the credentials from the database to populate the database below.
	    	$this->load->model('download_model');	

			$query = $this
						->download_model
						->get_site_credentials();

			$host = $query[0]->admin_host;
			$user = $query[0]->admin_user;
			$pass = $query[0]->admin_password;				

			$config['hostname'] = "localhost";
		    $config['username'] = $user;
		    $config['password'] = $pass;
		    $config['database'] = "wordpress_default_plugins";
		    $config['dbdriver'] = "mysql";
		    $config['dbprefix'] = "";
		    $config['pconnect'] = FALSE;
		    $config['db_debug'] = TRUE;
		    $config['cache_on'] = FALSE;
		    $config['cachedir'] = "";
		    $config['char_set'] = "utf8";
		    $config['dbcollat'] = "utf8_general_ci";

		   	$db2 = $this->load->database($config,TRUE);			

			$data = array(
			               'plugin_path' => $plugin_path,
			               'checked' => $checked
			            );

			$db2->where('plugin_name', $plugin_name);
			$db2->update('default_plugins', $data);

			return true;   
		}

	}// End of Admin_model