<?php 
/*
Plugin Name: Index Page
Plugin URI: http://hoasao.vn
Description: Index Content
Version: 1.0.0
Author: EWP
Author URI: http://hoasao.vn
License: GPL2
*/

/**
 * install plugin
 */

global $ewp_db_version;
$ewp_db_version = '1.0.1';

function ewp_install() {
    global $wpdb;
    global $ewp_db_version;

    $contact_table = $wpdb->prefix . "ewp_contact";
    
    $sql = "CREATE TABLE $contact_table (
    		id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        	name VARCHAR(100),
        	email VARCHAR(100),
        	phone VARCHAR(25),
			message TEXT,
			product_name varchar(100),
			booking_date DATE,
			status VARCHAR(50)
			
        );
		";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    add_option("ewp_db_version", $ewp_db_version);
    update_option("ewp_db_version", $ewp_db_version);
}
//register_activation_hook( __FILE__, 'ewp_install' );

function ewp_update_db_check() {
    global $ewp_db_version;
    if (get_site_option( 'ewp_db_version' ) != $ewp_db_version) {
        ewp_install();
    }
}
//add_action( 'plugins_loaded', 'ewp_update_db_check' );


add_action( 'wp_enqueue_scripts', 'prefix_add_my_stylesheet' );

/**
 * Enqueue plugin style-file
 */
function prefix_add_my_stylesheet() {
	//add script
	wp_enqueue_script('ewp', plugins_url('js/ewp.js', __FILE__), array('jquery'));
//	wp_enqueue_script('ewp', plugins_url('fancybox/jquery.fancybox-1.3.4.pack.js', __FILE__), array('jquery'));
//	wp_enqueue_script('ewp1', plugins_url('js/jquery.colorbox-min.js', __FILE__), array('jquery'));
	
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'prefix-style', plugins_url('css/style.css', __FILE__) );
    //wp_register_style( 'prefix-style', plugins_url('fancybox/jquery.fancybox-1.3.4.css', __FILE__) );
//    wp_register_style( 'prefix-style', plugins_url('css/colorbox.css', __FILE__) );
    wp_enqueue_style( 'prefix-style' );
}

function register_shortcode(){
	add_shortcode('home-support', 'home_support');
	add_shortcode('ewp-report', 'ewp_report');
	add_shortcode('ewp-new-report', 'ewp_new_report');
	add_shortcode('large-news-box', 'large_news_box');
	add_shortcode('home-news', 'home_news');
	add_shortcode('home-youtube', 'home_youtube');
	add_shortcode('home-partners', 'home_partners');
}

add_action('init', 'register_shortcode');



/**
 * save info to db and send mail
 * @author duythanhdao@live.com
 */

function save_custom_info (){
    $to = get_settings('admin_email');
    $subject = 'Đặt thuê máy của ' . $_POST['name'] . ($_POST['email'] ? '<' . $_POST['email'] . '>' : '') ;
    $message .= 'Tên khách hàng: ' . $_POST['name'] . "\n";
    $message .= 'Điện thoại: ' . $_POST['phone'] . "\n";
    $message .= 'Email: ' . $_POST['email'] . "\n";

    $message .= 'Tên sản phẩm: ' . $_POST['product_name'] . "\n";


    $message .= 'Nội dung: ' . $_POST['message'];
    //reg_email();
    
    try{
        $result = wp_mail($to,$subject,$message);
    }
    catch(phpmailerException $e){
        
        $exceptionmsg = $e->errorMessage();
        exit('Có lỗi xảy ra, quý khách vui lòng thử lại');
    }
    if(saveBooking()) {

        exit('Thông tin đã được gửi, cảm ơn qúy khách!');
    }

    exit('Có lỗi xảy ra, quý khách vui lòng thử lại');
}
add_action( 'wp_ajax_save_custom_info', 'save_custom_info');
add_action( 'wp_ajax_nopriv_save_custom_info', 'save_custom_info');

/**
 * save booking to database
 * @author duythanhdao@live.com
 */

function saveBooking(){
    global $wpdb;
    $table_name = $wpdb->prefix . "ewp_contact";
    $data = array();
    $fields = array(
        'name', 'email', 'phone', 'message', 'product_name'
    );
    foreach($fields as $field){
        if(isset($_POST[$field])) {
            $data[] = "'" . $_POST[$field] . "'";
        }
    }

    $data[] = "'" . date('Y-m-d', time()) . "'";
    $data[] = "'" . 'waitting' . "'";
    
    $query = "INSERT INTO $table_name (name, email, phone, message, product_name, booking_date, status) VALUES ";
    $query .= "(" . implode(',', $data) . ")";
 
    return $wpdb->query($query);
}

