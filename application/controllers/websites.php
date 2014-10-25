<?php if (!defined('BASEPATH')) die();

class Websites extends CI_Controller {

   public function index(){

   	   	$filename = './common/con_localhost.php';

   	   	# Check to see if the above exists. If not redirect to setting it up
		if(is_file($filename)){

	  	   	$this->load->model('common_model');
	 		$data['list_sites'] = $this->common_model->list_sites();
	 	
			$data['menu'] = 'templates/menubar';		
			$data['main_content'] = 'websites/new_set_up';
			$this->load->view('include/template', $data);
	   	}	else {

	   		redirect('admin');

	   	}
	}  

	public function develop(){

		# Gets a list of directorys which start with wordpress_
		$dirs = array_filter(glob('./wordpress_*'), 'is_dir');

		$i = 0;

		# Get the details of the installation
    	foreach($dirs as $value){

			# Remove the ./ from the front of the value
	      	$tmp_site = substr($value, 2);

	      	$installed_plugins = array_filter(glob('./' . $tmp_site . '/wp-content/plugins/*'), 'is_dir');

	      	$list_plugins = trim('');
						  			
			foreach ($installed_plugins as $value) {
					$list_plugins .= basename ($value) . '<br/>';
			}

	   		# Load the model
			$this->load->model('websites_model');
			// todo get the description for the plugin
			
			# Also see it I tell if it's activated in WordPress and put a blue marker againts it

			$query = $this
						->websites_model
						->active_plugins($tmp_site);

			//print_r($query);

			//$member_dep = unserialize($query[0]->option_value);

			//print_r($member_dep);

	      	# Get the sitename
	      	$sitename = substr($tmp_site, 10);


			
			# See if the wp_option table exists
			$query = $this
						->websites_model
						->site_exist($tmp_site);	

			# Get the data from the wp_option table
			$query_1 = $this
						->websites_model
						->wp_option_data($tmp_site);



			if($query == 'not_empty'){

				# Check to see if the child directory of this theme exists
				$child_path = './' . $tmp_site . '/wp-content/themes/' . $query_1[40]->option_value . '-child/';   

				//echo $child_path;
			
				if(!is_dir($child_path)){

					# Button to create child
					$child_anchor = '<button type="button" class="btn btn-info"><a id="child_anchor" href="' . base_url('websites/create_child/' . $tmp_site . '/' . $query_1[40]->option_value) . '">Create Child Directory?</a></button>';

				}	else{

					$child_anchor = nbs(4);
				}
					# Button to launch development environment
					$site_anchor = '<a id="dev_anchor" href="' . base_url('/'. $tmp_site . '/wp-admin/index.php') . '" target="_blank">Develop Site</a>';



				# Not empty
				# Build the container and table
				$data['sites']['not_empty' . $i] = 	'<div class="panel panel-default">
  									<!-- Default panel contents -->
						  			<div class="panel-heading">Project Title: ' . $sitename  . ' Description: ' . $query_1[3]->option_value . '</div>
						  				<div class="panel-body">
						    				<img src="../' . $tmp_site . '/wp-content/themes/' . $query_1[40]->option_value . '/screenshot.png"  data-toggle="tooltip" data-placement="top" data-title="' . $query_1[40]->option_value . '" width="152" height="114""/>
						  					<div id="plugin_list" data-toggle="tooltip" data-placement="top" data-title="Installed Plugins">' . $list_plugins . '</div>
						  			</div>

						  				<!-- Table -->
						  				<table class="table">
						    				<tr><td><button type="button" class="btn btn-info">' . $site_anchor . '</button></td><td>' . $child_anchor . '</td></tr>
						  				</table>
									</div>';
			}	else {
				# Empty
				$data['sites']['empty' . $i] = 	'<div class="panel panel-default">
  									<!-- Default panel contents -->
						  			<div class="panel-heading">Project Title: ' . $sitename  . ' Description: Install it!!!</div>
						  				<div class="panel-body">
						    				<img src="../images/black_sheep.jpg" data-toggle="tooltip" data-placement="top" data-title="Black Sheep" width="100" height="100"/>
							  			<div id="plugin_list" data-toggle="tooltip" data-placement="top" data-title="Installed Plugins">' . $list_plugins . '</div>
						  			</div>

						  				<!-- Table -->
						  				<table class="table">
						    				<tr>
							    				<td><button type="button" class="btn btn-info">
							    				<a id="inst_anchor" href="/wps" onclick="window.open(\'' . base_url('/'. $tmp_site . '/wp-admin/install.php') . '\');">Finish Installation</a>
							    				</button></td>
							    				<td>' . nbs(1) . '</td>
						    				</tr>
						  				</table>
									</div>';			
			}
      		$i++;
      	}

	   	$this->load->model('common_model');
	 
	 	$data['list_sites'] = $this->common_model->list_sites();

		$data['menu'] = 'templates/menubar';		
		$data['main_content'] = 'websites/develop';
		$this->load->view('include/template', $data);		

	}

