<?php if (!defined('BASEPATH')) die();

class Admin extends CI_Controller {

   public function index(){

		# Guess at what operting system WPS is being run on
		$data['local_os'] = $this->agent->platform();

		# Loaclhost settings
		$data['lh_port'] = $_SERVER["HTTP_HOST"];

	   	$this->load->model('common_model');
 
 		$data['list_sites'] = $this->common_model->list_sites();	

		$data['menu'] = 'templates/menubar';		
		$data['main_content'] = 'admin/database_settings';
		$this->load->view('include/template', $data);   		

   }

   public function display_settings(){

      	$this->load->model('common_model');
 
 		$data['list_sites'] = $this->common_model->list_sites();	

		$data['menu'] = 'templates/menubar';		
		$data['main_content'] = 'admin/display_settings';
		$this->load->view('include/template', $data);    		
   
   }

   public function reset(){

	   	$this->load->model('common_model');
	 
	 	$data['list_sites'] = $this->common_model->list_sites();   	

   		$data['menu'] = 'templates/menubar';		
		$data['main_content'] = 'admin/reset_settings';
		$this->load->view('include/template', $data); 	


   }

   public function back_up_code(){

	   	$this->load->model('common_model');
	 
	 	$data['list_sites'] = $this->common_model->list_sites();   	

		$data['menu'] = 'templates/menubar';		
		$data['main_content'] = 'admin/back_up_code';
		$this->load->view('include/template', $data); 		

   }

   public function set_database_settings(){

   		# Localhost settings
		$data['lh_port'] = $_SERVER["HTTP_HOST"];

	  # Global information
	    $host = 'localhost';
	    $user = $this->input->post('username');
	    $pass = $this->input->post('password');

	  # Just create the database and the table
	    $con = mysqli_connect("$host","$user","$pass");    
	    # Check connection
	      if (mysqli_connect_errno()){
	          echo "Failed to connect to MySQL: " . mysqli_connect_error();
	      }  

	    $db_name = 'wpadmin_localhost';
	  
	  # Create the database
	    $sql = 'CREATE DATABASE ' . $db_name;	    

	   if (mysqli_query($con,$sql)) {
	        $data['info'] = 'Information only: Database wpadmin_localhost created successfully';
	    } else {
	        
	        echo 'Information only: ' . mysqli_error($con) . "<br/>";
	    }    

	  # Create table
	    $sql = "CREATE TABLE $db_name.localhost_info(id INT NOT NULL DEFAULT '1', admin_host VARCHAR(30),admin_user VARCHAR(30),admin_password VARCHAR(30),PRIMARY KEY (id))";

	  # Execute query
	    if (mysqli_query($con,$sql))  {        
	        $data['table'] = 'Information only: Table localhost_info created successfully';
	    } else {    
	        echo 'Information only:' . mysqli_error($con) . ' Table localhost_info not created';
	    }

		 # Find out if there is already an entry
		    $sql = "SELECT * FROM $db_name.localhost_info WHERE admin_host = \"localhost\"";
		        
		    $getRow = mysqli_query($con,$sql) or die(mysqli_error($con));        
		           
		    $rows = mysqli_num_rows($getRow);

		  # Add the host, MySql User, MySql Password  to localhost_info
		    if($rows === 0){

		      $sql = 'INSERT INTO ' . $db_name . '.localhost_info (admin_host, admin_user, admin_password)VALUES (\'' . $host . '\', \'' . $user . '\',\'' . $pass . '\')';

		      if (mysqli_query($con,$sql))  {
		            
		          $data['credentials'] = 'Information only: localhost_info credentials entered successfully';
		      } else {
		          
		          echo '<h3>Warning</h3>';
		          
		          echo "" . mysqli_error($con) . ' Credentials not entered';
		    
		          unlink('./common/con_localhost.php');
		    
		      }    
		    }
		        
		    mysqli_close($con);

		    $host = "'$host'";
		   	$user = "'$user'";
		    $pass = "'$pass'";


		    # Create the con_localhost.php file
		    $file = "<?php\n
		    	function local_db_connect(){\n
				\t\$link = mysqli_connect(" . $host . ", " . $user . "," . $pass . ");\n
		    	\t\tif (!\$link) {\n
		    	\t\t\t\tdie('Could not connect: ' . mysqli_error());\n
				\t\t}\n
				\t\t\$db_selected = mysqli_select_db(\$link, 'wpadmin_localhost');\n
				\t\tif (!\$db_selected) {\n
				\t\t\t\tdie ('Cannot use foo : ' . mysqli_error());\n
				\t\t}\n
				\t\treturn (\$link);\n
				\t\t}\n
				\n?>";

		# Write the data to the file
		write_file('./common/con_localhost.php', $file);

		# See if the plugin database manager exists if it is not there create it.
		$this->load->dbutil();  		

  		# Check there is a database called wordpress_*******
		if (!$this->dbutil->database_exists('wordpress_default_plugins')){
		
			if ($this->dbforge->create_database('wordpress_default_plugins')){
			    $data['default_plugins'] = 'WordPress Default Plugins Database Created!';

				$con=mysqli_connect("localhost",$this->input->post('username'),$this->input->post('password'),"wordpress_default_plugins");
				# Check connection
				if (mysqli_connect_errno()) {
				  echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}

				# Create table
				$sql="CREATE TABLE default_plugins(id INT(11) auto_increment, PRIMARY KEY(id), plugin_name VARCHAR(255), plugin_path VARCHAR(255), checked VARCHAR(20))";

				# Execute query
				if (mysqli_query($con,$sql)) {
					$data['table'] = 'Default Plugins table created';
				} else {
					$data['table'] = 'Default Plugins NOT table created';
				}
			}
		} else {
				$con=mysqli_connect("localhost",$this->input->post('username'),$this->input->post('password'),"wordpress_default_plugins");
				# Check connection
				if (mysqli_connect_errno()) {
				  echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}

				# Create table
				$sql="CREATE TABLE default_plugins(id INT(11) auto_increment, PRIMARY KEY(id), plugin_name VARCHAR(255), plugin_path VARCHAR(255), checked VARCHAR(20))";

				# Execute query
				if (mysqli_query($con,$sql)) {
					$data['table'] = 'Default Plugins table created';
				} else {
					$data['table'] = 'Default Plugins NOT table created';
				}			   
			   $data['default_plugins'] = 'Default Plugins Created!';
		}

	   	$this->load->model('common_model');
	 
	 	$data['list_sites'] = $this->common_model->list_sites();		

		$data['menu'] = 'templates/menubar';	
		$data['main_content'] = 'admin/set_database_settings';
		$this->load->view('include/template', $data);

   }

