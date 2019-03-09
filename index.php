<?php 
/*
 Plugin Name: Luxury Travel Pro Post Types
 Plugin URI: https://themesglance.com/
 Description: Creating new post type for Luxury Travel Pro Theme
 Author: Themesglance
 Version: 1.0
 Author URI: https://themesglance.com/
*/

define( 'LUXURY_TRAVEL_PRO_POSTTYPE_VERSION', '1.0' );


/* Categories*/
add_action( 'init', 'createcategory');
add_action( 'init', 'luxury_travel_pro_create_post_type' );

function luxury_travel_pro_create_post_type() {
  register_post_type( 'tours',
    array(
		'labels' => array(
			'name' => __( 'Tours','luxury-travel-pro-posttype' ),
			'singular_name' => __( 'Tours','luxury-travel-pro-posttype' )
		),
		'capability_type' =>  'post',
		'menu_icon'  => 'dashicons-admin-home',
		'public' => true,
		'supports' => array(
		'title',
		'editor',
		'excerpt',
		'trackbacks',
		'custom-fields',
		'revisions',
		'thumbnail',
		'author',
		'comments'
		)
    )
  );
  register_post_type( 'testimonials',
	array(
		'labels' => array(
			'name' => __( 'Testimonials','luxury-travel-pro-pro-posttype' ),
			'singular_name' => __( 'Testimonials','luxury-travel-pro-pro-posttype' )
			),
		'capability_type' => 'post',
		'menu_icon'  => 'dashicons-businessman',
		'public' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail'
			)
		)
	);
}

function createcategory() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => __( 'Categories', 'luxury-travel-pro-posttype' ),
		'singular_name'     => __( 'Categories', 'luxury-travel-pro-posttype' ),
		'search_items'      => __( 'Search cats', 'luxury-travel-pro-posttype' ),
		'all_items'         => __( 'All Categories', 'luxury-travel-pro-posttype' ),
		'parent_item'       => __( 'Parent Categories', 'luxury-travel-pro-posttype' ),
		'parent_item_colon' => __( 'Parent Categories:', 'luxury-travel-pro-posttype' ),
		'edit_item'         => __( 'Edit Categories', 'luxury-travel-pro-posttype' ),
		'update_item'       => __( 'Update Categories', 'luxury-travel-pro-posttype' ),
		'add_new_item'      => __( 'Add New Categories', 'luxury-travel-pro-posttype' ),
		'new_item_name'     => __( 'New Categories Name', 'luxury-travel-pro-posttype' ),
		'menu_name'         => __( 'Categories', 'luxury-travel-pro-posttype' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'createcategory' ),
	);

	register_taxonomy( 'createcategory', array( 'tours' ), $args );
}

/* Adds a meta box to the Trainer editing screen */
function luxury_travel_pro_bn_custom_meta_tours() {

    add_meta_box( 'bn_meta', __( 'Tour Meta', 'luxury-travel-pro-posttype' ), 'luxury_travel_pro_bn_meta_callback_tours', 'tours', 'normal', 'high' );
}
/* Hook things in for admin*/
if (is_admin()){
	add_action('admin_menu', 'luxury_travel_pro_bn_custom_meta_tours');
}

