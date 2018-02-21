<?php  
// review shortcode processing
add_shortcode( 'review_block', 'wrb_review_block' );
function wrb_review_block( $atts, $content = null ){
	global $post;
	$config = get_option('wrb_options'); 
 
	// custom inline styling for single review
	$out .= '
	<style>
	.review_block {
		border: 2px solid #000000;
		max-width: 650px; 
		margin: 10px auto;
		
	}
	.review_block .block_row{
		overflow:hidden;
		
	}
	.review_block .col_2_3{
		float:left;
		width:66%;
	}
	.review_block .col_1_3{
		width:34%;
		float:left;
	}
	.review_block .pros_cons{
		'.( isset( $config['pc_font_family'] )  && $config['pc_font_family'] != '' ? ' font-family: "'.$config['pc_font_family'].'";' : '' ).'
		background-color: #'.$config['pc_block_color'].';
	}
	.review_block .review_title{';
	
	$tmp = (int)$config['title_size'] + 2;
	
	$out .= '
		font-size:'.$config['title_size'].'px;
		line-height:'.$tmp.'px;
		font-weight:bold;
		'.( isset( $config['title_font_family'] )  && $config['title_font_family'] != '' ? ' font-family: "'.$config['title_font_family'].'";' : '' ).'
	}
	.review_block .col_1_2{
		width:50%;
		float:left;
	}
	
	
	/* styling  */
	.review_block{
		border:2px solid #'.$config['border_color'].';
	}
	.review_block .header_block{
		background-color:#'.$config['header_color'].';
	}
	.review_block .pros_list, .review_block  .cons_list{
		font-size:'.$config['pc_size'].'px;
	}
	.review_block .pros_list{
		color:#'.$config['pros_color'].';
		padding-left: 20px !important;
		margin: 0px;
	}
	.review_block .cons_list{
		color:#'.$config['cons_color'].';
		padding-left: 20px !important;
		margin: 0px;
	}
	.review_block .marg_15{
		padding:15px;
	}
	.review_block .header_block .image_cont img.main_image{
		padding: 10px;
		/* width: 100%; */
		height1: 200px;
		margin: 0px auto;
	}
	.review_block .pc_title{
		font-weight:bold;
	}
	.review_block .header_block .stars_cont{
		margin-bottom:10px;
	}
	.review_block .header_block .stars_cont .fa{
		color:#'.$config['stars_color'].';
	}
	.review_block .header_block .vert_cont_left{
		display: table; 
		min-height: 200px; 
		overflow: hidden; 
		float: right;
		padding-right: 10px; 
	}
	.review_block .pros_title{
		color:#'.$config['pros_title_color'].';
	}
	.review_block .cons_title{
		color:#'.$config['cons_title_color'].';
	}
	.review_block .header_block .vert_cont_right{
		display: table; 
		min-height: 200px; 
		overflow: hidden; 
		margin-left: 10px ;
	}
	.review_block .header_block .vert_cont .vert_cont_inner{
		display: table-cell; 
		vertical-align: middle;
	}
	.review_block .header_block .block_title_main{
		color:#'.$config['title_color'].';
	}
	.review_block .header_block .badge_cont img{
		height: 75px;
		position: absolute;
		top: 0px;
		left: -36px;
	}
	.review_block .header_block .image_cont{
		position:relative;
		'.( get_post_meta( $post->ID, 'review_image', true ) != '' ? 'background-image: url('.get_post_meta( $post->ID, 'review_image', true ).') ' : '' ).';
		height:200px;
		-webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		background-position:50% 50%;
		-o-background-position:50% 50%;
		-moz-background-position:50% 50%;
		-webkit-background-position:50% 50%;
	}
	
	
	@media screen and (max-width: 505px){
		.review_block .col_2_3{
			width:100%;
		}
		.review_block .col_1_3{
			width:100%;
		}
		.review_block .header_block .vert_cont_right{
			min-height: 100px;
		}
		.review_block .header_block .vert_cont_left{
			min-height: 100px;
		}
		.review_block .header_block .image_cont{
			display:none;
		}
	}
	</style>
	<div class="review_block">
		<div class="header_block block_row">
			<div class="col_2_3 block_row">
			 
				<div class="col_1_2_">
					<div class="vert_cont vert_cont_right">
					 <div class="vert_cont_inner"  >
					 
						<div class="block_title_main">
						 '.( get_post_meta( $post->ID, 'review_title', true ) != '' ? '<div class="review_title">'.get_post_meta( $post->ID, 'review_title', true ).'</div>' : '' ).'
						</div>
					 
						<div class="stars_cont">';
						   $numofstars = (int)get_post_meta( $post->ID, 'stars', true );
						   if( isset($numofstars) && $numofstars != '' ){
							   for( $i=1; $i<=$numofstars; $i++ ){
								$out .= '<i class="fa fa-star"></i>';
							   }
							   if( (float)get_post_meta( $post->ID, 'stars', true ) - (int)get_post_meta( $post->ID, 'stars', true ) != 0 ){
								$out .= '<i class="fa fa-star-half-o"></i>';
							   }
							   
							   $diff = 5 - (int)get_post_meta( $post->ID, 'stars', true );
							   if( (float)get_post_meta( $post->ID, 'stars', true ) - (int)get_post_meta( $post->ID, 'stars', true ) != 0 ){
								  $diff = $diff - 1; 
							   }
							 
							   for( $k=1; $k<=$diff ; $k++ ){
								   $out .= '<i class="fa fa-star-o"></i>';
							   }
								//$out .= '<i class="fa fa-star-half"></i>';
						}
						$out .= '
						   </div>
					 
					   
					 </div>
				   </div>

					
				</div>
			</div>
			<div class="col_1_3 image_cont">';
			
				if( get_post_meta( $post->ID, 'badge', true ) ){
					$all_badges = explode("\n", $config['badges_list'] );
					  $all_badges = array_filter( $all_badges );
					  $all_badges = array_map( 'trim', $all_badges );
					  
					  $badge_url = '';
					  
					  if( count( $all_badges ) > 0 ){
						foreach( $all_badges as $single_badge ){
							$tmp = explode('|', $single_badge);
						
							if( md5($tmp[1]) == get_post_meta( $post->ID, 'badge', true ) ){	
								$badge_url = $tmp[0];
															
							}

						}
					}
					$out .= '<div class="badge_cont"><img src="'.$badge_url.'" /></div>';
				}
			
				/*
				$out .= ''.( get_post_meta( $post->ID, 'review_image', true ) != '' ? '<img class="main_image" src="'.get_post_meta( $post->ID, 'review_image', true ).'" />' : '' );
				*/
				$out .= '
			</div>
		</div>
	  
	  
		<div class="pros_cons block_row">
			<div class="col_1_2 marg_15">
				<div class="pc_title pros_title">'.$config['pros_title'].'</div>
				<ul class="pros_list">';
				$out_pros = explode("\n", get_post_meta( $post->ID, 'pros', true ) );
				$out_pros = array_map('trim', $out_pros);
				$out_pros = array_filter( $out_pros );
				
				if(count( $out_pros ) > 0  ){
					foreach( $out_pros as $single_line ){
						$out .= '<li>'.$single_line.'</li>';
					}
				}
			$out .= '
					
				</ul>
			</div>
			<div class="col_1_2 marg_15">
				<div class="pc_title cons_title">'.$config['cons_title'].'</div>
				<ul class="cons_list">';
				$out_cons = explode("\n", get_post_meta( $post->ID, 'cons', true ) );
				$out_cons = array_map('trim', $out_cons);
				$out_cons = array_filter( $out_cons );
				
				if(count( $out_cons ) > 0  ){
					foreach( $out_cons as $single_line ){
						$out .= '<li>'.$single_line.'</li>';
					}
				}
			$out .= '
					
				</ul>
			</div>
			
		</div>
	  
	</div>
	';
	
	return $out;	
}

?>