	public function back_up(){

		#


	   	$this->load->model('common_model');
	 
	 	$data['list_sites'] = $this->common_model->list_sites();		

		$data['menu'] = 'templates/menubar';		
		$data['main_content'] = 'websites/list_to_make_live';
		$this->load->view('include/template', $data);		

	}

	public function display_site_list(){


		$this->load->model('common_model');
 
 		$data['list_sites'] = $this->common_model->list_sites();


		$data['menu'] = 'templates/menubar';		
		$data['main_content'] = 'websites/remove_list';
		$this->load->view('include/template', $data);
	}

	public function remove_sites(){

		# Checkbox array of sites to be deleted.
		$sites_to_del = $this->input->post('sitename');

		 if(empty($sites_to_del)){

		 	# Array is empty and will do nothing
		 	redirect('websites/display_site_list');
		 }	else{

			# One or more files have been selected for deletion
		 	foreach ($sites_to_del as $key => $value) {

		 		$this->delete_existing_site($value);
		 	}

		 	redirect('websites/display_site_list');

		 }
	}

	public function install(){

		# Check to see if there are any plugins that need to be installed
		# If not Ask if they want to set some up.
		$this->load->model('download_model');

		$plugins = $this->download_model->get_plugin_paths();

		if(empty($plugins)){
			# Empty
			$data['no_plugins_installed'] = 0;

		}	else{
			$data['no_plugins_installed'] = 1;

		}

		# Form Validation for sitname field is required
		$this->form_validation->set_rules('sitename', 'Site Name', 'required');	
		
		# If the validation in any of the three above is wrong the form is reloaded so they can try again
		if ($this->form_validation->run() == FALSE){

		   	$this->load->model('common_model');
		 
		 	$data['list_sites'] = $this->common_model->list_sites();			

			$data['menu'] = 'templates/menubar';		
			$data['main_content'] = 'websites/new_set_up';
			$this->load->view('include/template', $data);			

		}	else {	

		if(is_file('./common/con_localhost.php')){

			require_once('./common/con_localhost.php');

			$link = local_db_connect();

			$sitename = $this->input->post('sitename');			

			# Check to see if there is a db with the same name...
		    $db_selected = mysqli_select_db($link, 'wordpress_' . $sitename);

	  		# Check to see if there is a directory called wordpress_****** and ask if it wants to be deleted
		    if ((file_exists('./wordpress_sites/wordpress_' . $sitename)) || ($db_selected)) { 

	        	# Wordpress directory exists
		    	$data['dir_check'] = 'Y';

	        	# Add the button to delete it if they want or overwrite what is already there...
	        	# Also big warning about losing old site...

		    }	else {

	        	# Wordpress directory does not exists
		    	$data['dir_check'] = 'N';	
	  		}

			# Delete the progress.txt ready for the next installation
			if(file_exists('./downloads/progress.txt')){		
				unlink('./downloads/progress.txt');
			}

			# Set data
			$data_rewite = 0;

			# Write the blank content to the progress.txt
			write_file('./downloads/progress.txt', $data_rewite);	  		

			$data['sitename'] = $sitename;

		   	$this->load->model('common_model');
		 
		 	$data['list_sites'] = $this->common_model->list_sites();			

			$data['menu'] = 'templates/menubar';		
			$data['main_content'] = 'websites/install_wps';
			$this->load->view('include/template', $data);

			} else {
				redirect('admin');
			} 
		}//End of validation
	}

