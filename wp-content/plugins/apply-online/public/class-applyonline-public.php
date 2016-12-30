<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wpreloaded.com/farhan-noor
 * @since      1.0.0
 *
 * @package    Applyonline
 * @subpackage Applyonline/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Applyonline
 * @subpackage Applyonline/public
 * @author     Farhan Noor <farhan.noor@yahoo.com>
 */
class Applyonline_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

                new SinglePostTemplate();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Applyonline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Applyonline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/applyonline-public.css', array(), '1.11.4', 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Applyonline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Applyonline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/applyonline-public.js', array( 'jquery','jquery-ui-datepicker' ), $this->version, false );   
                wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
                wp_localize_script ( 
                        $this->plugin_name, 
                        'aol_ajax', 
                        array('ajaxurl' => admin_url ( 'admin-ajax.php' ))
                );
	}
        public function debuger($content){
        }
}

class SinglePostTemplate{
    
        public function __construct() {
            add_filter( 'the_content', array($this, 'aol_content') );
        }
    
        public function aol_ad_is_checked($i){
            if($i==0) $checked="checked";
            else $checked = NULL;
            return $checked;
        }


        public function application_form(){
            ob_start();
            ?>
            <form class="aol_app_form" name="aol_app_form" id="aol_app_form" enctype="multipart/form-data">
                <?php 
                    $field_types=array('text'=>'Text', 'checkbox'=>'Check Box', 'dropdown'=>'Drop Down', 'radio'=> 'Radio', 'file'=> 'File');
                    $keys=get_post_custom_keys(get_the_ID());
                    if($keys != NULL):
                        foreach($keys as $key):
                            if(substr($key, 0, 9)=='_aol_app_'):
                                $val=get_post_meta(get_the_ID(), $key, TRUE);
                                $val=  unserialize($val);
                                switch ($val['type']){
                                    case 'text': echo '<div class="form-group"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><input type="text" name="'.$key.'" class="form-control" id="'.$key.'" required></div>';
                                        break;

                                    case 'file': echo '<div class="form-group"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><input type="file" name="'.$key.'" id="'.$key.'" required></div>';
                                        break;

                                    case 'text_area':
                                        echo '<div class="form-group"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><textarea name="'.$key.'" class="form-control" id="'.$key.'" required></textarea></div>';
                                        break;

                                    case 'date': echo '<div class="form-group"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><input type="text" name="'.$key.'" class="form-control datepicker" id="'.$key.'" required></div>';
                                        break;

                                    case 'radio': echo '<div class="form-group"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><div id="'.$key.'" >';

                                        $options=explode(',', $val['options']);
                                        $i=0;
                                        foreach ($options as $option) {
                                            echo '<input type="radio" name="'.$key.'" class="" id="'.$key.'" value="'.$option.'"  '.$this->aol_ad_is_checked($i).'>'.$option.' &nbsp; &nbsp; ';
                                            $i++;
                                        }
                                        echo '</div></div>';
                                        break;

                                    case 'dropdown': echo '<div class="form-group"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><div id="'.$key.'" ><select name="'.$key.'" id="'.$key.'" class="form-control" required>';
                                        $options = explode(',', $val['options']);
                                        foreach ($options as $option) {
                                            echo '<option class="" value="'.$option.'" >'.$option.' </option>';
                                        }
                                        echo '</select></div></div>';
                                        break;

                                    case 'checkbox' : echo '<div class="form-group"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><div id="'.$key.'" >';
                                        $options=explode(',', $val['options']);
                                        $i=0;
                                        foreach ($options as $option) {
                                            echo '<input type="checkbox" name="'.$key.'[]" class="" id="'.$key.'" value="'.$option.'"  '.$this->aol_ad_is_checked($i).'>'.$option.' &nbsp; &nbsp; ';
                                            $i++;
                                        }
                                        echo '</div></div>';
                                        break;
                                }
                            endif;
                        endforeach;
                    endif;
                ?>
                <input type="hidden" name="ad_id" value="<?php the_ID(); ?>" >
                <input type="hidden" name="action" value="aol_app_form" >
                <input type="hidden" name="wp_nonce" value="<?php echo wp_create_nonce( 'the_best_aol_ad_security_nonce' ) ?>" >
                <input type="submit" value="Submit" id="aol_app_submit_button">
            </form><div id="aol_form_status"></div>
            <div id="submission_message" style="display: none"><?php echo get_option('aol_application_message','Your application has been submitted successfully. We will get back to you very soon.'); ?></div>
        <?php
            return ob_get_clean();
        }

        public function ad_features() {
            global $post;
            $metas = null;            
            $keys = get_post_custom_keys($post->ID);
            if( !empty($keys) ):
                foreach($keys as $key):
                    if(substr($key, 0, 13)=='_aol_feature_'){
                        if($metas == NULL) $metas='<table class="aol_ad_features">';
                        $val=get_post_meta($post->ID, $key, TRUE);
                        $metas.= '<tr><td>'.str_replace('_',' ',substr($key,13)).'</td><td>'.$val.' </td></tr>';
                    }
                endforeach;
            endif;
            $metas.='</table>';
          return $metas;
        }

        public function aol_content($content){
            global $template;
            $title_form = '<h3>Apply Online</h3>';
            $title_features = '<h4>Salient Features</h4>';
            $features = $this->ad_features();
            $form = $this->application_form();
            
            //Show this content if you are viewing aol_ad post type using single.php (not with single-aold_ad.php)
            if(is_singular('aol_ad') and 'single-aol_ad.php' != wp_basename($template)): 
                $content = $title_form.$content.$title_features.$features.$form;
            endif;
            return apply_filters( 'aol_content', $content, $features, $form );
        }
}
function aol_form(){
    $aol = new SinglePostTemplate('aol', 1.5);
    return $aol->application_form();
}

function aol_features(){
    $aol = new SinglePostTemplate('aol', 1.5);
    return $aol->ad_features();
}
