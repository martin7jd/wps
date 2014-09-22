<div class="container">
	<div class="jumbotron">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo heading('Current Sites',2);?></h3>
			</div>
			<div class="panel-body">
				
				<?php
				if(!empty($list_sites) && $list_sites[0] != 'no sites available'){
					echo form_open('websites/remove_sites');
					
					foreach ($list_sites as $key => $value) {

						echo form_label('Site Name: ' . substr($value,10), substr($value,10));

						$data = array(
							'name'        => 'sitename[]',
							'id'          => substr($value,10),
							'value'       => substr($value,10),
							'checked'     => FALSE,
							'style'       => 'margin:10px',
							);

						echo form_checkbox($data) . '<br/>';   	
					}

					$attributes = array(
						'name' 		=> 'submit', 
						'class'		=> 'btn btn-danger',
						'id'		=> 'submit-btn',
						'type'		=> 'submit'
						);

					echo form_submit($attributes, 'Delete Site?'). '<button type="button" class="btn btn-link"><a href="/wps">Cancel</a></button>';
				}	else {
					echo heading('No Wordpress Sites intalled through WP Shepherd', 3);
				}
				?>

				<script>
				/* Check to make sure that the user wants to delete the wordpress installation */
				$(document).ready(function(){
					$("#submit-btn").click(function(){
						
						var result = confirm('Are you realy sure you want to delete this???');

						if (result == false) {
							return false;
						};
					});
				});
				</script>
			</div>
		</div>
	</div>
</div>
