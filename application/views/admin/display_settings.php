<?php 

# This needs to be in the controller, not the view...

$data = "<?php\n\n
# This page is created when the user adds the MySql user name and password 
  # Add the values to id=\"user\" and id=\"pass\".

  # Form to enter the website name that is to be used  
  
  # This page gathers the information together to install a version of wordpress
  # as a localhost copy.
  # Admin_main is set-up first so that the installation of each copy can take place.
  # It follows the \"Famous 5-Minute Install\"
  
  # See if there are any credentials in the wpadmin_localhost.localhost_info .
  # If not direct the user to the \"Admin\" tab and the \"Installation settings\" link\n\n
	\techo '<div id=\"sitename\">';
  # When the \"Submit\" button is press it launches install_one.php\n\n
	\techo '<h3>Web Site Name<h3/>';\n\n
	\techo '<input id=\"web\" type=\"text\" name=\"web\" placeholder=\"Type Name Here\" required><br/><br/>';\n\n\n
	\techo '<button type=\"button\" class=\"btn btn-lg btn-success\" onclick=\"inst_one()\">Fresh Install!</button>';\n\n
	\techo '</div>';
	\n\n?>
	";	

    $tmpFile = './tmp/temp_index_inst.php';


	if ( ! write_file($tmpFile, $data)){
	     echo 'Unable to write the file';
	}	else {
	     echo 'index_inst.php File written!';
	}

  # Copy the file over the original
    $newfile = 'index_inst.php';

    if (!copy($tmpFile, $newfile)) {
        
        echo "failed to copy $file...\n";
    
    }  else {

    	if(is_file($tmpFile)){
			delete_files('./tmp/');
    	}
    }  

    $remove = './application/controllers/rem_two.php';

    $data = "<?php if (!defined('BASEPATH')) die();";

	if ( ! write_file($remove, $data)){
	     echo 'Unable to write the file';
	}	else {
	     echo 'index_inst.php File written!';
	}