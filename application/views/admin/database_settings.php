<?php

	# This page is triggered from the admin.php/index function

	$filename = './common/con_localhost.php';
	echo '<div cals="container">';
		echo '<div class="jumbotron">';	

	if(is_file($filename)){

		# The credentials for this installation have been set. From here they can be re-set


				echo '<div class="panel panel-danger">';
				  	echo '<div class="panel-heading">';
				  		echo heading('Warning', 3, 'class="panel-title"');
				  	echo '</div>';
				  		echo '<div class="panel-body">';
							echo 'You can change the MySQl Database username and password settings for WP Shepherd here.<br/><b>No</b> websites installed through WP Shepherd will be lost.';


							echo form_open('admin/remove_wps_settings');

							$attributes = array(
										'class' => 'btn btn-danger btn-sm', 
										'value' => 'Re-set'
							);

							echo form_submit($attributes);

				  		echo '</div>';
				echo '</div>';


	}	else {

	echo '<div class="panel panel-default">';
  		echo '<div class="panel-heading">';	

			$attributes  = array(
								'class' => 'form-horizontal'
			);

			echo form_open('admin/set_database_settings', $attributes);

			$attributes  = array(
								'class' => 'form-fieldset'
			);

				if($lh_port == 'localhost:8888'){		
					echo form_fieldset(' MAMP MYSql Database Settings', $attributes);
				}	else {
					echo form_fieldset(' MYSql Database Settings', $attributes);
				}

					echo '<div class="form-group">';
						echo '<label class="col-md-4 control-label" for="textinput">Localhost</label>';
							echo '<div class="col-md-4">';

							$attributes = array(
												'id' 			=> 'host',
												'name' 			=> 'host',
												'type' 			=> 'text',
												'placeholder' 	=> 'Host',
												'class'			=> 'form-control input-md',
												//'disabled'		=> 'disabled',
												'value'			=> $lh_port
							);

							echo form_input($attributes);
						echo '</div>';
					echo '</div>';

				if($lh_port == 'localhost:8888'){

					echo '<div class="form-group">';
						echo '<label class="col-md-4 control-label" for="username">Username</label>';
							echo '<div class="col-md-4">';
								$attributes = array(
													'id' 			=> 'username',
													'name' 			=> 'username',
													'type' 			=> 'text',
													'placeholder' 	=> 'Username',
													'class'			=> 'form-control input-md',
													'value'			=> 'root'
								);

							echo form_input($attributes);
						echo '</div>';
					echo '</div>';	

					echo '<div class="form-group">';
						echo '<label class="col-md-4 control-label" for="password">Password</label>';
							echo '<div class="col-md-4">';
								$attributes = array(
													'id' 			=> 'password',
													'name' 			=> 'password',
													'type' 			=> 'text',
													'placeholder' 	=> 'Password',
													'class'			=> 'form-control input-md',
													'value'			=> 'root'
								);

							echo form_input($attributes);
						echo '</div>';
					echo '</div>';	
				}	else {
					echo '<div class="form-group">';
						echo '<label class="col-md-4 control-label" for="username">Username</label>';
							echo '<div class="col-md-4">';
								$attributes = array(
													'id' 			=> 'username',
													'name' 			=> 'username',
													'type' 			=> 'text',
													'placeholder' 	=> 'Username',
													'class'			=> 'form-control input-md'

								);

							echo form_input($attributes);
						echo '</div>';
					echo '</div>';	

					echo '<div class="form-group">';
						echo '<label class="col-md-4 control-label" for="password">Password</label>';
							echo '<div class="col-md-4">';
								$attributes = array(
													'id' 			=> 'password',
													'name' 			=> 'password',
													'type' 			=> 'text',
													'placeholder' 	=> 'Password',
													'class'			=> 'form-control input-md'

								);

							echo form_input($attributes);
						echo '</div>';
					echo '</div>';

				}
					echo '<div class="form-group">';
						echo '<label class="col-md-4 control-label" for="singlebutton"></label>';
							echo '<div class="col-md-4">';
								echo '<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>';
							echo '</div>';
					echo '</div>';

				echo form_fieldset_close(); 
				echo form_close();
  		echo '</div>';
	echo '</div>';

	}

			echo '</div>';//End of Container
		echo '</div>';//End of Container	

?>

<div class="panel panel-default panel-md">
  <div class="panel-heading">
    <h3 class="panel-title">Help</h3>
  </div>
  <div class="panel-body">
    System Settings<br/>
    Operating System: <?php echo $local_os;?><br/>
    Default installation of MAMP Localhost:8888, Username root, Password root

   	<?php 
		if (function_exists("gzcompress")) {
		  echo "<br/>Zlib is enabled";
		} else {
		  die("zlib missing");
		}
	?>
  </div>
</div>
