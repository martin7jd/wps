
<div class="container">
	<div class="jumbotron">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Download Complete</h3>
			</div>
			<div class="panel-body">
				<ul>
					<li>Latest version of WordPress has been downloaded</li>
					<li>It has been unzipped and placed the file in a folder called wordpress_<?php echo $sitename;?></li>
					<li>Default plugins have been installed</li>
					<li>A new window will have opened so that the installation could be finished</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script >
jQuery(document).ready(function(){
	var line = "<?php echo base_url('wordpress_' . $sitename . '/wp-admin/install.php');?>";
	newWin = open(line, '', 'height=960,width=800');

	if (window.focus) {
		newWin.focus();
	}
});
</script> 


