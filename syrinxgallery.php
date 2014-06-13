<?php
/**
 * @package syrinxgallery
 * @version 1.1.0
 */
/*
Plugin Name: Syrinx Slideshow Gallery and Editor
Plugin URI: http://wordpress.kusog.org/slideshow-including-powerful-editor/
Description: The Syrinx Slideshow provides 3 powerful jQuery plugins for playing, controlling, and editing slideshows with multiple options for how slideshows can be displayed in a WordPress site.  Each slide background image can pan & zoom while having multiple animated layers displaying over it it.  Powerful editor allows for finetune, multi keyframe animation definitions with amazing results.
Author: Maryann Denman / Matt Denman
Version: 1.1.0
Author URI: http://wordpress.kusog.org/
*/


$syx_usePageForSlideshow = true;
$postTitlePrefix = 'Slideshow - ';

function my_scripts_method() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jqueryui');
    wp_enqueue_style('syrinxslideshow-style', plugins_url('/css/SyrinxSlideShow.css', __FILE__));
    wp_enqueue_script('syrinxslideshow', plugins_url('/js/jquery.syrinx-slideshow-.08.js', __FILE__),array('jquery'),'',true);
	wp_enqueue_script('syrinxslideshow-controllers', plugins_url('/js/jquery.syrinx-slideshow-controllers-.02.js', __FILE__),array('jquery'),'',true);
    wp_enqueue_script('syrinxslideshow-editor', plugins_url('/js/jquery.syrinx-slideshow-editor-.05.js', __FILE__),array('jquery'),'',true);		
    wp_enqueue_script('syrinxslideshow-wp', '/wp-admin/admin-ajax.php?action=syx_get_wpJs',array('syrinxslideshow'),'',true);		
}    

function syx_saveSlideShowAsPost($id, $html, $asPage) {
    global $wpdb;
    global $current_user;
    get_currentuserinfo();

    if($asPage == true) {

        $post = array ();

        $postId = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='syx_slideshow'", $id ));

        // Create post object
        $post['post_title'] = $postTitlePrefix.$id;
        $post['post_type'] = 'syx_slideshow';
        $post['post_content'] = $html;
        $post['post_status'] = 'publish';
        $post['post_author'] = $current_user->ID;

        if ( $postId ) {
            $post['ID'] = $postId;
            wp_update_post($post);
        }
        else {        
            // Insert the post into the database
            wp_insert_post($post);
        }
    }
}

function syx_getSlideshowsFromPosts() {
    global $wpdb;
    $list = array();
    
    $posts = get_posts(array( 'post_type' => 'syx_slideshow', 'numberposts' => -1 ));
    foreach( $posts as $post ) {
		$users = $wpdb->get_results("SELECT display_name FROM $wpdb->users WHERE ID = ".intval($post->post_author) . " LIMIT 1");
		foreach ($users AS $user)
            array_push($list, array('id' => $post->post_title, 'title' => $post->post_title, 'author' => $user->display_name, 'date' => $post->post_date, 'html' => $post->post_content));
    }

    return $list;
}


