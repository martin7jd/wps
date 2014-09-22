<?php


# This page is created when the user adds the MySql user name and password 
  # Add the values to id="user" and id="pass".

  # Form to enter the website name that is to be used  
  
  # This page gathers the information together to install a version of wordpress
  # as a localhost copy.
  # Admin_main is set-up first so that the installation of each copy can take place.
  # It follows the "Famous 5-Minute Install"
  
  # See if there are any credentials in the wpadmin_localhost.localhost_info .
  # If not direct the user to the "Admin" tab and the "Installation settings" link


		echo '<div id="sitename">';
  # When the "Submit" button is press it launches install_one.php


		echo '<h3>Web Site Name<h3/>';


		echo '<input id="web" type="text" name="web" placeholder="Type Name Here" required><br/><br/>';



		echo '<button type="button" class="btn btn-lg btn-success" onclick="inst_one()">Fresh Install!</button>';


		echo '</div>';
	

?>
	