function reg_email(){
	if(isset($_POST['email'])){
		saveContact($_POST['email']);
	}	
}

add_action( 'wp_ajax_reg_email', 'reg_email');
add_action( 'wp_ajax_nopriv_reg_email', 'reg_email');

/**
 * save contact to database
 * @author duythanhdao@live.com
 */

function saveContact($email = null){
    global $wpdb;
    $table_name = $wpdb->prefix . "ewp_contact";
    
  		$query = "DELETE FROM $table_name WHERE email LIKE '$email'";
  		$wpdb->query($query);
	    $query = "INSERT INTO $table_name (email) VALUES ";
	    $query .= "('" . $email . "')";  
	if($email) {
		if($wpdb->query($query))
			exit("Thông tin đã được lưu lại, xin cảm ơn!");
		exit("Có lỗi xảy ra, vui lòng thử lại!");  	
    }
}


function home_support($atts){
	extract(shortcode_atts(array(
		'skype' => '',
		'linkedin' => '',
		'facebook' => ''
	), $atts));	
	$str = '
		<div class="home-support">
            <h3 id="hot-line"><span>Hotline:</span>  04 3565 9596</h3>
			<ul>
				<li class="st"><b>Support</b> Online</li>
				<li>
					<a class="sns skype" href="skype:' . $skype . '"></a>
				</li>
				<li>
					<a class="sns linkedin" href="' . $linkedin . '"></a>
				</li>
				<li>
					<a class="sns facebook" href="' . $facebook . '?chat"></a>
				</li>
			</ul>
		</div>	
	';
	
	return $str;
}

function ewp_report($atts){
	extract(shortcode_atts(array(
		'category' => ''
	), $atts));
	
	if($category) {
		$str = '';
		
		$queryObject = new  Wp_Query( array(
			'showposts' => 1000,
			'post_type' => array('post'),
			'category_name' => $category,
			'orderby' => 1
		));
		$str .= '
			<div class="reports-container">
				<ul class="list-reports">';
		$postCount = 0;
		if($queryObject->have_posts()){
			while($queryObject->have_posts()){
				$queryObject->the_post();
				$postCount++;
				if($postCount % 2)
					$str .= '<li class="report-post">';
				add_image_size( 'news-post', 212, 159, true );
				$thumb = get_the_post_thumbnail(get_the_ID(), 'news-post', 'class=post-thumb');
				$permalink = get_permalink();
				$str .= 
					'<div class="report-block">
						<a class="title2" href="' . get_permalink() . '" title="' . wp_specialchars(get_the_title(), 1) . '"> ' .
							$thumb . 	
					'	</a>';
						
				$str .=
						'<a class="title" href="' . $permalink . '" title="' . wp_specialchars(get_the_title(), 1) . '">' .
					 		wp_specialchars(get_the_title(), 1) .
						'</a>' .
						'<p>' . get_the_excerpt() . '</p>
					</div>';
				if(!($postCount % 2))
					$str .= '</li>';
			}
			if($postCount % 2) 
				$str .= '</li>';
		}
		$str .= '
				</ul>
			</div>';
		return $str;
	}
}

function ewp_new_report($atts) {
    extract(shortcode_atts(array(
        'category' => '',
        'title' => '',
        'url' => ''
    ), $atts));
    $str = '';
    $child = '';
    if($category){
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $queryObject = new  Wp_Query( array(
            'showposts' => 12,
            'post_type' => array('post'),
            'category_name' => $category,
            'orderby' => 1,
            'paged' => $paged
        ));

        if($queryObject->have_posts()) {
            $cat = get_category_by_slug($category);
            $str = '<div class="report-container">';
            $postInRow = 0;
            while($queryObject->have_posts()) {
                if ($postInRow == 0) $str .= '<div class="report-group row-fluid">';
                ++$postInRow;
                
                //Get post
                $queryObject->the_post();
                
                //Display post
                add_image_size( 'news-post', 475, 310, true );
                $thumb = get_the_post_thumbnail(get_the_ID(), 'news-post', 'class=post-thumb');
                $permalink = get_permalink();
                // 
                $str .=
                    '<div class="new-report-block span3">
                        <div class="featured-image-container">
        					<a class="title" href="' . $permalink . '" title="' . wp_specialchars(get_the_title(), 1) . '">' .
        						$thumb .
        					'</a>
    				    </div>
        				<div class="entry clearfix">
        					<h2 class="title">
        						<a class="title" href="' . get_permalink() . '" title="' . wp_specialchars(get_the_title(), 1) . '">
        						' . wp_specialchars(get_the_title(), 1) . '
        						</a>
        					</h2>
        					<p>' . get_the_excerpt() . '</p>
        				</div>
        		    </div>';
                
                if ($postInRow == 4) {
                    $postInRow = 0;
                    $str .= '</div>';
                }
            }
            //Paginate number
            $str .= wpbeginner_numeric_posts_nav($queryObject);
            $str .= '</div>';
        }
    }

    return $str;
}