/* Adds a meta box for custom post */
function luxury_travel_pro_bn_meta_callback_tours( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
    $meta_duration=get_post_meta( $post->ID, 'meta-duration', true );
    $meta_location=get_post_meta($post->ID, 'meta-location', true);
    $meta_longitude=get_post_meta($post->ID, 'meta-longitude',true);
    $meta_latitude=get_post_meta($post->ID, 'meta-latitude', true);
    ?>
	<div id="property_stuff">
		<table id="list-table">			
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left" id="meta-pricelabel">
						<?php _e( 'Price', 'luxury-travel-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="number" name="meta-price" id="meta-price" value="<?php echo $bn_stored_meta['meta-price'][0]; ?>" />
					</td>
				</tr>
				<tr id="meta-2">
					<td class="left" id="meta-compricelable">
						<?php _e( 'Compare Price', 'luxury-travel-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="number" name="meta-comprice" id="meta-comprice" value="<?php echo $bn_stored_meta['meta-comprice'][0]; ?>" />
					</td>
				</tr>
				<tr id="meta-3">
					<td class="left">
						<?php _e( 'Duration', 'luxury-travel-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="meta-duration" id="meta-duration" value="<?php echo esc_attr(  $meta_duration ); ?>" />
					</td>
				</tr>
				<tr id="meta-4">
					<td class="left" id="meta-addresslabel">
						<?php _e( 'Location', 'luxury-travel-pro-posttype' )?>
					</td>
					<td class="left">
						<input type="text" name="meta-location" id="meta-location" value="<?php echo esc_attr($meta_location); ?>" />
					</td>
				</tr>
				<tr id="meta-5">
					<td class="left">
						<?php _e( 'Availability', 'luxury-travel-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="number" name="meta-availability" id="meta-availability" value="<?php echo $bn_stored_meta['meta-availability'][0]; ?>" />
					</td>
				</tr>
				<tr id="meta-6">
					<td class="left">
						<?php _e( 'Longitude', 'luxury-travel-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="meta-longitude" id="meta-longitude" value="<?php echo esc_attr($meta_longitude); ?>" />
					</td>
					<td class="left">
						<?php _e( 'Latitude', 'luxury-travel-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="meta-latitude" id="meta-latitude" value="<?php echo esc_attr($meta_latitude);?>" />
					</td>
				</tr>
				<tr id="meta-6">
					<?php $meta_element_class = get_post_meta($post->ID, 'meta-rating', true); //true ensures you get just one value instead of an array
    				?>  
					<td class="left">
						<?php _e( 'Tour Rating', 'luxury-travel-posttype' )?>
					</td>
					<td class="left" >
						<select name="meta-rating" id="meta-rating" class="selectbox">
					        <option value="" <?php selected( $meta_element_class, '' ); ?>><?php esc_html_e('','luxury-travel-posttype' ); ?></option>
					        <option value="1" <?php selected( $meta_element_class, '1' ); ?>><?php esc_html_e('1','luxury-travel-posttype' ); ?></option>
					        <option value="2" <?php selected( $meta_element_class, '2' ); ?>><?php esc_html_e('2','luxury-travel-posttype' ); ?></option>
					        <option value="3" <?php selected( $meta_element_class, '3' ); ?>><?php esc_html_e('3','luxury-travel-posttype' ); ?></option>
					        <option value="4" <?php selected( $meta_element_class, '4' ); ?>><?php esc_html_e('4','luxury-travel-posttype' ); ?></option>
					        <option value="5" <?php selected( $meta_element_class, '5' ); ?>><?php esc_html_e('5','luxury-travel-posttype' ); ?></option>
					    </select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
    <?php
}

/* Saves the custom meta input */
function luxury_travel_pro_bn_meta_save_tours( $post_id ) {

	// Save price
	if( isset( $_POST[ 'meta-price' ] ) ) {
	    update_post_meta( $post_id, 'meta-price', $_POST[ 'meta-price' ] );
	}
	if( isset( $_POST[ 'meta-comprice' ] ) ) {
	    update_post_meta( $post_id, 'meta-comprice', $_POST[ 'meta-comprice' ] );
	}
	if( isset( $_POST[ 'meta-duration' ] ) ) {
	    update_post_meta( $post_id, 'meta-duration', $_POST[ 'meta-duration' ] );
	}
	// Save address
	if( isset( $_POST[ 'meta-location' ] ) ) {
	    update_post_meta( $post_id, 'meta-location', $_POST[ 'meta-location' ] );
	}
	if( isset( $_POST[ 'meta-availability' ] ) ) {
	    update_post_meta( $post_id, 'meta-availability', $_POST[ 'meta-availability' ] );
	}
	if( isset( $_POST[ 'meta-availability' ] ) ) {
	    update_post_meta( $post_id, 'meta-availability', $_POST[ 'meta-availability' ] );
	}
	if( isset( $_POST[ 'meta-longitude' ] ) ) {
	    update_post_meta( $post_id, 'meta-longitude', $_POST[ 'meta-longitude' ] );
	}
	if( isset( $_POST[ 'meta-latitude' ] ) ) {
	    update_post_meta( $post_id, 'meta-latitude', $_POST[ 'meta-latitude' ] );
	}
	if(isset($_POST["meta-rating"])){
         //UPDATE: 
        $meta_element_class = $_POST['meta-rating'];
        //END OF UPDATE

        update_post_meta($post_id, 'meta-rating', $meta_element_class);
        //print_r($_POST);
    }
	}
add_action( 'save_post', 'luxury_travel_pro_bn_meta_save_tours' );

/*Categories shortcode */
function luxury_travel_pro_tours_shortcode( $atts ) {

	$services = '<div class="outer-prop">';

	$post_data = '';
	$rent = '';
    $args = array(
		'post_type' => 'tours',
	    );
    $query = new WP_Query( $args );
    $services .= "<div class='row'>";


    if ( $query->have_posts() ){
        while ( $query->have_posts() ) : $query->the_post();
        	$post_id = get_the_ID();
			$price = get_post_meta($post_id,'meta-price',true);
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_data), 'medium' );
			$url = $thumb['0'];
			$price_meta =''; $fprice=''; $comprice_meta =''; $fcompprice =''; $compf = ''; $pcurrency_symb = ''; $ccurrency_symb = '';
			$sale=''; $sale_hide='';
			if(get_post_meta($post_id,'meta-price',true != '')){
				$price_meta = get_post_meta($post_id);
				$fprice = number_format($price_meta['meta-price'][0], 2, '.', '');
			}
			if(get_post_meta($post_id,'meta-comprice',true != '')){
				$comprice_meta = get_post_meta($post_id);
				$fcompprice = number_format($comprice_meta['meta-comprice'][0], 2, '.', '');
			}
			if($fprice < $fcompprice){ $compf = $fcompprice; }
			if($fprice != ''){
				$pcurrency_symb = get_theme_mod('luxury_travel_pro_tour_currency',__('$','luxury-travel-pro-pro'));
			}
			if($fcompprice != ''){
				$ccurrency_symb = get_theme_mod('luxury_travel_pro_tour_currency',__('$','luxury-travel-pro-pro'));
			}
			$duration = get_post_meta(get_the_ID(),'meta-duration',true);
			$excerpt = get_the_excerpt(); 
			$content = luxury_travel_pro_string_limit_words($excerpt,11);
			if(get_post_meta(get_the_ID(),'meta-comprice',true != '' )){ if($fprice < $fcompprice) {
				$sale = 'sale_badge';
			 } 
			}
			if(get_post_meta(get_the_ID(),'meta-comprice',true == '' ) || get_post_meta(get_the_ID(),'meta-price',true == '' )){
				$sale_hide = 'sale_hide';
			}

			$services .= '
                <div class="col-md-4">
			    <div class="deals-discounts-box">
				    <div class="price">	                    
	                    <span>'.esc_html($pcurrency_symb . $fprice).'</span>
	                    <span class="comp_price"><strike>'.esc_html($ccurrency_symb . $compf).'</strike></span>
	                </div>
		                <div class="sale '.esc_html($sale . $sale_hide).'">
							sale
		                </div>
			    	<img class="team-image" src="'.$url.'" alt=""/>
				    <h4><a class="deals-discounts-title" href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
				    <div class="duration"><i class="fa fa-clock-o" aria-hidden="true"></i>'.$duration.'</div>
				    <?php } ?>
				    <div><p class="deals-discounts-text">'.$content.'</p></div>
	                <div class="row">										
		        		<div class="col-md-12">
		        			<div class="read-more-deals">        			
		        				<a href="'.get_the_permalink().'">Read More</a>
		        			</div>
		        		</div>
		        		<div class="clearfix"></div>
					</div>
				</div>
		    </div>';
        endwhile;
    
        wp_reset_postdata();
    }else{ 
    	$services .='<h2 class="center">'.__('Post Not Found','luxury-travel-pro-posttype').'</h2>';
    }
	$services .= '<div class="clearfix"></div></div></div>';
	return $services;
}
add_shortcode( 'all_tours', 'luxury_travel_pro_tours_shortcode' );

// Call tours by Categories shortcode:
function luxury_travel_pro_tours_cat_shortcode( $atts, $cat_name ) {

	$services = '<div class="main_row">';
	$post_data = '';
	$rent = '';
	$cat_name = isset( $atts['cat_name'] ) ? esc_html( $atts['cat_name'] ) : '';
    $args = array(
		'post_type' => 'tours',
		'createcategory'=> $cat_name,
		'paged' => $paged
    );

    $query = new WP_Query( $args );
    $services .= "<div class='row'>";

    if ( $query->have_posts() ){
        while ( $query->have_posts() ) : $query->the_post();
        	$post_id = get_the_ID();
			$price = get_post_meta($post_id,'meta-price',true);
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_data), 'medium' );
			$url = $thumb['0'];
			$price_meta =''; $fprice=''; $comprice_meta =''; $fcompprice =''; $compf = ''; $pcurrency_symb = ''; $ccurrency_symb = '';
			if(get_post_meta($post_id,'meta-price',true != '')){
				$price_meta = get_post_meta($post_id);
				$fprice = number_format($price_meta['meta-price'][0], 2, '.', '');
			}
			if(get_post_meta($post_id,'meta-comprice',true != '')){
				$comprice_meta = get_post_meta($post_id);
				$fcompprice = number_format($comprice_meta['meta-comprice'][0], 2, '.', '');
			}
			if($fprice < $fcompprice){ $compf = $fcompprice; }
			if($fprice != ''){
				$pcurrency_symb = get_theme_mod('luxury_travel_pro_tour_currency',__('$','luxury-travel-pro-pro'));
			}
			if($fcompprice != ''){
				$ccurrency_symb = get_theme_mod('luxury_travel_pro_tour_currency',__('$','luxury-travel-pro-pro'));
			}
			$duration = get_post_meta(get_the_ID(),'meta-duration',true);
			$excerpt = get_the_excerpt(); echo esc_html(luxury_travel_pro_string_limit_words($excerpt,11));

			$services .= '
                <div class="col-md-4">
			    <div class="deals-discounts-box">
				    <div class="price">	                    
	                    <span>'.esc_html($pcurrency_symb . $fprice).'</span>
	                    <span class="comp_price"><strike>'.esc_html($ccurrency_symb . $compf).'</strike></span>
	                </div>
		                <div class="sale">
							'.esc_html_e('sale').'
		                </div>
			    	<img class="team-image" src="'.$url.'" alt=""/>
				    <h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
				    <div class="duration"><i class="fa fa-clock-o" aria-hidden="true"></i>'.$duration.'</div>
				    <?php } ?>
				    <div><p>'.$excerpt.'</p></div>
	                <div class="row">
		            	<div class="col-md-6 reviews-right">
			            	<div class="reviews">
			            		<i class="fa fa-star" aria-hidden="true"></i>
			        			<i class="fa fa-star" aria-hidden="true"></i>
			        			<i class="fa fa-star" aria-hidden="true"></i>
			        			<i class="fa fa-star" aria-hidden="true"></i>
			        			<i class="fa fa-star" aria-hidden="true"></i>        		
			        		</div>	
		        		</div>										
		        		<div class="col-md-6 read-more-left">
		        			<div class="read-more-deals">        			
		        				<a href="'.get_the_permalink().'">Read More</a>
		        			</div>
		        		</div>
		        		<div class="clearfix"></div>
					</div>
				</div>
		    </div>';
        endwhile;
    
        wp_reset_postdata();
    }else{ 
    	$services .='<h2 class="center">'.__('Post Not Found','luxury-travel-pro-posttype').'</h2>';
    }
	$services .= '<div class="clearfix"></div></div></div>';
	return $services;
}
add_shortcode( 'tours_by_cat', 'luxury_travel_pro_tours_cat_shortcode' );

