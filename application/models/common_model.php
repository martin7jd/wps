<?php
	class Common_model extends CI_Model{

	   public function __construct(){
	      parent::__construct();
	   }

		# List out all the current projects that are available
		public function list_sites(){

			$d = dir('./');
	  
		    while(false !== ($entry = $d->read())){
		      if(($entry != '.') && ($entry != '..')){
		      
		        $wordPress_value = substr($entry, 0, 10); 
		            
		        if($wordPress_value === 'wordpress_'){

		              $sites[] = $entry;        	        
		        }      
		      }
		    }  


		    if(!empty($sites)){
				return $sites;
		    }	else {
		    	$sites[] = 'no sites available';
		    	return $sites;
		    }
		}
	}// End of common_model