function large_news_box($atts){
	extract(shortcode_atts(array(
		'category' => '',
		'title' => '',
		'url' => ''
	), $atts));
	$str = '';
	$child = '';
	if($category){
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$queryObject = new  Wp_Query( array(
			'showposts' => 4,
			'post_type' => array('post'),
			'category_name' => $category,
			'orderby' => 1,
			'paged' => $paged
		));
		
		if($queryObject->have_posts()):
			$cat = get_category_by_slug($category);
			$str = '
			<div class="news-box large-news-box">';
				$i = 0;
			while($queryObject->have_posts()):
				$queryObject->the_post();
				$class = $i ? 'ewp-small' : '';
					$str .= 
						'<div class="' . $class .'  post type-post status-publish format-standard hentry  post clearfix instock">';
							
							add_image_size( 'news-post', 475, 310, true );
							$thumb = get_the_post_thumbnail(get_the_ID(), 'news-post', 'class=post-thumb');
							$permalink = get_permalink();
							$str .=
							'<div class="featured-image-container">
								<a class="title" href="' . $permalink . '" title="' . wp_specialchars(get_the_title(), 1) . '">' .
									$thumb .
							'	</a>
							</div>
							<div class="entry clearfix">
								<h2 class="title">
									<a class="title" href="' . get_permalink() . '" title="' . wp_specialchars(get_the_title(), 1) . '">
									' . wp_specialchars(get_the_title(), 1) . '
									</a>
								</h2>
								<p>' . get_the_excerpt() . '</p>
								<div class="readmore">
									<a href="' . $permalink . '" title="' . wp_specialchars(get_the_title(), 1) . '">
										Xem thêm
									</a>						
								</div>								
							</div>
						</div>';
				$i++;
			endwhile;
			$str .= wpbeginner_numeric_posts_nav($queryObject);
			$str .= '</div>';
			
		endif;		
	}
	
	return $str;
}