add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'syx_slideshow',
		array(
			'labels' => array(
				'name' => __( 'Syrinx Slideshow' ),
				'singular_name' => __( 'Slideshows' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}


         
function syx_sc_insertSlideShow($attr) {
    global $syx_usePageForSlideshow;
    $id = $attr["id"];
    $html = syx_get_slideshowI($id);

    return $html;
}

function syx_save_slideshowx() {
    global $syx_usePageForSlideshow;
    if(current_user_can("edit_posts")) {
        $id =  $_POST["id"];
        $html = $_POST["html"];
        $html = stripslashes($_POST["html"]);

        if($syx_usePageForSlideshow) {
            syx_saveSlideShowAsPost($id, $html, true);
        }
        else {
            $base = dirname(__FILE__);
            $fileName = $base.'/slideshows/'.$id.'.html';
            file_put_contents($fileName, $html);    
        }
    }
    die();
}

function syx_get_slideshow() {
    echo syx_get_slideshowI($_POST["id"]);
    die();
}
function syx_get_slideshowI($id) {
    global $syx_usePageForSlideshow;
    global $wpdb;
    $html = '';
    
    if($syx_usePageForSlideshow) {
        $postId = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='syx_slideshow'", $id ));
        if ( $postId ) {
            $post = get_post($postId);
            $html = $post->post_content;            
        }
        echo "<!-- getting slideshow from post";
        echo $html;
        echo "-->";
    }
    else {
        $base = dirname(__FILE__);
        $fileName = $base.'/slideshows/'.$id.'.html';
        $html = file_get_contents($fileName);
        echo "<!-- getting slideshow from file -->";
    }

    return $html;
 }

function syx_get_wpJs() {
    header('Content-type: text/javascript');
    $script = '(function ($) {$(function () { var $slideshows = $(".entry-content .ksg-slide-show").syrinxSlider({});';
    if(current_user_can("edit_posts")) 
            $script .= '$slideshows.syrinxSlideShowEditor({});';
    $script .= '});})(jQuery);';
    echo $script;
    die();
}

function syx_getExistingSlideShowIds() {
    global $syx_usePageForSlideshow;
    if($syx_usePageForSlideshow == true) {
        return syx_getSlideshowsFromPosts();
    }
    else {
        $list = array();
        $files = scandir(dirname(__FILE__).'/slideshows/');
        foreach($files as $file) {
            if(preg_match('/(.*?)\.html$/', $file, $matches)) {
                if($matches[1] != "_blank")
                    array_push($list, $matches[1]);
            }
        }
        
        return $list;
    }
}

function syx_createNewSlideShow($ssId) {
    global $syx_usePageForSlideshow;

    $base = dirname(__FILE__);
    $fileName = $base.'/slideshows/'.$ssId.'.html';
    $blank = preg_replace("/id='_blank'/", "id='$ssId'", file_get_contents($base.'/slideshows/_blank.html'));
        
    if($syx_usePageForSlideshow == true) {
        syx_saveSlideShowAsPost($ssId, $blank, true);
    }
    else {
        $base = dirname(__FILE__);
        $fileName = $base.'/slideshows/'.$ssId.'.html';
        file_put_contents($fileName, $blank);
    }
}


class Syrinx_SlideShow extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
	 		'syrinx_slideshow', // Base ID
			'Syrinx Slideshow', // Name
			array( 'description' => __( 'A multi-layer image slideshow that can be full screen or a small area.', 'text_domain' ), ) // Args
		);
	}

 	public function form( $instance ) {
		// outputs the options form on admin
		if ( isset( $instance[ 'ssId' ] ) ) {
			$ssId = $instance[ 'ssId' ];
		}
		else {
			$ssId = __( 'SlideShow1', 'text_domain' );
		}
		?>
        <div>
		<p>
		<label for="<?php echo $this->get_field_id( 'ssId' ); ?>"><?php _e( 'Slide Show Id:' ); ?></label> 
		<select class="widefat syx-slide-id" id="<?php echo $this->get_field_id( 'ssId' ); ?>" name="<?php echo $this->get_field_name( 'ssId' ); ?>">
            <option value="_CreateNew_">Create New...</option>
		<?php 
            $list = syx_getExistingSlideShowIds();
            foreach($list as $sshow) {
                echo '<option value="' . $sshow['id'] . '" ';
                if($sshow['id'] == $ssId)
                    echo ' selected="selected"';
                echo '>'.$sshow['title'].'</option>';
            }
        ?>
        </select>
        </p>
        <div class="syx-new-slide-id" style="display: none;">
            <p>
		    <label for="<?php echo $this->get_field_id( 'newssId' ); ?>"><?php _e( 'New Id:' ); ?></label> 
		    <input class="widefat" id="<?php echo $this->get_field_id( 'newssId' ); ?>" name="<?php echo $this->get_field_name( 'newssId' ); ?>" type="text" value="<?php echo esc_attr( $newssId ); ?>" />
            </p>
        </div>
		</div>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
        $ssId = strip_tags( $new_instance['ssId'] );
        $newssId = strip_tags($new_instance['newssId']);
        if($ssId == '_CreateNew_') {
            $instance['ssId'] = $newssId;
            syx_createNewSlideShow($newssId);
        }
        else
            $instance['ssId'] = $ssId;

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );
		$ssId = apply_filters( 'widget_ssId', $instance['ssId'] );

		echo $before_widget;

        
        $html = syx_get_slideshowI($ssId).'<script>jQuery(function() {jQuery("#'.$ssId.'").syrinxSlider({})';
        if(current_user_can("edit_posts")) {
        $html .= '.syrinxSlideShowEditor({});';
        }
        else {
            $html .= ';';
        }
        $html .= '});</script>';

        echo $html;

		echo $after_widget;	
    }

}
add_action( 'widgets_init', create_function( '', 'register_widget( "Syrinx_SlideShow" );' ) );
 
