<?php
// Add custom Theme Functions here
function add_file_types_to_uploads($file_types){
$new_filetypes = array();
$new_filetypes['svg'] = 'image/svg+xml';
$file_types = array_merge($file_types, $new_filetypes );
return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');

function webp_upload_mimes( $existing_mimes ) {
	// add webp to the list of mime types
	$existing_mimes['webp'] = 'image/webp';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'mime_types', 'webp_upload_mimes' );

// Hàm thay đổi logo url
function mhweb_custom_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'mhweb_custom_logo_url' );
// Gỡ bỏ các thành phần trên Admin Bar
function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          /** Remove the WordPress logo **/
    $wp_admin_bar->remove_menu('about');            /** Remove the about WordPress link **/
    $wp_admin_bar->remove_menu('wporg');            /** Remove the WordPress.org link **/
    $wp_admin_bar->remove_menu('documentation');    /** Remove the WordPress documentation link **/
    $wp_admin_bar->remove_menu('support-forums');   /** Remove the support forums link **/
    $wp_admin_bar->remove_menu('feedback');         /** Remove the feedback link **/
    $wp_admin_bar->remove_menu('view-site');        /** Remove the view site link **/
    $wp_admin_bar->remove_menu('updates');          /** Remove the updates link **/
    $wp_admin_bar->remove_menu('comments');         /** Remove the comments link **/
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );


/*404 to home*/
add_action('wp', 'redirect_404_to_homepage', 1);
function redirect_404_to_homepage() {
    global $wp_query;
    if ($wp_query->is_404) {
        wp_redirect(get_bloginfo('url'),301)
        ;exit;
    }
}


