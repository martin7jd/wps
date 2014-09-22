<div class="container">
 <div class="jumbotron">
  <h2>Install On Local A New Wordpress Site</h2>

  <div class="new_set_up">

    <p>This application will download and install a brand new copy of Wordpress for you. All you need to do is follow these few simple instructions.</p>
    

    <?php

    $list = array(
      'In the "Site Name" field enter the name of the website and click on the "Start Installation" button', 
      'There\'s a check to make sure that the website name is unique', 
      'If it is you are given the option to "Continue Installation" or "Cancel"',
      'You are also given the option to have the Authentication Unique Keys and Salts set by ticking the check box',
      'Clicking "Continue Installation" downloads the latest version of Wordpress from their website and runs through the installation process',
      'The Wordpress welcome page is launched in a new window so that you can complete the details',
      'Click the "Install Wordpress"',
      'When comeplete you will see the Success view with the option to login'
      );

    $attributes = array(
      'class' => 'boldlist',
      'id'    => 'mylist'
      );

    echo ol($list, $attributes);

    echo '</div>';

  		# Builds form from website controller
      # Form rom a new installation of Wordpress
    echo form_open('websites/install');

    $attributes = array(
      'name'       => 'sitename',
      'id'         => 'sitename',
      'maxlength'  => '100',
      'size'       => '50',
      'style'      => 'width:50%',
      'placeholder'=> 'Site Name',
      'value'      => set_value('TITAN'),
      );

    echo form_input($attributes);

    $attributes1 = array(
      'name'    => 'submit', 
      'class'   => 'btn btn-info',
      );

    echo br(1);
    
    echo $data['bottom'] = form_submit($attributes1, 'Start Installation');

    echo br(2);
    
      # If validation fails for the Number of Players the error is shown here...
    echo form_error('sitename', '<div class="alert alert-danger" role="alert">', '</div>');
      # End of form
    ?>

  </div>
</div>