add_action('wp_enqueue_scripts', 'my_scripts_method');

add_shortcode('syrinxslideshow', 'syx_sc_insertSlideShow');

add_action('wp_ajax_syx_save_slideshow', 'syx_save_slideshowx');
add_action('wp_ajax_syx_get_slideshow', 'syx_get_slideshow');
add_action('wp_ajax_nopriv_syx_save_slideshow', 'syx_save_slideshowx');
add_action('wp_ajax_syx_get_wpJs', 'syx_get_wpJs');
add_action('wp_ajax_nopriv_syx_get_wpJs', 'syx_get_wpJs');

add_action('admin_enqueue_scripts', 'queue_my_admin_scripts');

add_action('admin_menu', 'register_custom_menu_page');

function register_custom_menu_page() {
    add_menu_page('Site Slideshows', 'Slideshows', 'add_users', 'syrinx-slideshow/admin-index.php', '',   plugins_url('syrinx-slideshow/images/icon.png'), 6);
    remove_menu_page( 'edit.php?post_type=syx_slideshow' );
   
}


function syx_moveFileSlideShowsToPosts() {
    $files = scandir(dirname(__FILE__).'/slideshows/');
    foreach($files as $file) {
        if(preg_match('/(.*?)\.html$/', $file, $matches)) {
            if($matches[1] != "_blank") {
                $base = dirname(__FILE__);
                $fileName = $base.'/slideshows/'.$file;
                $html = file_get_contents($fileName);                
                syx_saveSlideShowAsPost($matches[1], $html, true);
                unlink($fileName);
            }
        }
    }
}

function queue_my_admin_scripts() {
    syx_moveFileSlideShowsToPosts();
    my_scripts_method();
    wp_enqueue_script('media-upload');
    wp_enqueue_style('thickbox');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('syrinxslideshow-wpadmin', plugins_url('/js/syrinx-slideshow-wpadmin.02.js', __FILE__),array('jquery','jquery-ui-dialog'),'',true);		    
    wp_enqueue_style (  'wp-jquery-ui-dialog');
}


function syx_createNew_slideshowx() {
    if(current_user_can("edit_posts")) {
      echo "done:".$_POST["ssId"];
      syx_createNewSlideShow($_POST["ssId"]);
    }
    die();
}
add_action('wp_ajax_syx_createNew_slideshow','syx_createNew_slideshowx');

function syx_delete_slideshow() {
    global $wpdb;
    global $syx_usePageForSlideshow;

    if(current_user_can("edit_posts")) {    
        if($syx_usePageForSlideshow) {            
            $postId = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='syx_slideshow'", $_POST["ssId"] ));
            wp_delete_post($postId);
        }
        else {
            $base = dirname(__FILE__);
            $fileName = $base.'/slideshows/'.$_POST["ssId"].'.html';
            unlink($fileName);
        }
    }
    die();
}
add_action('wp_ajax_syx_delete_slideshow','syx_delete_slideshow');

add_action( 'admin_menu', 'my_admin_setup' );

function my_admin_setup() {

	/* Custom help message. */
	$text = '<p>' . __( 'This is an example of contextual help in WordPress, you could edit this to put information about your plugin or theme so that users will understand what the heck is going on.', 'example-textdomain' ) . '</p>';

	/* Add documentation and support forum links. */
	$text .= '<p><strong>' . __( 'For more information:', 'example-textdomain' ) . '</strong></p>';

	$text .= '<ul>';
	$text .= '<li><a href="http://yoursite.com/theme-documentation">' . __( 'Documentation', 'example-textdomain' ) . '</a></li>';
	$text .= '<li><a href="http://yoursite.com/support">' . __( 'Support Forums', 'example-textdomain' ) . '</a></li>';
	$text .= '</ul>';

	add_contextual_help( 'appearance_page_theme-settings', $text );
}

?>
