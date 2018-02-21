<?php 
// register Star Review Widget
add_action( 'widgets_init', create_function( '', 'register_widget( "star_review_widget" );' ) );
class star_review_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'star_review_widget', // Base ID
			'Star Review Widget', // Name
			array( 'description' => __( 'Star Review Widget description', 'wrb' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number = apply_filters( 'widget_title', $instance['number'] );
		$review_ordering = apply_filters( 'widget_title', $instance['review_ordering'] );
		$show_author = apply_filters( 'widget_title', $instance['show_author'] );
		$show_comments = apply_filters( 'widget_title', $instance['show_comments'] );
		$show_date = apply_filters( 'widget_title', $instance['show_date'] );
		$image_position = apply_filters( 'widget_title', $instance['image_position'] );
		$title_position = apply_filters( 'widget_title', $instance['title_position'] );
		$title_color = apply_filters( 'widget_title', $instance['title_color'] );
		$stars_color = apply_filters( 'widget_title', $instance['stars_color'] );
		$first_featured = apply_filters( 'widget_title', $instance['first_featured'] );
		$title_font = apply_filters( 'widget_title', $instance['title_font'] );
		$thumb_size = apply_filters( 'widget_title', $instance['thumb_size'] );
 
		$thumb_size_p_off = $thumb_size + 10;
 
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		$rand = rand(1000, 9999);
		
		$rand_class = 'rand_'.$rand;
		
		// custom styling
		$out = '
		<style>
		.'.$rand_class.' .widget_container .single_item .credentials_block span{
			margin-right:5px;
			color:#ccc;
			font-size:11px;
		}
		.'.$rand_class.' .widget_container .single_item{
			margin-bottom:10px;
			overflow: hidden;
		}
		.'.$rand_class.' .widget_container .single_item.is_featured{
			height:75px;
			background-size: cover; 
			background-position: 50% 50%;
			 
		}
		.'.$rand_class.' .widget_container .single_item .title_block{
			text-decoration:none;
			text-align:left;
			
		}
		.'.$rand_class.' .widget_container .single_item .stars_block{
			text-align:left;
		}
		.'.$rand_class.' .widget_container .single_item .credentials_block{
			text-align:left;
		}
		.'.$rand_class.' .widget_container .single_item .title_block a{
			color:'.$title_color.';
			font-family: "'.$title_font.'";
		}
		.'.$rand_class.' .widget_container .stars_block i{
			color:'.$stars_color.';
		}
		.'.$rand_class.' .widget_container .image_block{
			width:'.$thumb_size.'px;
			height:'.$thumb_size.'px;
			background-size: cover; 
			background-position: 50% 50%;
			position:relative;
		}
		.'.$rand_class.' .widget_container .data_block{
			width:calc( 100% - '.$thumb_size_p_off.'px );
			float: left;
		}
		.'.$rand_class.' .widget_container .image_on_left{
			float:left;
			margin-right:10px;
		}
		.'.$rand_class.' .widget_container .image_on_right{
			float:right;
			margin-left:10px;
		}
		.'.$rand_class.' .widget_container .is_featured .feat_title{
			font-size:16px;
			text-align:right;
			padding-right:10px;
			font-weight:bold;
			color:'.$title_color.';
			font-family: "'.$title_font.'";
		}
		.'.$rand_class.' .widget_container .is_featured .feat_stars .stars_block{
			text-align:right;
			padding-right:10px;
		}
		</style>
		<div class="'.$rand_class.' ">
		<div class="widget_container">';
		 
			
			$args = array(
				'showposts' => ( (int)$number != 0 ? (int)$number : 5 ),
				'post_type' => 'post',
			 
			);
			// ordering of posts
			if( $review_ordering == 'latest' ){
				$args['orderby'] = 'date';
				$args['meta_query'] = 
				array(
					array(
						'key'     => 'review_title',
						'value'   => '',
						'compare' => '!=',
					),
				);
			}
			if( $review_ordering == 'top_rated' ){
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = 'stars';
			}
			
			
			$all_posts = get_posts( $args );
			$cnt = 0;
			if( count($all_posts) > 0 ){
				foreach( $all_posts as $single_post ){
				
						// stars block
						$stars_block = '<div class="stars_block">';
							$numofstars = (int)get_post_meta( $single_post->ID, 'stars', true );
							if( isset($numofstars) && $numofstars != '' ){
							   for( $i=1; $i<=$numofstars; $i++ ){
								$stars_block .= '<i class="fa fa-star"></i>';
							   }
							   if( (float)get_post_meta( $single_post->ID, 'stars', true ) - (int)get_post_meta( $single_post->ID, 'stars', true ) != 0 ){
								$stars_block .= '<i class="fa fa-star-half-o"></i>';
							   }
							   
							   $diff = 5 - (int)get_post_meta( $single_post->ID, 'stars', true );
							   if( (float)get_post_meta( $single_post->ID, 'stars', true ) - (int)get_post_meta( $single_post->ID, 'stars', true ) != 0 ){
								  $diff = $diff - 1; 
							   }
							 
							   for( $k=1; $k<=$diff ; $k++ ){
								   $stars_block .= '<i class="fa fa-star-o"></i>';
							   }
			 
							}						
						$stars_block .= '</div>';
						// ####
				
				
					// featured item processing
					if( $first_featured == 'on' && $cnt == 0 ){
						$out .= '<div class="single_item is_featured" style="background-image: url('.get_post_meta( $single_post->ID, 'review_image', true ).')" >';
							$out .= '<div class="feat_title">'.get_post_meta( $single_post->ID, 'review_title', true ).'</div>';
							$out .= '<div class="feat_stars">'.$stars_block.'</div>';
						$out .= '</div>';
						
						$cnt++;
						continue;
					}
				
				
					$out .= '<div class="single_item">';
					
					
					// image class for aligment
					if( $image_position == 'left' ){
						$image_class = ' image_on_left ';
					}
					if( $image_position == 'right' ){
						$image_class = ' image_on_right ';
					}
					
					
					$out .= '<div class="image_block '.$image_class.' " style="background-image: url('.get_post_meta( $single_post->ID, 'review_image', true ).')" ></div>';
					
					$out .= '<div class="data_block">';
					
						// title block 
						$title_block = '<div class="title_block"><a href="'.get_permalink( $single_post->ID ).'">'.get_post_meta( $single_post->ID, 'review_title', true ).'</a></div>';
						// title block end
	
						
						// check title position
						if( $title_position == 'top' ){
							$out .= $title_block;
							$out .= $stars_block;
						}
						if( $title_position == 'bottom' ){
							$out .= $stars_block;
							$out .= $title_block;							
						}
						
						// main credentials block
						$out .= '<div class="credentials_block">';
						$author = get_user_by( 'ID', $single_post->post_author );
							
							// show author data
							if( $show_author == 'on' ){
								$out .= '<span class="show_author">Author: '.$author->user_nicename.'</span>';
							}
							
							// show comments
							if( $show_comments == 'on' ){
								$out .= '<span class="show_comments">Comments: '.get_comments_number($single_post->ID ).'</span>';
							}
							// show post date
							if( $show_date == 'on' ){
								$out .= '<span class="show_date">Date: '. date( 'm/d/Y', strtotime($single_post->post_date) ).'</span>';
							}
						$out .= '</div>';
					$out .= '</div>';

					$out .= '</div>';
				}
			}

		$out .= '</div>
		</div>';
		
		echo $out;
		echo $after_widget;
	}

	// update settings
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['review_ordering'] = strip_tags( $new_instance['review_ordering'] );
		$instance['show_author'] = strip_tags( $new_instance['show_author'] );
		$instance['show_comments'] = strip_tags( $new_instance['show_comments'] );
		$instance['show_date'] = strip_tags( $new_instance['show_date'] );
		$instance['image_position'] = strip_tags( $new_instance['image_position'] );
		$instance['title_position'] = strip_tags( $new_instance['title_position'] );
		$instance['title_color'] = strip_tags( $new_instance['title_color'] );
		$instance['stars_color'] = strip_tags( $new_instance['stars_color'] );
		$instance['first_featured'] = strip_tags( $new_instance['first_featured'] );
		$instance['title_font'] = strip_tags( $new_instance['title_font'] );
		$instance['thumb_size'] = strip_tags( $new_instance['thumb_size'] );

		return $instance;
	}

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			$number = $instance[ 'number' ];
			$review_ordering = $instance[ 'review_ordering' ];
			$show_author = $instance[ 'show_author' ];
			$show_comments = $instance[ 'show_comments' ];
			$show_date = $instance[ 'show_date' ];
			$image_position = $instance[ 'image_position' ];
			$title_position = $instance[ 'title_position' ];
			$title_color = $instance[ 'title_color' ];
			$stars_color = $instance[ 'stars_color' ];
			$first_featured = $instance[ 'first_featured' ];
			$title_font = $instance[ 'title_font' ];
			$thumb_size = $instance[ 'thumb_size' ];
		}
		else {
			$title = __( 'New title', 'wrb' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wrb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of items:', 'wrb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_size' ); ?>"><?php _e( 'Thumb Size:', 'wrb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'thumb_size' ); ?>" name="<?php echo $this->get_field_name( 'thumb_size' ); ?>" type="text" value="<?php 
			
			if( $thumb_size ){
				echo esc_attr( $thumb_size );
			}else{
				echo '50';
			}
			 ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'review_ordering' ); ?>"><?php _e( 'Reviews Ordering', 'wrb' ); ?></label> 
			
			<select id="<?php echo $this->get_field_id( 'review_ordering' ); ?>" name="<?php echo $this->get_field_name( 'review_ordering' ); ?>">
				<option value="latest"  <?php if( $review_ordering == 'latest' ) echo ' selected '; ?> ><?php _e( 'Latest', 'wrb' ); ?>
				<option value="top_rated" <?php if( $review_ordering == 'top_rated' ) echo ' selected '; ?>><?php _e( 'Top Rated', 'wrb' ); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title_font' ); ?>"><?php _e( 'Title Font', 'wrb' ); ?></label> 
			
			<select id="<?php echo $this->get_field_id( 'title_font' ); ?>" name="<?php echo $this->get_field_name( 'title_font' ); ?>">
			
				<?php 
				$font_array = array( '' => 'Select', 'Arial' => 'Arial', 'Asap' => 'Asap', 'Tahoma' => 'Tahoma', 'Verdana' => 'Verdana', 'Open Sans' => 'Open Sans', 'Ubuntu' => 'Ubuntu', 'Corbel' => 'Corbel', 'Century Gothic' => 'Century Gothic' );
				foreach( $font_array as $single_item ):
				?>
				<option value="<?php echo $single_item;  ?>"  <?php if( $title_font == $single_item ) echo ' selected '; ?> ><?php echo $single_item;  ?>
			
				<?php endforeach; ?>
				 
			</select>
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'first_featured' ); ?>" name="<?php echo $this->get_field_name( 'first_featured' ); ?>" value="on" <?php if( $first_featured == 'on' ) echo ' checked ';  ?> >
			<label for="<?php echo $this->get_field_id( 'first_featured' ); ?>"><?php _e( 'Make First Featured', 'wrb' ); ?></label>
			<br>
 
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="on" <?php if( $show_author == 'on' ) echo ' checked ';  ?> >
			<label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show Show Author', 'wrb' ); ?></label>
			<br>
			
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_comments' ); ?>" name="<?php echo $this->get_field_name( 'show_comments' ); ?>"  value="on" <?php if( $show_comments == 'on' ) echo ' checked ';  ?>>
			<label for="<?php echo $this->get_field_id( 'show_comments' ); ?>"><?php _e( 'Show Comments Number', 'wrb' ); ?></label>
			<br>
			
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" <?php if( $show_date == 'on' ) echo ' checked ';  ?>>
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show Date', 'wrb' ); ?></label>
			<br>
		</p>
		
		
		<p>
			<label for="<?php echo $this->get_field_id( 'image_position' ); ?>"><?php _e( 'Image Position', 'wrb' ); ?></label> 
			
			<select id="<?php echo $this->get_field_id( 'image_position' ); ?>" name="<?php echo $this->get_field_name( 'image_position' ); ?>">
				<option value="left"  <?php if( $image_position == 'left' ) echo ' selected '; ?> ><?php _e( 'Left', 'wrb' ); ?>
				<option value="right" <?php if( $image_position == 'right' ) echo ' selected '; ?>><?php _e( 'Right', 'wrb' ); ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title_position' ); ?>"><?php _e( 'Title Position', 'wrb' ); ?></label> 			
			<select id="<?php echo $this->get_field_id( 'title_position' ); ?>" name="<?php echo $this->get_field_name( 'title_position' ); ?>">
				<option value="top"  <?php if( $title_position == 'top' ) echo ' selected '; ?> ><?php _e( 'Top', 'wrb' ); ?>
				<option value="bottom" <?php if( $title_position == 'bottom' ) echo ' selected '; ?>><?php _e( 'Bottom', 'wrb' ); ?>
			</select>
		</p>
		
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title_color' ); ?>"><?php _e( 'Title Color:', 'wrb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title_color' ); ?>" name="<?php echo $this->get_field_name( 'title_color' ); ?>" type="color" value="<?php echo esc_attr( $title_color ); ?>" />
			</p>
		<p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'stars_color' ); ?>"><?php _e( 'Stars Color:', 'wrb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'stars_color' ); ?>" name="<?php echo $this->get_field_name( 'stars_color' ); ?>" type="color" value="<?php echo esc_attr( $stars_color ); ?>" />
		</p>
		 
		
		<?php 
	}

} // class star_review_widget


?>