/*** Remove Query String from Static Resources ***/
function remove_cssjs_ver( $src ) {
 if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
 return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Remove comment-reply.min.js from footer
function crunchify_clean_header_hook(){
    wp_deregister_script( 'comment-reply' );
         }
add_action('init','crunchify_clean_header_hook');
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Tùy chỉnh chất lượng ảnh khi upload lên website
add_filter( 'jpeg_quality', 'custom_jpeg_quality' );
function custom_jpeg_quality( $quality ) {
   return 100;
}

/*Chặn update*/
function remove_core_updates(){
    global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');
ini_set('xdebug.max_nesting_level', 50000);

/**
 * Sửa chữ dưới footer của trang quản trị
 */
 function mh_admin_footer_credits( $text ) {
    $text = '<p>Thiết kế bởi <a href="https://minhhien.vn" target="_blank">MH Solutions</a></p>';
     return $text;
 }
add_filter( 'admin_footer_text', 'mh_admin_footer_credits' );

/**
 * Xóa widget mặc định trong trang quản trị
 */
function remove_dashboard_meta() {
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        //remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
        remove_action( 'welcome_panel', 'wp_welcome_panel' );//since 3.8
}
add_action( 'admin_init', 'remove_dashboard_meta' );
/**
 * Tạo widget trong trang quản trị
 */
 function mh_create_admin_widget_notice() {
    wp_add_dashboard_widget( 'mh_notice', 'MH Solutions', 'mh_create_admin_widget_notice_callback' );
 }
add_action( 'wp_dashboard_setup', 'mh_create_admin_widget_notice' );
function mh_create_admin_widget_notice_callback() {
  echo '<p><strong>Website: ' . get_bloginfo('name') .' </strong></p>
  <p>Thiết kế bởi: Công ty TNHH Giải pháp Minh Hiển </p>
  <p>Địa chỉ: 520/44/10A Quốc lộ 13, P. Hiệp Bình Phước, Q. Thủ Đức, Hồ Chí Minh</p>
  <p>Website: <a href="https://minhhien.vn" target="_blank"> https://minhhien.vn</a> - Email: <a href="mailto:lienhe@minhhien.vn">lienhe@minhhien.vn</a></p>
  <p>Hotline hỗ trợ: <a href="+84908038577">0908.038.577</a> - <a href="+84983817035">0983.817.035</a></p>' ;
}



function call_booking(){
    global $product;
    $var = '';
    if($product->is_type('booking')){
        ob_start();
        // Prepare form
        $booking_form = new WC_Booking_Form( $product );
    
        // Get template
        wc_get_template( 'single-product/add-to-cart/booking.php', array( 'booking_form' => $booking_form ), 'woocommerce-bookings', WC_BOOKINGS_TEMPLATE_PATH );
        $var = ob_get_contents();
        ob_end_clean(); 
    }
	else{
		ob_start();
		echo '<div class="no-booking">'.do_shortcode("[ux_product_price]");
		echo do_shortcode("[ux_product_add_to_cart]").'</div>';
		$var = ob_get_contents();
		ob_end_clean();
	}
    return $var;
}
add_shortcode('call_booking', 'call_booking');


function wc_wc20_variation_price_format( $price, $product ) {
 //Main Price
 $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
 $price = $prices[0] !== $prices[1] ? sprintf( __( 'Giá từ: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
 // Sale Price
 $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
 sort( $prices );
 $saleprice = $prices[0] !== $prices[1] ? sprintf( __( 'Giá từ: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
 if ( $price !== $saleprice ) {
 $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
 }
 return $price;
}
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );


/***** Start Location  ******/

function get_level($category, $level = 0){
    if ($category->parent == 0) {
        return $level;
    }else{
        $level++;
        $category = get_term($category->parent);
        return get_level($category, $level);
    }
}
function display_cat_level( $taxonomy = 'category', $level = 0 , $parent = NULL){
    $output = array();      
    $catArgs = array( 'hide_empty' => false);
    if( $parent != NULL ){
        $catArgs['child_of'] = $parent;
    }       
    $catArgs['taxonomy'] = $taxonomy;
     
    $cats = get_terms( $catArgs );
             
    if( $cats && !is_wp_error($cats) ){
        $stt = 0;
        foreach($cats as $cat){
            $current_cat_level = get_level($cat);
            if( $current_cat_level == $level ){
                $output[$stt]['name'] = $cat->name;
                $output[$stt]['link'] = get_term_link($cat->term_id);
                $output[$stt]['id'] = $cat->term_id;
            }
            $stt++;
        }
    }
    return $output;
}
function call_product_cat(){
    $terms = display_cat_level('product_cat');
    $string = '<div class="pu-container">';
    $string .= '<table>';
    foreach($terms as $term){
        $string .= '<tr>';
        $string .= '<th>'. $term['name'] . '</th>' .'<td>' ;
        $terms1 = display_cat_level('product_cat',1,$term['id']);
        foreach($terms1 as $term1){
            $string .= "<a class='quocgia' data-id='". $term1['id'] ."' href='". $term1['link'] ."'>" . $term1['name'] . '</a>' ;
        }
        $string .= '</tr>' .'</td>';
    }
    $string .= '</table></div>';

    return $string;
}
add_shortcode( 'cpc', 'call_product_cat' );
/*
// function ajax location home
add_action( 'wp_enqueue_scripts', 'ajax_enqueue_scripts' );
function ajax_enqueue_scripts() {
    wp_register_script( 'location', get_stylesheet_directory_uri(). '/js/location.js', array('jquery'), 'true' );
	wp_enqueue_script( 'location');
	wp_localize_script( 'location', 'mhlocation', array('ajaxurl' => admin_url('admin-ajax.php')));
}

add_action('wp_ajax_getcat','get_cat_ajax');
add_action('wp_ajax_nopriv_getcat', 'get_cat_ajax');
function get_cat_ajax(){
    if(isset($_POST['id'])){
        $term = display_cat_level('product_cat',2,$_POST['id']);
    } else {
		die("Secure Prolem");
    }
    wp_send_json_success($term);
}
// END FUNCTION AJAX LOCATION HOME
*/
// FUNCTION AJAX PRODUCT MENU
add_action('wp_enqueue_scripts', 'product_script');
function product_script(){
    wp_register_script('productsp', get_stylesheet_directory_uri(). '/js/product.js', array('jquery'), 'true');
    wp_enqueue_script('productsp');
}
// FUNCTION STICKY WIDGET 
/*
if(! is_admin()){   
add_action('wp_enqueue_scripts', 'sticky');	
}
function sticky() {
    wp_register_script('detectmobile', get_stylesheet_directory_uri()."/js/detectmobilebrowser.js", array( 'jquery'), '', false );
    wp_enqueue_script('detectmobile'); 
    wp_register_script('sticky', get_stylesheet_directory_uri()."/js/sticky-widget.js", array( 'jquery'), '', false );
    wp_enqueue_script('sticky'); 
}
//END STICKY WIDGET
*/
//Thông tin thêm sản phẩm
function top_info() {
	$ttt = "<div class='add-info'>";
	$topinfo = get_field('top-info');
    if ($topinfo) {
        $ttt .= "<div class='top-info'>";
		foreach( $topinfo as $topinfo ):
			$ttt .=  "<div class='col small-12 medium-4'>". $topinfo ."</div>";
		endforeach;
		$ttt .= "</div><div class='clearfix'></div></div>";
    }
	else $ttt .= '</div>';
	return $ttt;
}
add_shortcode('top_info', 'top_info');

//Thông tin dịch vụ
function call_chitiet() {
    global $product;
    $ds = $product->get_description();
   
    $ds = apply_filters( 'the_content', $ds );
    $ds = str_replace(']]>',']]&gt;',$ds);
	
	return '<h3 class="cs-content-title" id="ttdv">Thông tin dịch vụ</h3>'. $ds .'<style>#masthead {border-bottom: 1px solid #ececec !important; padding-bottom: 5px;}</style>';
}
add_shortcode('call_chitiet', 'call_chitiet');

// Call HD sử dụng
function hdsd() {
	$hdsd = get_field('huong-dan-su-dung');
	if ($hdsd) {
		return '<h3 class="cs-content-title" id="hdsd">Hướng dẫn sử dụng</h3>' . $hdsd;
	}
	else return;
}
add_shortcode('hdsd', 'hdsd');

//Facebook comment
function fbcomment() {
	global $wp;
	$current_url = home_url( add_query_arg( array(), $wp->request ) );
	$fb = '<div class="fb-like" data-href="'. $current_url .'" data-layout="standard" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div><div class="fb-comments" data-href="'. $current_url .'" data-width="100%" data-numposts="5"></div>';
	return $fb;
}
add_shortcode('fbcomment', 'fbcomment');

//register new menu

function register_new_menu(){
    register_nav_menu( 'content', __('Content product menu') );
}
add_action('init', 'register_new_menu');



//Code get ảnh đại diện
function anh_dai_dien() {
  global $post;
  global $product;
  if (has_post_thumbnail( $post->ID ) ) {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID, 'full' ), 'single-post-thumbnail' );
  }

    return '<div class="anh-feature" style="background-image: url('.$image[0].'); background-size: cover; height: 450px;"></div>';
}
add_shortcode('anh_dai_dien', 'anh_dai_dien');

# limite product title string
function shorten_woo_product_title( $title, $id ) {
    if ( ! is_product() && get_post_type( $id ) === 'product' ) {
        return wp_trim_words( $title, 10 ); // change last number to the number of WORDS you want
    } else {
        return $title;
    }
}
add_filter( 'the_title', 'shorten_woo_product_title', 10, 2 );

//========================================
class Auto_Save_Images {
    function __construct(){

        add_filter( 'content_save_pre',array($this,'post_save_images') ); 
    }

    function post_save_images( $content ){
        if( ($_POST['save'] || $_POST['publish'] )){
            set_time_limit(240);
            global $post;
            $post_id=$post->ID;
            $preg=preg_match_all('/<img.*?src="(.*?)"/',stripslashes($content),$matches);
            if($preg) {
                foreach($matches[1] as $image_url) {
                    if(empty($image_url)) continue;
                    $pos=strpos($image_url,$_SERVER['HTTP_HOST']);
                    if($pos === false) {
                        $res=$this->save_images($image_url,$post_id);
                        $replace=$res['url'];
                        $content=str_replace($image_url,$replace,$content);
                    }
                }
            }
        }
        remove_filter( 'content_save_pre', array( $this, 'post_save_images' ) );
        return $content;
    }

    function save_images($image_url,$post_id) {
        $file=file_get_contents($image_url);
        $post = get_post($post_id);
        $posttitle = $post->post_title;
        $postname = sanitize_title($posttitle);
        $im_name = "$postname-$post_id.jpg";
        $res=wp_upload_bits($im_name,'',$file);
        $this->insert_attachment($res['file'],$post_id);
        return $res;
    }

    function insert_attachment($file,$id) {
        $dirs=wp_upload_dir();
        $filetype=wp_check_filetype($file);
        $attachment=array(
            'guid'=>$dirs['baseurl'].'/'._wp_relative_upload_path($file),
            'post_mime_type'=>$filetype['type'],
            'post_title'=>preg_replace('/\.[^.]+$/','',basename($file)),
            'post_content'=>'',
            'post_status'=>'inherit'
        );
        $attach_id=wp_insert_attachment($attachment,$file,$id);
        $attach_data=wp_generate_attachment_metadata($attach_id,$file);
        wp_update_attachment_metadata($attach_id,$attach_data);
        return $attach_id;
    }
}
new Auto_Save_Images();
//========================================

//Contact form 7
add_action( 'wp_print_styles', 'aa_deregister_styles', 100 );
function aa_deregister_styles() {
    if ( ! is_page( 'lien-he' ) ) {
        wp_deregister_style( 'contact-form-7' );
    }
}

//Bài viết liên quan
function mh_add_post_content($content) {
  if (is_single()) {
    $content .= "<div class='clearfix'></div>";
    global $post;
    $categories = get_the_category($post->ID);
    if ($categories) {
      $category_ids = array();
      foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
      $args=array(
        'category__in' => $category_ids,
        'post__not_in' => array($post->ID),
        'posts_per_page'=> 3, // Number of related posts that will be shown.
        'caller_get_posts'=>1
      );

      $my_query = new wp_query( $args );
      if( $my_query->have_posts() ) { 		
        $content .= '<div id="related_posts"><h3>Tin tức khác</h3><ul>';
        while( $my_query->have_posts() ) {
            		$my_query->the_post();
          $content .= '
            <li class="col large-4">
              <div class="relatedthumb">
                <a href="' . get_the_permalink() .'">'. get_the_post_thumbnail().'</a>
              </div>
                  		<div class="relatedcontent">
                      		<h3>
                      			<a href="'. get_the_permalink().'">'. get_the_title().'</a>
                      		</h3>
                        	</div>
                      </li>';
        } //End while
        $content .= "</ul></div> 
        <div class='clearfix'></div>";
      } //End if
    } //End if
  }
  return $content;
}

add_filter ('the_content', 'mh_add_post_content', 0);


function remove_menus(){
  
  remove_menu_page( 'index.php' );                  //Dashboard
//  remove_menu_page( 'edit.php' );                   //Posts
//  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit.php?post_type=blocks' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'themes.php' );                 //Appearance
  remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
 remove_menu_page( 'options-general.php' );        //Settings
  remove_menu_page ('admin.php?page=sbp-options');
  
}
// add_action( 'admin_menu', 'remove_menus' );
/**
 * Produces cleaner filenames for uploads
 */
function ttv_sanitize_file_name( $filename ) {
    $sanitized_filename = remove_accents( $filename ); // Convert to ASCII
    // Standard replacements
    $invalid = array(
        ' '   => '-',
        '%20' => '-',
        '_'   => '-',
    );
    $sanitized_filename = str_replace( array_keys( $invalid ), array_values( $invalid ), $sanitized_filename );
    $sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename); // Remove all non-alphanumeric except .
    $sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename); // Remove all but last .
    $sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename); // Replace any more than one - in a row
    $sanitized_filename = str_replace('-.', '.', $sanitized_filename); // Remove last - if at the end
    $sanitized_filename = strtolower( $sanitized_filename ); // Lowercase
    return $sanitized_filename;
}
add_filter( 'sanitize_file_name', 'ttv_sanitize_file_name', 10, 1 );