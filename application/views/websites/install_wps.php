<div class='container'>

	<?php

		if($dir_check == 'Y'){

			# Wordpress directory exists
        	echo '<div class="panel panel-danger" style="width:50%" >'; 
	        	echo '<div class="panel-heading">'; 
        			echo '<h3 class="panel-title">The site name ' . $sitename . ' exists on your computer</h3>'; 
	        	echo '</div>';
	        	echo '<div class="panel-body">' . heading('Do you want to delete this site and start over again?', 3);
	        	echo '<p>This is very serious and by clicking \'Delete Site?\' all WordPress files  and the database for web site ' . $sitename . ' will be deleted</p>';
	        	
	        	echo form_open('websites/delete_site');
	        	echo form_hidden('sitename', $sitename);

				$attributes = array(
					'name' 		=> 'submit', 
					'class'		=> 'btn btn-danger',
					'id'		=> 'submit-btn',
					'type'		=> 'submit'
				);

				echo form_submit($attributes, 'Delete Site?');
					echo nbs(3);
				echo anchor('websites', 'Back');

	        	echo '</div>'; 
        	echo '</div>';

       ?>
       	<script>
       	/* Check to make sure that the user wants to delete the wordpress installation */
		    $(document).ready(function(){
		        $("#submit-btn").click(function(){
		               
			        var result = confirm('Are you realy sure you want to delete this???');

		            if (result == false) {

					/* Hides the progress bar if the site is being deleted through the new set-up */	  				
		    		$('.panel').remove();

						return false;
		            
		            };
				});
		     });
       	</script>

		<?php		

		}	else {

    		# Create the form
			# Wordpress directory does not exists
        	echo '<div class="container">'; 
        		echo '<div class="jumbotron">';
        			echo '<div class="panel panel-success" style="width:50%" >'; 
        				echo '<div class="panel-heading">';
        					echo '<div class="panel-title"><h2>New installation of a website called: ' . ucfirst($sitename) . '</h2></div>';
        				echo '</div>';
	        				echo '<div class="panel-body">';

				    		echo form_open('websites/complete_installation');
				    		echo form_hidden('sitename', $sitename);

				    		# Do you want salt?
				    		echo '<div class="salt_tick">';
								echo heading('Authentication Unique Keys and Salts' , 2);
								//echo '<div>Don\'t worry you can always do it later</div>';	
	

								echo form_label('Do you want to do this?', 'salt');

								$data = array(
									'name'        => 'salt',
									'id'          => 'salt',
									'value'       => 'salt',
									'checked'     => FALSE,
									'style'       => 'margin:10px',
									);

								echo form_checkbox($data);
							echo '</div>';

				    		# Do you want default plugins?
				    		echo '<div class="plugin_tick">';
				    		if($no_plugins_installed != 0){
								echo heading('Default Plugins', 2);
	
								echo form_label('Do you want to do this?', 'plugins');

								$data1 = array(
									'name'        => 'plugins',
									'id'          => 'plugins',
									'value'       => 'plugins',
									'checked'     => TRUE,
									'style'       => 'margin:10px',
									);

								echo form_checkbox($data1);

								echo '<div>Don\'t worry you can always do it later</div>';

							echo '</div>';						
							}	else {
								echo '<div>';
								echo heading('Add Plugins Click Below', 3);
									echo '<button type="button" class="btn btn-link"><a href="/wps/admin/plugin_defaults">Set-up Default Plugins</a></button><br/>';							
								echo '</div>';
							}
									$attributes = array(
										'name' 		=> 'submit', 
										'class'		=> 'btn btn-info',
										'id'		=> 'submit-btn',
										'type'		=> 'submit'
									);

				    			echo form_submit($attributes, 'Continue Installation') . '<button type="button" class="btn btn-link"><a href="/wps/websites">Cancel</a></button>';
		}
							echo '</div>';
    	        		echo '</div>'; 
        		echo '</div>';
        	echo '</div>';
	?>

	<script> 
	  jQuery(document).ready(function($){

	  	// let's listen for the submit event
	  	$('form').submit(function(){
	  		$('.progress').removeClass('hidden');

	  		var percent = 0;
		    var auto_refresh = setInterval(
		    function (){
		    	/* Removes the jumbotrom class so that it leaves just the progress bar...*/
		    	$('.jumbotron').remove();
		    	$('.display').removeClass('hidden');
		    	$('.panel').removeClass('hidden');
		    	//$('.panel').removeClass('panel-success');

			    percent = $('#percentage').load('../downloads/progress.txt').html(); // fetch the percent
					
			    if(isNaN(percent)){ // check if we're returning the complete message			    	
			    	$('#percentage').hide().removeClass('hidden').fadeIn('slow'); // fade in message slowly
			    	clearInterval(auto_refresh); // remove the interval
			    }
			    
			    $('.progress-bar').attr('aria-valuenow',percent); // set the attribute aria-valuenow as percent
			    $('.progress-bar').css('width',percent+'%'); // set the inline css as percent
			    }, 500);
	  	});  
	  });
	</script>

	<div class="panel panel-default hidden">
	  <div class="panel-heading">
	    <h3 class="panel-title">
	    	<div class="display hidden">Downloading Wordpress</div></h3>
	  </div>
	  <div class="panel-body">
		<div class="progress hidden">
		  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10" style="width:100%;">	  
				<!--div class="hidden" id="percentage"></div-->
				<div id="percentage"></div>		
		  </div>
		</div>  
	</div>
	</div>