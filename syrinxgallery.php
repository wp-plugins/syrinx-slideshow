<?php
/**
 * @package syrinxgallery
 * @version 1.0.4
 */
/*
Plugin Name: Syrinx Slideshow Gallery and Editor
Plugin URI: http://wordpress.kusog.org/?p=12
Description: The Syrinx Slideshow with multi layer support
Author: Maryann Denman / Matt Denman
Version: 1.0.4
Author URI: http://wordpress.kusog.org/
*/

function my_scripts_method() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jqueryui');
    wp_enqueue_style('syrinxslideshow-style', plugins_url('/css/SyrinxSlideShow.css', __FILE__));
    wp_enqueue_script('syrinxslideshow', plugins_url('/js/jquery.syrinx-slideshow-.07.js', __FILE__),array('jquery'),'',true);
	wp_enqueue_script('syrinxslideshow-controllers', plugins_url('/js/jquery.syrinx-slideshow-controllers-.01.js', __FILE__),array('jquery'),'',true);
    wp_enqueue_script('syrinxslideshow-editor', plugins_url('/js/jquery.syrinx-slideshow-editor-.03.js', __FILE__),array('jquery'),'',true);		
}    

         
function syx_sc_insertSlideShow($attr) {
    $id = $attr["id"];
    $base = dirname(__FILE__);
    $fileName = $base.'/slideshows/'.$id.'.html';
    $html = file_get_contents($fileName).'<script>jQuery(function() {jQuery("#'.$id.'").syrinxSlider()';
   if(current_user_can("edit_posts")) {
    $html .= '.syrinxSlideShowEditor();';
    }
    else {
        $html .= ';';
    }
    $html .= '});</script>';

    return $html;
}

function syx_save_slideshowx() {
    if(current_user_can("edit_posts")) {
      $id =  $_POST["id"];
      $html = $_POST["html"];
          $html = stripslashes($_POST["html"]);
      $base = dirname(__FILE__);
      $fileName = $base.'/slideshows/'.$id.'.html';
      file_put_contents($fileName, $html);    
    }
    die();
}

function syx_get_slideshow() {
    echo syx_get_slideshowI($_POST["id"]);
    die();
}
function syx_get_slideshowI($id) {
    $base = dirname(__FILE__);
    $fileName = $base.'/slideshows/'.$id.'.html';
    $html = file_get_contents($fileName);
    return $html;
 }

function syx_getExistingSlideShowIds() {
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

function syx_createNewSlideShow($ssId) {
    $base = dirname(__FILE__);
    $fileName = $base.'/slideshows/'.$ssId.'.html';
    file_put_contents($fileName, preg_replace("/id='_blank'/", "id='$ssId'", file_get_contents($base.'/slideshows/_blank.html')));
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
            foreach($list as $name) {
                echo '<option';
                if($name == $ssId)
                    echo ' selected="selected"';
                echo '>'.$name.'</option>';
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

        $base = dirname(__FILE__);
        $fileName = $base.'/slideshows/'.$ssId.'.html';

        $html = file_get_contents($fileName).'<script>jQuery(function() {jQuery("#'.$ssId.'").syrinxSlider()';
        if(current_user_can("edit_posts")) {
        $html .= '.syrinxSlideShowEditor();';
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

add_action('admin_enqueue_scripts', 'queue_my_admin_scripts');

add_action('admin_menu', 'register_custom_menu_page');

function register_custom_menu_page() {
   add_menu_page('Site Slideshows', 'Slideshows', 'add_users', 'syrinx-slideshow/admin-index.php', '',   plugins_url('syrinx-slideshow/images/icon.png'), 6);
}


function queue_my_admin_scripts() {
    my_scripts_method();
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('syrinxslideshow-wpadmin', plugins_url('/js/syrinx-slideshow-wpadmin.01.js', __FILE__),array('jquery','jquery-ui-dialog'),'',true);		    
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
    if(current_user_can("edit_posts")) {
      $base = dirname(__FILE__);
      $fileName = $base.'/slideshows/'.$_POST["ssId"].'.html';
      unlink($fileName);
    }
    die();
}
add_action('wp_ajax_syx_delete_slideshow','syx_delete_slideshow');
?>