   	public function remove_wps_settings(){

   		# Delete common/con_localhost.php
   		$filename = './common/con_localhost.php';
   		unlink($filename);

   		# Drop the database wpadmin_localhost
		$this->load->model('admin_model');
		$this
			->admin_model
			->drop_wps_database();

   		redirect('admin');

   	}

   	public function plugin_defaults(){

   		# Get all the default plugins that you have in the database
		$this->load->model('admin_model');
		
		$query = $this
					->admin_model
					->get_plugins();			


		$data['list_plugins'] = $query;

		$this->load->model('common_model');
	 
	 	$data['list_sites'] = $this->common_model->list_sites();

		$data['menu'] = 'templates/menubar';	
		$data['main_content'] = 'admin/list_plugins';
		$this->load->view('include/template', $data);
   	}

   	public function plugin_form(){

   		$plugin_name = urldecode($this->uri->segment(3));
   		if($plugin_name != ''){

   			$this->load->model('admin_model');

			# Get the details from the db to populate the fields
			$query = $this
						->admin_model
						->get_plugin_details($plugin_name); 

			foreach ($query as $value) {

				$data['plugin_name'] = $value->plugin_name;
				$data['plugin_path'] = $value->plugin_path;

				if($value->checked == 'checked'){
					
					$data['checked'] = 'TRUE';

				}	else{
					$data['checked'] = 'FALSE';
				}

			}

			$data['disabled'] = 'disabled';

   			$data['heading'] = 'Edit plugin details';
   			$data['submit_button'] = 'Update Plugin!';
			$data['controller_path'] = 'admin/update_plugin';

   		}	else {

			$data['plugin_name'] = '';
			$data['plugin_path'] = '';
			$data['checked'] 	 = '';
			$data['disabled'] 	 = '';


   			$data['heading'] = 'Add plugin details';
   			$data['submit_button'] = 'Add Plugin!';
			$data['controller_path'] = 'admin/add_plugin';	
   		}

		$this->load->model('common_model');
	 
	 	$data['list_sites'] = $this->common_model->list_sites();
	 	
		$data['menu'] = 'templates/menubar';	
		$data['main_content'] = 'admin/plugin_form';
		$this->load->view('include/template', $data);
 
   	}

   	# Add a plugin to the database
   	public function add_plugin(){

   		$plugin_name 	= $this->input->post('plugin_name');
   		$plugin_url		= $this->input->post('plugin_url');
   		$checked 		= $this->input->post('active');

   		if($checked == 'active'){
   			$checked = 'checked';
   		}

		$data['plugin_name'] 	= $plugin_name;
		$data['plugin_url'] 	= $plugin_url;
		$data['checked']		= $checked;


		$this->load->model('admin_model');

		$query = $this
					->admin_model
					->add_plugin($plugin_name, $plugin_url, $checked);


		redirect('admin/plugin_defaults');

   	}

   	# Delete the plugin from the db table
   	public function delete_plugin(){

   		$plugin_name = urldecode($this->uri->segment(3));

  		$this->load->model('admin_model');
 		
		$query = $this
					->admin_model
					->delete_plugin($plugin_name);

		# Make the name lowercase and underscore for spaces 
		$plugin_name = strtolower($plugin_name);
      	$plugin_name = preg_replace('/\s+/', '_', $plugin_name); 

		$path = './downloads/' . $plugin_name;		

		delete_files($path, true);

		rmdir($path);

		redirect('admin/plugin_defaults');

   	}

   	# Click on the update button
   	public function update_plugin(){


   		$plugin_name = $this->input->post('alt_name');
   		$plugin_path = $this->input->post('plugin_url');
   		$checked	 = $this->input->post('active');

   		if($checked == 'active'){

   			$checked = 'checked';
   		}

  		$this->load->model('admin_model');

   		$query = $this
   				->admin_model
   				->update_plugin($plugin_name, $plugin_path, $checked);


		redirect('admin/plugin_defaults');

   	}

   	# Quick update button on plugin list...
   	public function q_update(){

   		$plugin_name = urldecode($this->uri->segment(3));
   		$checked	 = $this->input->post('active');


   		echo $plugin_name;
   		echo 'To Be done';

   		//die();

  		/*$this->load->model('admin_model');

   		$query = $this
   				->admin_model
   				->update_plugin($plugin_name, $plugin_path, $checked);


		redirect('admin/plugin_defaults');*/

   	}

}// End of Admin controller

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