	public function complete_installation(){

		# Get the db credentials 
    	
    	# Load the model
    	$this->load->model('download_model');	

		$query = $this
					->download_model
					->get_site_credentials();

		$host = $query[0]->admin_host;
		$user = $query[0]->admin_user;
		$pass = $query[0]->admin_password;

		# Do they want SALT?
		if($this->input->post('salt')){
			
			$salt_api = file_get_contents('https://api.wordpress.org/secret-key/1.1/salt/');

			$pieces = explode("define", $salt_api);

			$auth_key 			= $pieces[0];
			$secure_auth_key 	= 'define' . $pieces[1];
			$logged_in_key 		= 'define' . $pieces[2];
			$nonce_key 			= 'define' . $pieces[3];
			$auth_salt			= 'define' . $pieces[4];
			$secure_auth_salt 	= 'define' . $pieces[5];
			$logged_in_salt 	= 'define' . $pieces[6];
			$nonce_salt 		= 'define' . $pieces[7];
		
		}	else {

			$auth_key 			= 'define(\'AUTH_KEY\',         \'put your unique phrase here\');';
			$secure_auth_key 	= 'define(\'SECURE_AUTH_KEY\',  \'put your unique phrase here\');';
			$logged_in_key 		= 'define(\'LOGGED_IN_KEY\',    \'put your unique phrase here\');';
			$nonce_key 			= 'define(\'NONCE_KEY\',        \'put your unique phrase here\');';
			$auth_salt			= 'define(\'AUTH_SALT\',        \'put your unique phrase here\');';
			$secure_auth_salt 	= 'define(\'SECURE_AUTH_SALT\', \'put your unique phrase here\');';
			$logged_in_salt 	= 'define(\'LOGGED_IN_SALT\',   \'put your unique phrase here\');';
			$nonce_salt 		= 'define(\'NONCE_SALT\',       \'put your unique phrase here\');';

		}
		
		# Typed in site name
		$sitename = $this->input->post('sitename');
		$data['sitename'] = $sitename;

	   	# Loads the download_model
	   	$this->load->model('download_model'); 

	   	# Triggers the download
 		$this->download_model->downloadIt();

    	# Path the the downloaded zip
    	$path = './downloads/latest.zip';

 		# Unzip the latest.zip to the parent above (WordPress)
    	$zip = new ZipArchive;

      	if ($zip->open($path) === TRUE) {
	        $zip->extractTo('./downloads');        
	        $zip->close();        
       
      	} 

      	# If there is no file downloaded stop the installation
      	if(file_exists($path)){

		# Rename wordpress to wordpress_web name
		rename('./downloads/wordpress/','wordpress_' . $sitename . '/');      


		# Create the db entry
		$this->load->dbforge();

		if (!$this->dbforge->create_database('wordpress_' . $sitename)){
    		echo 'Database NOT created!';
		}

		# Path to install.php
		//$install_master_file = './wordpress_sites/wordpress_' . $sitename . '/wp-admin/install.php';
		/*$install_master_file = 'wordpress_' . $sitename . '/wp-admin/install.php';

		# Convert the special characters
		$string = htmlspecialchars( file_get_contents( $install_master_file));


		# Update the install.php file with text about WPS
		$replacements = array(
			'&lt;' 		=> '<',
			'&gt;'		=> '>',
			'&quot;' 	=> '"',
			'&amp;'		=> '&',
			'&rsaquo;'	=> '\'',
			'<p><?php _e( \'WordPress has been installed. Were you expecting more steps? Sorry to disappoint.\' ); ?></p>' =>  '<p><?php _e( \'WordPress has been installed. Were you expecting more steps? Sorry to disappoint.\' ); ?></p><br/><p><?php _e( \'You can use the login below or click on the Websites dropdown from the menu  in WP Shepherd and click Develop, then select your website\' ); ?></p>',
		);    

		$install_file = str_replace( array_keys($replacements), $replacements, $string);


		# Write the file with the new content
		file_put_contents($install_master_file, $install_file);
		*/

		# Get the contents of the wp-config-sample.php. It's always going to be uptodate from Wordpress
	  
		# Path to wp-config-sample.php
		$wp_config_sample = 'wordpress_' . $sitename . '/wp-config-sample.php';


		$string_1 = htmlspecialchars(file_get_contents( $wp_config_sample));

		# Replace the keys below.
		$replacements_1 = array(
			'&lt;' => '<',
		    'database_name_here' => 'wordpress_' . $sitename,
		    'username_here'      => $user,
		    'password_here'      => $pass,
		    'define(\'AUTH_KEY\',         \'put your unique phrase here\');' => $auth_key,
		    'define(\'SECURE_AUTH_KEY\',  \'put your unique phrase here\');' => $secure_auth_key,
		    'define(\'LOGGED_IN_KEY\',    \'put your unique phrase here\');' => $logged_in_key,
		    'define(\'NONCE_KEY\',        \'put your unique phrase here\');' => $nonce_key,
		    'define(\'AUTH_SALT\',        \'put your unique phrase here\');' => $auth_salt,
		    'define(\'SECURE_AUTH_SALT\', \'put your unique phrase here\');' => $secure_auth_salt,
		    'define(\'LOGGED_IN_SALT\',   \'put your unique phrase here\');' => $logged_in_salt,
		    'define(\'NONCE_SALT\',       \'put your unique phrase here\');' => $nonce_salt,
		);

		$wp_config = str_replace( array_keys( $replacements_1), $replacements_1, $string_1);

		file_put_contents('wordpress_' . $sitename . '/wp-config.php', $wp_config);

			# Download and unzip each default plugin
			# See if the check box is checked

			if($this->input->post('plugins')){

				# Get all the paths of the plugins that are active
				$query_11 = $this
							->download_model
							->get_plugin_paths();

				# Unzip each one in to the correct directory

			
 
	 			foreach ($query_11 as $value) {
	   				# Path the the downloaded zip


	    			$path = './downloads/' . $value . '/latest.zip';

	 				# Unzip the latest.zip to the parent above (WordPress)
	    			$zip = new ZipArchive;

			      	if ($zip->open($path) === TRUE) {
				        $zip->extractTo('./wordpress_' . $sitename . '/wp-content/plugins/');        
				        $zip->close();
			      	} 
				}
			}	

		   	$this->load->model('common_model');

		 	$data['list_sites'] = $this->common_model->list_sites();
		 	$data['download_complete'] = 'WordPress downloaded';


			$data['menu'] = 'templates/menubar';	
			$data['main_content'] = 'websites/install_complete';
			$this->load->view('include/template', $data);

		}	else {

		   	$this->load->model('common_model');

		 	$data['list_sites'] = $this->common_model->list_sites();

		 	$data['download_error'] = 'Error WordPress not downloaded';

			$data['menu'] = 'templates/menubar';	
			$data['main_content'] = 'websites';
			$this->load->view('include/template', $data);
		}

	}

