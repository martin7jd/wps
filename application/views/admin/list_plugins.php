<script type="text/javascript">
 
</script>
<div class="container">
	<div class='jumbotron'>
	<!-- On rows -->
	<table class="table table-striped">
	  	<caption>Default Plugins</caption>
	  		<th>Plugin Name</th><th>Active</th><th><?php nbs(3);?></th><th><a href="plugin_form"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-title="Add Plugin">Add</button></a></th><th><a href="https://wordpress.org/plugins/" target="_blank"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-title="WordPress Website">Go To Plugins</button></a></th>
	  		<?php 

	  			if(empty($list_plugins)){

			  		echo '<tr>';
			  			echo '<td>'. nbs(1) . '</td><td>' . nbs(1) . '</td><td>' . heading('No default Plugins, Click the Add Button', 4) . '</td><td>' . nbs(1) . '</td>';
			  		echo '</tr>	'; 

	  			} else{
		  			foreach ($list_plugins as $value){

				  		if($value->checked == 'checked'){
				  						$checked = 'checked';
					  		}	else{
					  				$checked = '';
					  		}
				  		
				  		echo '<tr>';
				  			echo '<td>'. $value->plugin_name . '</td><td><input type="checkbox" name="checked[]" value="' . $value->plugin_name . '" ' . $checked . '></td><td><a href="plugin_form/' . $value->plugin_name . '"><button  type="button" class="btn btn-info" data-toggle="tooltip"  data-placement="left" data-title="Edit"><span class="glyphicon glyphicon-edit" alt="Edit"></span></button></a>' . nbs(2) . '<a href="q_update/' . $value->plugin_name . '"><button type="button" class="btn btn-success"  data-toggle="tooltip"  data-placement="top" data-title="Quick Save"><span class="glyphicon glyphicon-floppy-saved"></span></button></a>' . nbs(2) . '<a href="delete_plugin/' . $value->plugin_name . '"><button type="button" class="btn btn-danger" data-toggle="tooltip"  data-placement="right" data-title="Delete"><span class="glyphicon glyphicon-trash"></span></button></a></td><td>' . nbs(1) . '</td>';
				  		echo '</tr>	';  			
			  		}
				}
			?>	
	</table>
	</div>
</div>


<?php


