<?php 
		
// adding metabox to post type
add_action( 'add_meta_boxes', 'wrb_add_custom_box' );
function wrb_add_custom_box() {
	global $post;
	global $current_user;
		add_meta_box( 
			'wrb_review_editor',
			__( 'SystemReview', 'wrb' ),
			'wrb_review_editor',
			'post' , 'advanced', 'high'
		);


		
}
function wrb_review_editor(){
	global $post;
	$config = get_option('wrb_options'); 
	$out .= '

<div class="tw-bs">
	<div class="form-horizontal ">
	
		<div class="control-group">  
            <label class="control-label" for="input01">'.__('Shortcode', 'wrb' ).'</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="review_title" id="review_title" value="[review_block id=\''.$post->ID.'\']">  
            </div>  
          </div> 
	
	
		<div class="control-group">  
            <label class="control-label" for="input01">'.__('Title', 'wrb' ).'</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="review_title" id="review_title" value="'.get_post_meta( $post->ID, 'review_title', true ).'">  
            </div>  
          </div> 
		  
		<div class="control-group">  
            <label class="control-label" for="input01">'.__('Review Image', 'wrb' ).'</label>  
            <div class="controls">  
				<input type="text" class="input-xlarge" name="review_image" id="review_image" value="'.get_post_meta( $post->ID, 'review_image', true ).'"> 
				<input type="button" id="image_upl_action" class="btn btn-success" value="'.__('Upload', 'wrb' ).'" />
            </div>  
          </div>   
		  
		<div class="control-group">
            <label class="control-label" for="select01">'.__('Badge', 'wrb' ).'</label>
            <div class="controls">
              <select name="badge">
				<option>'.__('Select Badge', 'wrb' ).'</option>';
			  
			  $all_badges = explode("\n", $config['badges_list'] );
			  $all_badges = array_filter( $all_badges );
			  $all_badges = array_map( 'trim', $all_badges );
			  if( count( $all_badges ) > 0 ){
				foreach( $all_badges as $single_badge ){
					$tmp = explode('|', $single_badge);
				
					$out .= '<option '.( get_post_meta( $post->ID, 'badge', true ) == md5($tmp[1]) ? ' selected ' : '' ).' value="'.md5($tmp[1]).'">'.$tmp[1].'</option>';
				}
			  }
      
				
		$out .= '
              </select>
            </div>
        </div>  
		
		<div class="control-group">
            <label class="control-label" for="select01">'.__('Stars', 'wrb' ).'</label>
            <div class="controls">
              <select name="stars">
                <option>'.__('Shortcode', 'wrb' ).'Select Stars Amount</option>
                <option value="1" '.( get_post_meta( $post->ID, 'stars', true ) == '1' ? ' selected ' : '' ).' >1</option>
                <option value="1.5" '.( get_post_meta( $post->ID, 'stars', true ) == '1.5' ? ' selected ' : '' ).' >1.5</option>
                <option value="2" '.( get_post_meta( $post->ID, 'stars', true ) == '2' ? ' selected ' : '' ).' >2</option>
                <option value="2.5" '.( get_post_meta( $post->ID, 'stars', true ) == '2.5' ? ' selected ' : '' ).' >2.5</option>
                <option value="3" '.( get_post_meta( $post->ID, 'stars', true ) == '3' ? ' selected ' : '' ).' >3</option>
                <option value="3.5" '.( get_post_meta( $post->ID, 'stars', true ) == '3.5' ? ' selected ' : '' ).' >3.5</option>
                <option value="4" '.( get_post_meta( $post->ID, 'stars', true ) == '4' ? ' selected ' : '' ).' >4</option>
                <option value="4.5" '.( get_post_meta( $post->ID, 'stars', true ) == '4.5' ? ' selected ' : '' ).' >4.5</option>
                <option value="5" '.( get_post_meta( $post->ID, 'stars', true ) == '5' ? ' selected ' : '' ).' >5</option>
              </select>
            </div>
        </div>
		
		  
		<div class="control-group">
            <label class="control-label" for="textarea">'.__('Pros', 'wrb' ).'</label>
            <div class="controls">
              <textarea class="input-xlarge" name="pros" rows="3">'.get_post_meta( $post->ID, 'pros', true ).'</textarea>
			  <p class="help-block">'.__('Please, enter Pros one per line', 'wrb' ).'</p>
            </div>
          </div>
		  
		<div class="control-group">
            <label class="control-label" for="textarea">'.__('Cons', 'wrb' ).'</label>
            <div class="controls">
              <textarea class="input-xlarge" name="cons" rows="3">'.get_post_meta( $post->ID, 'cons', true ).'</textarea>
			  <p class="help-block">'.__('Please, enter Cons one per line', 'wrb' ).'</p>
            </div>
          </div>

		</div>	
	</div>
	';	
	echo $out;
}

// saving of custom pfields in meta box
add_action( 'save_post', 'wfd_save_postdata' );
function wfd_save_postdata( $post_id ) {
global $current_user; 
 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }
  
	if( isset( $_POST['review_title'] )  ){	
		update_post_meta( $post_id, 'review_title', $_POST['review_title'] );
	}
	if( isset( $_POST['badge'] )  ){	
		update_post_meta( $post_id, 'badge', $_POST['badge'] );
	}
	if( isset( $_POST['stars'] )  ){	
		update_post_meta( $post_id, 'stars', $_POST['stars'] );
	}
	if( isset( $_POST['pros'] )  ){	
		update_post_meta( $post_id, 'pros', $_POST['pros'] );
	}
	if( isset( $_POST['cons'] )  ){	
		update_post_meta( $post_id, 'cons', $_POST['cons'] );
	}
	if( isset( $_POST['review_image'] )  ){	
		update_post_meta( $post_id, 'review_image', $_POST['review_image'] );
	}
	
}

?>