	public function progressCallback( $download_client, $download_size, $downloaded_size, $upload_size, $uploaded_size ){

		# This has to be a static variable or the download is very slow and laborious
    	static $previousProgress = 0;

	    if ( $download_size == 0 ){
	       $progress = 0;
	    } else {
        	$progress = round( $downloaded_size * 100 / $download_size );
	        if ( $progress > $previousProgress){
	            $previousProgress = $progress;

	            $fp = fopen( './downloads/progress.txt', 'r+b' );          
	            $to_file = "$progress";
	             
	            //if($progress == '100'){
	                  //$to_file = '<p class="text-success text-center">Downloaded the latest version of Wordpress &#10004;</p>';  // consider using "fontawesome"         
	            //}       
	            	
            	fputs( $fp, $to_file );
            	fclose( $fp );
	        }
  		}
  	} 

  		public function progressCallback_1( $download_client, $download_size, $downloaded_size, $upload_size, $uploaded_size ){

		# This has to be a static variable or the download is very slow and laborious
    	static $previousProgress = 0;

	    if ( $download_size == 0 ){
	       $progress = 0;
	    } else {
        	$progress = round( $downloaded_size * 100 / $download_size );
	        if ( $progress > $previousProgress){
	            $previousProgress = $progress;

	            $fp = fopen( './downloads/progress_1.txt', 'r+b' );          
	            $to_file = "$progress";
	             
	            //if($progress == '100'){
	                  //$to_file = '<p class="text-success text-center">Downloaded the latest version of Wordpress &#10004;</p>';  // consider using "fontawesome"         
	            //}       
	            	
            	fputs( $fp, $to_file );
            	fclose( $fp );
	        }
  		}
  	} 

  	# Deletes a project when working through creating a new ome.
  	public function delete_site(){

  		$sitename = $this->input->post('sitename');

  		$this->delete_existing_site($sitename);

  		redirect('websites');

  	}


