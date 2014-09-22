<?php
	
	class Websites_model extends CI_Model{

		public function __construct(){
		    parent::__construct();

		}

		public function site_exist($sitename){

			# Get the credentials from the database to populate the database below.
	    	$this->load->model('download_model');	

			$query = $this
						->download_model
						->get_site_credentials();

			$host = $query[0]->admin_host;
			$user = $query[0]->admin_user;
			$pass = $query[0]->admin_password;			

			# Load database so I can check that the install has been completed
			$config['hostname'] = $host;
			$config['username'] = $user;
			$config['password'] = $pass;
			$config['database'] = $sitename;
			$config['dbdriver'] = "mysql";
			$config['dbprefix'] = "";
			$config['pconnect'] = FALSE;
			$config['db_debug'] = TRUE;
			$config['cache_on'] = FALSE;
			$config['cachedir'] = "";
			$config['char_set'] = "utf8";
			$config['dbcollat'] = "utf8_general_ci";

			$DB3 = $this->load->database($config, true);

			# Check if the wp_option table exist
			if ($DB3->table_exists('wp_options')){

			  	//$query = $DB3
							//->get_where($sitename . '.wp_options', array('option_name' => 'template'));
				$query = 'not_empty';

			}	else {

				$query = 'empty';
			}			

			return $query;

		}

		public function wp_option_data($sitename){

			# Get the credentials from the database to populate the database below.
	    	$this->load->model('download_model');	

			$query = $this
						->download_model
						->get_site_credentials();

			$host = $query[0]->admin_host;
			$user = $query[0]->admin_user;
			$pass = $query[0]->admin_password;			

			# Load database so I can check that the install has been completed
			$config['hostname'] = $host;
			$config['username'] = $user;
			$config['password'] = $pass;
			$config['database'] = $sitename;
			$config['dbdriver'] = "mysql";
			$config['dbprefix'] = "";
			$config['pconnect'] = FALSE;
			$config['db_debug'] = TRUE;
			$config['cache_on'] = FALSE;
			$config['cachedir'] = "";
			$config['char_set'] = "utf8";
			$config['dbcollat'] = "utf8_general_ci";

			$DB3 = $this->load->database($config, true);

			if ($DB3->table_exists('wp_options')){

				$query = $DB3->get('wp_options');

				$query = $query->result();

			} else {
				$query = array('twit' => 'nube');	
			}

			return $query;

		}	

		public function active_plugins($sitename = ''){



			# Get the credentials from the database to populate the database below.
	    	$this->load->model('download_model');	

			$query = $this
						->download_model
						->get_site_credentials();

			$host = $query[0]->admin_host;
			$user = $query[0]->admin_user;
			$pass = $query[0]->admin_password;			

			# Load database so I can check that the install has been completed
			$config['hostname'] = $host;
			$config['username'] = $user;
			$config['password'] = $pass;
			$config['database'] = $sitename;
			$config['dbdriver'] = "mysql";
			$config['dbprefix'] = "";
			$config['pconnect'] = FALSE;
			$config['db_debug'] = TRUE;
			$config['cache_on'] = FALSE;
			$config['cachedir'] = "";
			$config['char_set'] = "utf8";
			$config['dbcollat'] = "utf8_general_ci";

			$DB3 = $this->load->database($config, true);

			if ($DB3->table_exists('wp_options')){

				$query = $DB3->get_where('wp_options', array('option_name' => 'active_plugins'));				

				$query = $query->result();

			} else {
				$query = array('twit' => 'nube');	
			}

			return $query;
		}	
	}/* End of Class */		