/* Testimonial section */
/* Adds a meta box to the Testimonial editing screen */
function luxury_travel_pro_posttype_bn_testimonial_meta_box() {
	add_meta_box( 'luxury-travel-pro-pro-posttype-testimonial-meta', __( 'Enter Designation', 'luxury-travel-pro-pro-posttype' ), 'luxury_travel_pro_posttype_bn_testimonial_meta_callback', 'testimonials', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'luxury_travel_pro_posttype_bn_testimonial_meta_box');
}

/* Adds a meta box for custom post */
function luxury_travel_pro_posttype_bn_testimonial_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'luxury_travel_pro_posttype_testimonial_meta_nonce' );
	$desigstory = get_post_meta( $post->ID, 'luxury_travel_pro_posttype_testimonial_desigstory', true );
	?>
	<div id="testimonials_custom_stuff">
		<table id="list">
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left">
						<?php esc_html_e( 'Designation', 'luxury-travel-pro-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="luxury_travel_pro_posttype_testimonial_desigstory" id="luxury_travel_pro_posttype_testimonial_desigstory" value="<?php echo esc_attr( $desigstory ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php }

/* Saves the custom meta input */
function luxury_travel_pro_posttype_bn_metadesig_save( $post_id ) {
	if (!isset($_POST['luxury_travel_pro_posttype_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['luxury_travel_pro_posttype_testimonial_meta_nonce'], basename(__FILE__))) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Save desig.
	if( isset( $_POST[ 'luxury_travel_pro_posttype_testimonial_desigstory' ] ) ) {
		update_post_meta( $post_id, 'luxury_travel_pro_posttype_testimonial_desigstory', sanitize_text_field($_POST[ 'luxury_travel_pro_posttype_testimonial_desigstory']) );
	}

}

add_action( 'save_post', 'luxury_travel_pro_posttype_bn_metadesig_save' );

/* Testimonials shortcode */
function luxury_travel_pro_posttype_testimonial_func( $atts ) {
	$testimonial = '';
	$testimonial = '<div class="row">';
	$query = new WP_Query( array( 'post_type' => 'testimonials') );

    if ( $query->have_posts() ) :

	$k=1;
	$new = new WP_Query('post_type=testimonials');

	while ($new->have_posts()) : $new->the_post();
      	$post_id = get_the_ID();
      	$excerpt = wp_trim_words(get_the_excerpt(),25);
      	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_data), 'medium' );
		$url = $thumb['0'];
      	$desigstory= get_post_meta($post_id,'luxury_travel_pro_posttype_testimonial_desigstory',true);
    	$testimonial .= '
			<div class="col-md-4 col-sm-6 testimonialwrapper-box">
				
				<div class="testi_qoute">
					<div class="image-box testimonial-box text-center">
						<a href="'.get_the_permalink().'"><img class="testi-img w-100" src="'.esc_url($url).'" alt="agents-thumbnail" /></a>
			        </div>
                	
					<div class="testimonial_content">
						<blockquote>'.esc_html($excerpt).'</blockquote>
						<span class="testi_name font-weight-bold">'.esc_html(get_the_title()) .'</span>
						<span class="testi-designation font-weight-bold">'.esc_html($desigstory).'</span>
					</div>
				</div>
				
			</div>';
		if($k%3 == 0){
			$testimonial.= '<div class="clearfix"></div>';
		}
      $k++;
  endwhile;
  else :
  	$testimonial = '<h2 class="center">'.esc_html__('Post Not Found','luxury-travel-pro-pro-posttype').'</h2>';
  endif;
  $testimonial .= '</div>';
  return $testimonial;
}

add_shortcode( 'testimonials', 'luxury_travel_pro_posttype_testimonial_func' );