  	public function delete_existing_site($sitename = ''){

		$this->load->dbutil();  
		$this->load->dbforge();	

  		# Check there is a database called wordpress_*******
		if ($this->dbutil->database_exists('wordpress_' . $sitename)){
   			
   			# If database found delete it.
			$this->dbforge->drop_database('wordpress_' . $sitename);
		}

		$this->rrmdir('wordpress_' . $sitename);

			return true;	
  	}

	# Checks to see if the directory is there and deletes it.
	function rrmdir($dir) { 
	   if (is_dir($dir)) { 
	     $objects = scandir($dir); 
	     foreach ($objects as $object) { 
	       if ($object != "." && $object != "..") { 
	         if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object); 
	       } 
	     } 
	     reset($objects); 
	     rmdir($dir); 
	   } 
	}

	# Create the child directory for the theme you have installed
	public function create_child(){
		
		# The third parameter of the URL is the sitename
		$sitename = $this->uri->segment(3);
		$theme = $this->uri->segment(4);

		# Path to the child directory
		$path =  './' . $sitename . '/wp-content/themes/' . $theme . '-child/';		

		# Create the child directory
    	mkdir($path, 0700);

    	# Create the child style.css for the site...
    	$data = "/*\n
    			" . 'Theme Name:' . "\t\t\t" . $theme . '-child'. "\n
    			" . 'Theme URI:' . "\t\t\t" . 'http://example.com/' . "\n
    			" . 'Description:' . "\t\t" . 'Child theme for the ' . $theme . 'theme' . "\n
    			" . 'Author:' . "\t\t\t\t\t" . 'Your name here' . "\n
    			" . 'Author URI:' . "\t\t\t" . 'http://example.com/about/' . "\n
    			" . 'Template:' . "\t\t\t\t" . $theme . "\n
    			" . 'Version:' . "\t\t\t\t" . '0.1.0' . "\n" . 
    			'*/' . "\n\n
    			" . '/* This line makes the original ' .  $theme . ' css available */' . "\n
    			" . '@import url("../' . $theme . '/style.css");';

		write_file($path . 'style.css', $data);

		     
		redirect('websites/develop');
	}

	# Compress the database at the moment
	public function compress_website(){

		$sitename = $this->uri->segment(3);

		$comp_sitename = substr($sitename, 10);

		$compress_type = $this->uri->segment(4);

		# Copy the source to the destination
		$src = './' . $sitename;

		$dst = './site_backups/' . $comp_sitename;

			if(is_dir('./site_backups/' . $comp_sitename)){

				$this->rrmdir($dst);

			}


		# Recursivly copy the WordPress site to the site_backups directory
		$this->recurse_copy($src,$dst);

		# Get the credentials from the database to populate the database below.
    	$this->load->model('download_model');	

		$query = $this
					->download_model
					->get_site_credentials();

		$host = $query[0]->admin_host;
		$user = $query[0]->admin_user;
		$pass = $query[0]->admin_password;			

		# Load database so I can export the db
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

		$this->db = $this->load->database($config, true);		
		
		#Load the dbutil model
		$this->load->dbutil();

		$prefs = array(
		                'tables'      => array(),  								# Array of tables to backup. if blank all tables exported
		                'ignore'      => array(),           					# List of tables to omit from the backup
		                'format'      => $compress_type,    					# gzip, zip, txt
		                'filename'    => strtolower($comp_sitename),   			# File name - NEEDED ONLY WITH ZIP FILES
		                'add_drop'    => TRUE,              					# Whether to add DROP TABLE statements to backup file
		                'add_insert'  => TRUE,              					# Whether to add INSERT data to backup file
		                'newline'     => "\n"               					# Newline character used in backup file
		              );

		$backup =& $this->dbutil->backup($prefs);

		write_file('./site_backups/' . $comp_sitename . '/' . $comp_sitename . '.' . $compress_type, $backup); 

		$path = './site_backups/' . $comp_sitename . '/';

		$this->zip->read_dir($path); 
		
		# Download the file to your desktop. Name it "my_backup.zip"
		$this->zip->download($comp_sitename);

		# Send the file to your desktop
		force_download($comp_sitename . '.' . $compress_type, $backup);	
	}

	public function recurse_copy($src,$dst) { 
	    $dir = opendir($src); 
	    @mkdir($dst); 
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	        } 
	    } 
	    closedir($dir); 
	} 

}/* End of class */

/* End of file websites.php */
/* Location: ./application/controllers/websites.php */
