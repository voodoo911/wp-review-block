<?php 
	
// add admin menu for plugin settings
add_action('admin_menu', 'wrb_item_menu');
function wrb_item_menu() {
	add_options_page(   __('Review Settings', 'wrb'), __('Review Settings', 'wrb'), 'edit_published_posts', 'wrb_config', 'wrb_config');
}

function wrb_config(){
	
	$sizes_array = array();
	for( $k = 10; $k <= 50; $k++ ){
		$sizes_array[$k] = $k.' px';
	}
	
	$font_array = array( '' => 'Select', 'Arial' => 'Arial', 'Asap' => 'Asap', 'Tahoma' => 'Tahoma', 'Verdana' => 'Verdana', 'Open Sans' => 'Open Sans', 'Ubuntu' => 'Ubuntu', 'Corbel' => 'Corbel', 'Century Gothic' => 'Century Gothic' );
	
	$config_big = array(
		array(
			'name' => 'badges_list',
			'type' => 'textarea',
			'title' => __('Badges', 'wrb'),
			'placeholder' => __('Enter badges urls one per line', 'wrb'),
			'sub_text' => __('Enter badges urls one per line. If you want to add name to show in dropdown, use | as separator. So line will be http://site.com/badge.jpg|Cool Badge', 'wrb'),
			'rows' => 5,
			'style' => 'width:100%;'
		),
		array(
			'name' => 'header_color',
			'type' => 'text',
			'title' => __('Review header color', 'wrb'),
			'placeholder' => '',
			'class' => 'jscolor',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'border_color',
			'type' => 'text',
			'title' => __('Border Color', 'wrb'),
			'placeholder' => '',
			'class' => 'jscolor',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'pros_color',
			'type' => 'text',
			'title' => __('Pros Color', 'wrb'),
			'placeholder' => '',
			'class' => 'jscolor',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'cons_color',
			'type' => 'text',
			'title' => __('Cons Color', 'wrb'),
			'placeholder' => '',
			'class' => 'jscolor',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'stars_color',
			'type' => 'text',
			'title' => __('Stars Color', 'wrb'),
			'placeholder' => '',
			'class' => 'jscolor',
			'sub_text' => '',
			'style' => ''
		), 
		array(
			'name' => 'title_color',
			'type' => 'text',
			'title' => __('Title Color', 'wrb'),
			'placeholder' => '',
			'class' => 'jscolor',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'title_size',
			'type' => 'select',
			'title' => __('Title Size', 'wrb'),
			'placeholder' => '',
			'class' => '',
			'value' => $sizes_array,
			'sub_text' => '',
			'style' => ''
		),		
		array(
			'name' => 'title_font_family',
			'type' => 'select',
			'title' => __('Title Title Font Family', 'wrb'),
			'placeholder' => '',
			'class' => ' ',
			'value' => $font_array,
			'sub_text' => '',
			'style' => ''
		), 
		array(
			'name' => 'pc_font_family',
			'type' => 'select',
			'title' => __('Pros/Cons Title Font Family', 'wrb'),
			'placeholder' => '',
			'class' => ' ',
			'value' => $font_array,
			'sub_text' => '',
			'style' => ''
		), 
		array(
			'name' => 'pc_size',
			'type' => 'select',
			'title' => __('Pros Cons Size', 'wrb'),
			'placeholder' => '',
			'class' => '',
			'value' => $sizes_array,
			'sub_text' => '',
			'style' => ''
		),
		
		
		array(
			'name' => 'pros_title',
			'type' => 'text',
			'title' => __('Pros Title', 'wrb'),
			'placeholder' => '',
			'class' => '',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'pros_title_color',
			'type' => 'text',
			'title' => __('Pros Title Color', 'wrb'),
			'placeholder' => '',
			'class' => 'jscolor',
			'sub_text' => '',
			'style' => ''
		),
		
		array(
			'name' => 'cons_title',
			'type' => 'text',
			'title' => __('Cons Title', 'wrb'),
			'placeholder' => '',
			'class' => '',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'cons_title_color',
			'type' => 'text',
			'title' => __('Cons Title Color', 'wrb'),
			'placeholder' => '',
			'class' => 'jscolor',
			'sub_text' => '',
			'style' => ''
		),
		array(
			'name' => 'pc_block_color',
			'type' => 'text',
			'title' => __('Pros/Cons Block BG Color', 'wrb'),
			'placeholder' => '',
			'class' => 'jscolor',
			'sub_text' => '',
			'style' => ''
		),
		
	);

?>
<div class="wrap tw-bs">
<h2><?php _e('Settings', 'wrb'); ?></h2>
<hr/>
 <?php if(  wp_verify_nonce($_POST['_wpnonce']) ): ?>
  <div id="message" class="updated" ><?php _e('Settings saved successfully', 'wrb'); ?></div>  
  <?php 
  $config = get_option('wrb_options'); 

	foreach( $_POST as $key=>$value ){
		$wa_options[$key] = $value;
	}
  update_option('wrb_options', $wa_options );
  ?>
  <?php else:  ?>

  <?php //exit; ?>
  
  <?php endif; ?> 
<form class="form-horizontal" method="post" action="">
<?php wp_nonce_field();  
$config = get_option('wrb_options'); 

//var_dump( $config );
?>  
<fieldset>

	<?php 
	foreach( $config_big as $key=>$value ){
		switch( $value['type'] ){
			case "separator":
				$out .= '
				<div class="lead">'.$value['title'].'</div> 
				';
			break;
			case "text":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <input type="text"  class="'.$value['class'].'"  name="'.$value['name'].'" id="'.$value['id'].'" placeholder="'.$value['placeholder'].'" value="'.esc_html( stripslashes( $config[$value['name']] ) ).'">  
					  <p class="help-block">'.$value['sub_text'].'</p>  
					</div>  
				  </div> 
				';
			break;
			case "upload":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <input type="text"  class="'.$value['class'].'"  name="'.$value['name'].'" id="'.$value['id'].'" placeholder="'.$value['placeholder'].'" value="'.esc_html( stripslashes( $config[$value['name']] ) ).'">  
					  <input type="button" class="img_upload_button" 
					  <p class="help-block">'.$value['sub_text'].'</p>  
					</div>  
				  </div> 
				';
			break;
			case "select":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <select  style="'.$value['style'].'" class="'.$value['class'].'" name="'.$value['name'].'" id="'.$value['id'].'">' ; 
					  foreach( $value['value'] as $k => $v ){
						  $out .= '<option value="'.$k.'" '.( $config[$value['name']]  == $k ? ' selected ' : ' ' ).' >'.$v.'</option> ';
					  }
				$out .= '		
					  </select>  
					  <p class="help-block">'.$value['sub_text'].'</p> 
					</div>  
				  </div>  
				';
			break;
			case "checkbox":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <label class="checkbox">  
						<input  class="'.$value['class'].'" type="checkbox" name="'.$value['name'].'" id="'.$value['id'].'" value="on" '.( $config[$value['name']] == 'on' ? ' checked ' : '' ).' > &nbsp; 
						'.$value['text'].'  
						<p class="help-block">'.$value['sub_text'].'</p> 
					  </label>  
					</div>  
				  </div>  
				';
			break;
			case "radio":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">';
						foreach( $value['value'] as $k => $v ){
							$out .= '
							<label class="radio">  
								<input  class="'.$value['class'].'" type="radio" name="'.$value['name'].'" id="'.$value['id'].'" value="'.$k.'" '.( $config[$value['name']] == $k ? ' checked ' : '' ).' >&nbsp;  
								'.$v.'  
								<p class="help-block">'.$value['sub_text'].'</p> 
							  </label> ';
						}
					$out .= '
					   
					</div>  
				  </div>  
				';
			break;
			case "textarea":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <textarea style="'.$value['style'].'" class="'.$value['class'].'" name="'.$value['name'].'" id="'.$value['id'].'" rows="'.$value['rows'].'">'.esc_html( stripslashes( $config[$value['name']] ) ).'</textarea>  
					  <p class="help-block">'.$value['sub_text'].'</p> 
					</div>  
				  </div> 
				';
			break;
			case "multiselect":
				$out .= '
				<div class="control-group">  
					<label class="control-label" for="'.$value['id'].'">'.$value['title'].'</label>  
					<div class="controls">  
					  <select  multiple="multiple" style="'.$value['style'].'" class="'.$value['class'].'" name="'.$value['name'].'[]" id="'.$value['id'].'">' ; 
					  foreach( $value['value'] as $k => $v ){
						  $out .= '<option value="'.$k.'" '.( @in_array( $k, $config[$value['name']] )   ? ' selected ' : ' ' ).' >'.$v.'</option> ';
					  }
				$out .= '		
					  </select>  
					  <p class="help-block">'.$value['sub_text'].'</p> 
					</div>  
				  </div>  
				';
			break;
		}
	}
	echo $out;
	?>
		
          <div class="form-actions">  
            <button type="submit" class="btn btn-primary"><?php _e('Save Settings', 'wrb'); ?></button>  
          </div>  
        </fieldset>  

</form>

</div>


<?php 
}
?>