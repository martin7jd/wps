<div class="container">
		<div class="jumbotron">
		<table class="table table-striped">		
			<caption>Sites</caption>
	  		<th>Site Name</th><th></th><th>Compression Options</th><th><?php nbs(3);?></th>

			<?php 


				$i = 0;
				foreach ($list_sites as $value) {
					if($value == 'no sites available'){

						echo '<tr>';

							echo '<td>Develop a WordPress website first then come back here and see me. OK!</td>';

						echo '</tr>';
					}	else{


				  		echo '<tr>';
				  			echo '<td>' . substr($value, 10) . '</td>';
				  			echo '<td>';



							//$sitename = 'sitename' . $i;

							//echo form_hidden('sitename', $value);

							//echo form_submit('mysubmit', 'Submit Post!');

				  		echo '</td><td><a href="compress_website/' . $value . '/gzip"><button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="left" data-title="Compress Database Using Gzip"><span class="glyphicon glyphicon-compressed"></span></button></a>' . nbs(2) . '<a href="compress_website/' . $value . '/zip"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="right" data-title="Compress Database Using Zip"><span class="glyphicon glyphicon-compressed"></span></button></a>';
				  		echo '</tr>	';						
					}
					$i++;
				}
			?>
		</table>
		</div>
</div>

