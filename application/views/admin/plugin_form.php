<div class="container">
	<div class="jumbotron">
		<?php

			echo heading($heading, 3);
			echo form_open($controller_path);
			echo '<div>';
				$data = array(
				              'name'        => 'plugin_name',
				              'id'          => 'plugin_name',
				              'placeholder' => 'Plugin Name',
				              'maxlength'   => '100',
				              'size'        => '50',
				              'style'       => 'width:50%',
				              'data-toggle'		=> 'tooltip',
				              'data-placement'	=> 'right',
				              'title'			=> 'Type the plugin name here',				              
				              'value'		=> $plugin_name,
				              $disabled		=> ''
				            );

				echo form_input($data);

				echo form_hidden('alt_name', $plugin_name);

			echo '</div>';
			echo br(1);
			echo '<div>';			
				$data_1 = array(
				              'name'        	=> 'plugin_url',
				              'id'          	=> 'plugin_url',
				              'placeholder' 	=> 'Plugin URL',
				              'maxlength'   	=> '100',
				              'size'        	=> '50',
				              'style'       	=> 'width:50%',
				              'data-toggle'		=> 'tooltip',
				              'data-placement'	=> 'right',
				              'title'			=> 'Right click on the Download Button for the plugin. From the drop down menu select &quot;Copy Link Address&quot; and paste it here',
				              'value'			=> $plugin_path
				            );

				echo form_input($data_1);		

			echo '</div>';
			echo '<div>';

				$attributes = array(
								'class' 		=> 'mycustomclass',
							    'style' 		=> 'color: #000;',
				              	'data-toggle'	=> 'tooltip',
				              	'data-placement'=> 'left',							    
				    			'title'		  	=> 'Activate this plugin for installation'

				);

				echo form_label('Activate', 'active', $attributes);

				$data = array(
				    'name'        => 'active',
				    'id'          => 'active',
				    'value'       => 'active',
				    'checked'     => $checked,
				    'style'       => 'margin:10px'
				    );

				echo form_checkbox($data);
			echo '</div>';
			echo '<div>';

			echo form_submit('mysubmit', $submit_button,  'type="button" class="btn btn-info"') . '<button type="button" class="btn btn-link"><a href="/wps/admin/plugin_defaults">Cancel</a></button>';		
			echo '</div>';

		?>




	</div>
</div>