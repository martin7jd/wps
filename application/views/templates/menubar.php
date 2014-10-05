<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!--a class="navbar-brand" href="#">Brand</a-->
      <?php 
      $image_properties = array(
        'src' => 'images/wps_logo.png',
        'alt' => 'WP Shepherd',
        'class' => 'wps_logo',
        'width' => '60',
        'height' => '50',
        'title' => 'Sheep',
        );

      echo img($image_properties);
      ?>      
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo base_url();?>">Home</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Websites<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url('websites');?>">New Set-up</a></li>
            <li><a href="<?php echo base_url('websites/develop');?>">Under Development</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url('websites/back_up');?>">Local To Make Live</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url('websites/display_site_list');?>">Remove</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url('admin');?>">Database Settings</a></li>
            <li><a href="<?php echo base_url('admin/display_settings');?>">Display Settings</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url('admin/back_up_code');?>">Back-up Code</a></li>  
            <li class="divider"></li>
            <li><a href="<?php echo base_url('admin/plugin_defaults');?>">Default plug-in settings</a></li>  
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Quick Launch<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <?php 
              if($list_sites[0] == 'no sites available'){
                  echo '<div id="no_sites_menu">No sites available </div><div><a id="quick-start-sm-btn" href="./websites"><button type="button" class="btn btn-default btn-xs">New Set-up</button></a></div>';
              } else {
                  foreach ($list_sites as $value) {
                    echo '<li><a href="' . base_url($value . '/wp-admin/index.php')  .'"  target="_blank">' . substr($value, 10) . '</a></li>';
                  }  
              }            
            ?>         
          </ul>
        </li>        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Login</a></li>

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>