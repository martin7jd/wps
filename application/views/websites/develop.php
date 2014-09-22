<div class="container">
   <div class="jumbotron">
      <h2>Develop</h2>
      	<?php
      		if(!empty($sites)){
               foreach ($sites as $value) {
                  
                  echo $value;
               }
            }  else{

               echo heading('No Websites Installed', 3);

            }
      	?>
   </div>
</div>