function wpbeginner_numeric_posts_nav($wp_query) {

	$str = '';
	
	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'page' ) ? absint( get_query_var( 'page' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	$str .= '<div class="navigation"><ul>' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		$str .= sprintf( '<li>%s</li>' . "\n", get_previous_posts_link() );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		$str .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			$str .= '<li>…</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		$str .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		$str .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), '>>' );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		$str .= sprintf( '<li>%s</li>' . "\n", get_next_posts_link() );

	$str .= '</ul></div>' . "\n";
	return $str;
}


function home_news($atts){
	extract(shortcode_atts(array(
		'category' => '',
		'title' => '',
		'url' => ''
	), $atts));
	$str = '';
	$child = '';
	if($category){
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$queryObject = new  Wp_Query( array(
			'showposts' => 2,
			'post_type' => array('post'),
			'category_name' => $category,
			'orderby' => 1,
			'paged' => $paged
		));
		
		if($queryObject->have_posts()):
			$cat = get_category_by_slug($category);
				$i = 0;
			while($queryObject->have_posts()):
				$queryObject->the_post();
					$str .= 
						'<div class="home-column  post type-post status-publish format-standard hentry  post clearfix instock">
							<h2 class="title">
								<a class="title" href="' . get_permalink() . '" title="' . wp_specialchars(get_the_title(), 1) . '">
								' . wp_specialchars(get_the_title(), 1) . '
								</a>
							</h2>';	
							add_image_size( 'news-post', 315, 110, true );
							$thumb = get_the_post_thumbnail(get_the_ID(), 'news-post', 'class=post-thumb');
							$permalink = get_permalink();
							$str .=
							'<div class="featured-image-container">
								<a class="title1" href="' . $permalink . '" title="' . wp_specialchars(get_the_title(), 1) . '">' .
									$thumb .
							'	</a>
							</div>
							<div class="entry clearfix">
								<p>' . get_the_excerpt() . '</p>
								<div class="readmore">
									<a href="' . $permalink . '" title="' . wp_specialchars(get_the_title(), 1) . '">
										' . __('Read more') . '
									</a>						
								</div>								
							</div>
						</div>';
				$i++;
			endwhile;
			
		endif;		
	}
	
	return $str;
}


// custom excerpt length
function custom_excerpt_length( $length ) {
return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


//Timthumb
function thumb_img($post_id,$h,$w,$q,$zc,$alt){

	echo '<img align="middle" src="';

	echo bloginfo('template_url');

	echo '/timthumb.php?src='.get_featured_img($post_id).'&amp;h='.$h.'&amp;w='.$w.'&amp;q='.$q.'&amp;zc='.$zc.'" alt="'.$alt.'" 														

	/>';   

	}

function home_youtube($atts){
	extract(shortcode_atts(array(
		'v' => '',
		'text' => '',
		'title' => ''
	), $atts));

	if($v) {
		$str = '
			<h2 class="title">
				<a class="title" href="http://www.youtube.com/watch?v=' . $v . '" title="' . $title. '">
					' . $title . '
				</a>
			</h2>
			<iframe width="100%" height="200" src="//www.youtube.com/embed/' . $v . '" frameborder="0" allowfullscreen class="home-youtube"></iframe>
			<p class="home-youtube-note">' . $text . '</p>
			<div class="readmore youtube-readmore">
				<a href="http://www.youtube.com/watch?v=' . $v . '">
					' . __('View on Youtube') . '
				</a>						
			</div>	
		';
		return $str;
	}		
}

function home_partners( $attr ) {
	extract( shortcode_atts( array(
			'id'	=> '',
		), $attr ) 
	);
	$args = array(
		'post_type'	=> 'gallery',
		'post_status' => 'publish',
		'p' => $id,
		'posts_per_page' => 1
	);	
	ob_start();
	$second_query = new WP_Query( $args ); 
	$gllr_options = get_option( 'gllr_options' ); 
	if ( $second_query->have_posts() ) : 
		?>
		<ul class="list-reports">
		<?php
		while ( $second_query->have_posts() ) : 
			global $post;
			$second_query->the_post(); ?>
				<?php the_content(); 
				$posts = get_posts( array(
					"showposts"			=> -1,
					"what_to_show"	=> "posts",
					"post_status"		=> "inherit",
					"post_type"			=> "attachment",
					"orderby"				=> $gllr_options['order_by'],
					"order"					=> $gllr_options['order'],
					"post_mime_type"=> "image/jpeg,image/gif,image/jpg,image/png",
					"post_parent"		=> $post->ID
				));
				if( count( $posts ) > 0 ) {
					$count_image_block = 0; ?>
						<?php foreach( $posts as $attachment ) { 
							$key = "gllr_image_text";
							$link_key = "gllr_link_url";
							$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'photo-thumb' );
							$image_attributes_large = wp_get_attachment_image_src( $attachment->ID, 'large' );
							$image_attributes_full = wp_get_attachment_image_src( $attachment->ID, 'full' );
							if( 1 == $gllr_options['border_images'] ){
								$gllr_border = 'border-width: '.$gllr_options['border_images_width'].'px; border-color:'.$gllr_options['border_images_color'].'';
								$gllr_border_images = $gllr_options['border_images_width'] * 2;
							}
							else{
								$gllr_border = '';
								$gllr_border_images = 0;
							}
							if( $count_image_block % $gllr_options['custom_image_row_count'] == 0 ) { ?>
							<?php } ?>
								<li class="gllr_image_block">
									<?php if( ( $url_for_link = get_post_meta( $attachment->ID, $link_key, true ) ) != "" ) { ?>
										<a href="<?php echo $url_for_link; ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" target="_blank">
											<img style="width:<?php echo $gllr_options['gllr_custom_size_px'][1][0]; ?>px;height:<?php echo $gllr_options['gllr_custom_size_px'][1][1]; ?>px; <?php echo $gllr_border; ?>" alt="" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" src="<?php echo $image_attributes[0]; ?>" />
										</a>
									<?php } else { ?>
								
										<img style="width:<?php echo $gllr_options['gllr_custom_size_px'][1][0]; ?>px;height:<?php echo $gllr_options['gllr_custom_size_px'][1][1]; ?>px; <?php echo $gllr_border; ?>" alt="" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" src="<?php echo $image_attributes[0]; ?>" rel="<?php echo $image_attributes_full[0]; ?>" />
								
									<?php } ?>
								</li>
							<?php if( $count_image_block%$gllr_options['custom_image_row_count'] == $gllr_options['custom_image_row_count']-1 ) { ?>
							<?php } 
							$count_image_block++; 
						} 
						if( $count_image_block > 0 && $count_image_block%$gllr_options['custom_image_row_count'] != 0 ) { ?>
						<?php } ?>
					<?php } ?>
		<?php endwhile; ?>
		</ul>		
	<?php else: ?>
		<div class="gallery_box_single">
			<p class="not_found"><?php _e( 'Sorry, nothing found.', 'gallery' ); ?></p>
		</div>
	<?php endif; ?>
<?php
	$gllr_output = ob_get_clean();
	wp_reset_query();
	return $gllr_output;
}
	
/*********Amin area*******/

?>