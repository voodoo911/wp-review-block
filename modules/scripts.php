<?php 
add_action('wp_print_scripts', 'wrb_add_script_fn');
function wrb_add_script_fn(){

	$prefix = 'wrb';
	wp_enqueue_style( $prefix.'bootsrap_css', plugins_url('/inc/assets/css/boot-cont.css', __FILE__ ) ) ;
	wp_enqueue_style( $prefix.'awesome.min.css', plugins_url('/inc/fa/css/font-awesome.min.css', __FILE__ ) ) ;
	
	// scripts styles for admin
	if(is_admin()){	
		wp_enqueue_media();			
		wp_enqueue_script( $prefix.'jscolor.js', plugins_url('/inc/jscolor/jscolor.js', __FILE__ ), array('jquery'  )  ) ;
		wp_enqueue_script( $prefix.'admi11n_js', plugins_url('/js/admin.js', __FILE__ ), array('jquery'  ) ) ;
		wp_enqueue_style( $prefix.'admin_css', plugins_url('/css/admin.css', __FILE__ ) ) ;	
	  }else{
		 
		// scripts styles for front end		  
		wp_enqueue_script( $prefix.'front_js', plugins_url('/js/front.js', __FILE__ ), array( 'jquery' )  ) ;
		wp_enqueue_style( $prefix.'front_css', plugins_url('/css/front.css', __FILE__ ) ) ;			
	  }
}

?>