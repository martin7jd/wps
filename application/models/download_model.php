<?php

class Download_model extends CI_Model{

       public function __construct(){
        parent::__construct();
     }

  public function downloadIt($plugin_name = '', $download_path = ''){
    
    # If download_path variable is empty it's WordPress
 

    if($download_path == '' && $plugin_name == ''){
      # It's WordPress
      $ch = curl_init('https://wordpress.org/latest.zip');
      $targetFile = FCPATH . 'downloads/' . basename('latest.zip');

    } else{

      # Make the name all lowercase and replace the spaces with underscores
      $plugin_name = strtolower($plugin_name);
      $plugin_name = preg_replace('/\s+/', '_', $plugin_name);      
      
      # Create the named dir if they don't exist
      if(!is_dir('./downloads/' . $plugin_name)){
      
        # Create the directory for the download
        mkdir('./downloads/' . $plugin_name);

      }

      $targetFile = FCPATH . 'downloads/' . $plugin_name . '/' . basename('latest.zip');    
      $ch = curl_init($download_path);

    }

      $handle = fopen($targetFile, 'w');


    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_NOPROGRESS, false );
    if($download_path == ''){
        curl_setopt( $ch, CURLOPT_PROGRESSFUNCTION, array('websites', 'progressCallback'));
    } else{
        curl_setopt( $ch, CURLOPT_PROGRESSFUNCTION, array('websites', 'progressCallback_1'));
    }
    curl_setopt( $ch, CURLOPT_FILE, $handle );
    curl_setopt( $ch, CURLOPT_BUFFERSIZE, 2 );
    curl_exec( $ch );
    curl_close($ch);
  }

  public function get_site_credentials(){

    # Load second database
    $DB2 = $this->load->database('wpadmin', true);
    # Fetch result from localhost_info
    $DB2->select('*');
    $DB2->from ('localhost_info');
    $query = $DB2->get();
    $result = $query->result();    
  
    return $result;

  }

  public function get_plugin_paths($downloaded_plugins = ''){

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

    $db2->select('*');
    $db2->from('default_plugins');
    $db2->where('checked', 'checked');
    $query = $db2->get();
    $result = $query->result(); 

    foreach ($result as $value) {

      # Download the plugins
      $this->downloadIt($value->plugin_name, $value->plugin_path);

      $plugin_name = strtolower($value->plugin_name);
      $plugin_name = preg_replace('/\s+/', '_', $plugin_name);       
      $downloaded_plugins[] = $plugin_name;

    }  

    return $downloaded_plugins;

  }
} //end download_model 







