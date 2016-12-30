<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wpreloaded.com/farhan-noor
 * @since      1.0.0
 *
 * @package    Applyonline
 * @subpackage Applyonline/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Applyonline
 * @subpackage Applyonline/admin
 * @author     Farhan Noor <farhan.noor@yahoo.com>
 */
class Applyonline_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                
                // Hook - Applicant Listing - Column Name
                add_filter( 'manage_edit-aol_application_columns', array ( $this, 'applicants_list_columns' ) );

                // Hook - Applicant Listing - Column Value
                add_action( 'manage_aol_application_posts_custom_column', array ( $this, 'applicants_list_columns_value' ), 10, 2 ); 
                
                add_filter('post_row_actions',array($this, 'aol_post_row_actions'), 10, 2);
                
                //Filter Aplications based on parent.
                add_action( 'pre_get_posts', array($this, 'applications_filter') );
                
                // Add Application data to the Application editor. 
                add_action ( 'edit_form_after_title', array ( $this, 'aol_application_post_editor' ) );                
                                
                new Applyonline_MetaBoxes();
                
                new Applyonline_Settings($version);
                
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/applyonline-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/applyonline-admin.js', array( 'jquery' ), $this->version, false );

	}
        
        
        /**
         * Applicant Listing - Column Name
         *
         * @param   array   $columns
         * @access  public
         * @return  array
         */
        public function applicants_list_columns( $columns ){
            $columns = array (
                'cb'       => '<input type="checkbox" />',
                'title'    => __( 'Ad Title', 'applyonline' ),
                'applicant'=> __( 'Applicant', 'applyonline' ),
                'taxonomy' => __( 'Categories', 'applyonline' ),
                'date'     => __( 'Date', 'applyonline' ),
            );
            return $columns;
        }

        /**
         * Applicant Listing - Column Value
         *
         * @param   array   $columns
         * @param   int     $post_id
         * @access  public
         * @return  void
         */
        // 
        public function applicants_list_columns_value( $column, $post_id ){
            $keys = get_post_custom_keys( $post_id );
            switch ( $column ) {
                case 'applicant' :
                    $applicant_name = sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( array ( 'post' => $post_id, 'action' => 'edit' ), 'post.php' ) ), esc_html( get_post_meta( $post_id, $keys[ 0 ], TRUE ) )
                    );
                    echo $applicant_name;
                    break;
                case 'taxonomy' :
                    $parent_id = wp_get_post_parent_id( $post_id ); // get_post_field ( 'post_parent', $post_id );
                    $terms = get_the_terms( $parent_id, 'aol_ad_category' );
                    if ( ! empty( $terms ) ) {
                        $out = array ();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( array ( 'post_type' => get_post_type( $parent_id ), 'aol_ad_category' => $term->slug ), 'edit.php' ) ), esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'jobpost_category', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    }/* If no terms were found, output a default message. */ else {
                        _e( 'No Categories' , 'applyonline');
                    }
                    break;
            }
        }                
    
        public function aol_post_row_actions($actions, $post){
            if($post->post_type == 'aol_application'){
                return null;
            }
            elseif($post->post_type == 'aol_ad'){
                $actions['test'] = '<a rel="permalink" title="View All Applications" href="'.  admin_url('edit.php?post_type=aol_application').'&ad='.$post->ID.'">Applications</a>';
                return $actions;
            }
        }
        
        public function applications_filter( $query ) {
            if ( $query->is_main_query() AND is_admin() AND isset($_GET['ad'])) {
                $query->set( 'post_parent', $_GET['ad'] );
            }
        }
        
        /**
         * Creates Detail Page for Applicants
         * 
         * 
         * @access  public
         * @since   1.0.0
         * @return  void
         */
        public function aol_application_post_editor (){
            global $post;
            if ( !empty ( $post ) and $post->post_type =='aol_application' ):
                $keys = get_post_custom_keys ( $post->ID );
                ?>
                <div class="wrap"><div id="icon-tools" class="icon32"></div>
                    <h3>
                        <?php
                        if ( in_array ( '_aol_app_Name', $keys ) or in_array ( '_aol_app_Full_Name', $keys ) ):
                            echo get_post_meta ( $post->ID, '_aol_app_Name', true );
                        endif;
                        
                        // _aol_attachment feature has obsolete since version 1.4, It is now treated as Post Meta.
                        if ( in_array ( '_aol_attachment', $keys ) ):
                            $files = get_post_meta ( $post->ID, '_aol_attachment', true );
                            ?>
                                &nbsp; &nbsp; <small><a href="<?php echo get_post_meta ( $post->ID, '_aol_attachment', true ); ?>" target="_blank" ><?php echo __( 'Attachment' , 'applyonline' );?></a></small>
                        <?php endif; ?>

                    </h3>
                    <table class="widefat striped">
                        <?php
                        foreach ( $keys as $key ):
                            $val = get_post_meta ( $post->ID, $key, true );
                            if (!filter_var($val, FILTER_VALIDATE_URL) === false) $val = '<a href="'.$val.'" target="_blank">Attachment</a>';
                        
                            if(is_array($val)) $val = implode(', ', $val);
                            
                            if ( substr ( $key, 0, 9 ) == '_aol_app_' ) {
                                echo '<tr><td>' . str_replace ( '_', ' ', substr ( $key, 9 ) ) . '</td><td>' . $val . '</td></tr>';
                            }
                        endforeach;
                        ?>
                    </table>
                </div>
                <h2><?php echo __( 'Notes' , 'applyonline' );?></h2>
                <?php
            endif;
        }        
    }

  /**
  * This class adds Meta Boxes to the Edit Screen of the Ads.
  * 
  * 
  * @since      1.0
  * @package    MetaBoxes
  * @subpackage MetaBoxes/includes
  * @author     Farhan Noor
  **/
 class Applyonline_MetaBoxes{
     
        /**
	 * Application Form Field Types.
	 *
	 * @since    1.3
	 * @access   public
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
        var $app_field_types;
             
        public function __construct() {
            $this->app_field_types = array('text'=>'Text Field', 'text_area'=>'Text Area', 'date'=>'Date', 'checkbox'=>'Check Box', 'dropdown'=>'Drop Down', 'radio'=> 'Radio', 'file'=>'File');
            add_action( 'add_meta_boxes_aol_ad', array($this, 'aol_meta_boxes') );
            add_action( 'save_post', array( $this, 'save_metas' ) );
        }
 
        /**
	 * Metaboxes for Ads Editor
	 *
	 * @since     1.0
	 */
        function aol_meta_boxes($post) {

            add_meta_box(
                    'aol_ad_metas',
                    __( 'Ad Features', 'applyonline' ),
                    array($this, 'ad_features'),
                    'aol_ad'
            );

            add_meta_box(
                    'aol_ad_app_fields',
                    __( 'Application Form Fields', 'applyonline' ),
                    array($this, 'application_form_fields'),
                    'aol_ad'
            );
        }
        
        function ad_features( $post ) {

            // Add a nonce field so we can check for it later.
                wp_nonce_field( 'myplugin_adpost_meta_awesome_box', 'adpost_meta_box_nonce' );

                /*
                 * Use get_post_meta() to retrieve an existing value
                 * from the database and use the value for the form.
                 */
            ?>
            <div class="ad_features adpost_fields">
                <ol id="ad_features">
                    <?php
                        $keys = get_post_custom_keys( $post->ID);
                        if($keys != NULL):
                            foreach($keys as $key):
                                if(substr($key, 0, 13)=='_aol_feature_'){
                                    $val=get_post_meta($post->ID, $key, TRUE);
                                    echo '<li><label for="'.$key.'">';
                                    _e( str_replace('_',' ',substr($key,13)), 'applyonline' );
                                    echo '</label> ';
                                    echo '<input type="text" id="'.$key.'" name="'.$key.'" value="' . esc_attr( $val ) . '" /> &nbsp; <div class="button removeField">Delete</div></li>';
                                }
                            endforeach;
                        endif;
                    ?>
                </ol>
            </div>
            <div class="clearfix clear"></div>
            <table id="adfeatures_form" class="alignleft">
            <thead>
                <tr>
                    <th class="left"><label for="adfeature_name">Feature</label></th>
                    <th><label for="adfeature_value">Value</label></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="left" id="adFeature">
                        <input type="text" id="adfeature_name" />
                    </td><td>
                        <input type="text" id="adfeature_value" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class=""><div class="button" id="addFeature">Add Feature</div></div>
                    </td>
                </tr>
            </tbody>
            </table>
            <div class="clearfix clear"></div>
            <?php 
        }
        
        public function application_fields_generator($app_fields){

            ?>
            <div class="clearfix clear"></div>
            <table id="adapp_form_fields" class="alignleft">
            <thead>
                <tr>
                    <th class="left"><label for="metakeyselect">Field</label></th>
                    <th><label for="metavalue">Type</label></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="left" id="newmetaleft">
                        <input type="text" id="adapp_name" />
                    </td><td>
                        <select id="adapp_field_type">
                            <?php
                                foreach($app_fields as $key => $val):
                                    echo '<option value="'.$key.'" class="'.$key.'">'.$val.'</option>';
                                endforeach;
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" ><input id="adapp_field_options" class="adapp_field_type" type="text" style="display: none;" placeholder="Option1, Option2, Option3" ></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class=""><div class="button" id="addField">Add Field</div></div>
                    </td>
                </tr>
            </tbody>
            </table>
            <div class="clearfix clear"></div>
            <script>
                jQuery('document').ready(function($){
                    /*Application Field Type change for new Field only*/
                    $('#adapp_field_type').change(function(){
                       var fieldType=$(this).val();

                       if(!(fieldType == 'text' || fieldType == 'date' || fieldType == 'text_area' || fieldType == 'file')){
                           $('#adapp_field_options').show();
                       }
                       else{
                           $('#adapp_field_options').hide();
                           $('#adapp_field_options').val('');
                       }
                    });

                    /*Add Application Field (Group Fields)*/
                    $('#addField').click(function(){
                        var fieldNameRaw=$('#adapp_name').val(); // Get Raw value.
                        var fieldNameRaw = fieldNameRaw.trim();    // Remove White Spaces from both ends.
                        var fieldName = fieldNameRaw.replace(" ", "_"); //Replace white space with _.
                        var fieldType = $('#adapp_field_type').val();
                        var fieldOptions = $('#adapp_field_options').val();
                        var style;


                        var fieldTypeHtml = $('#adapp_field_type').html();
                        if(fieldName != ''){
                            $('#adapp_name').css('border','none');
                            if(fieldType=='text' || fieldType=='date' || fieldType == 'text_area'|| fieldType == 'file'){
                                style = "display:none";
                            }
                            else {
                                style = "";
                                $('#adapp_field_options').val('');
                                $('#adapp_field_options').hide();
                            }
                            $('#app_form_fields').append('<li class="'+fieldName+'"> <label for="'+fieldName+'">'+fieldNameRaw+'</label><select class="adapp_field_type" name="_aol_app_'+fieldName+'[type]">'+fieldTypeHtml+'</select><input type="text" class="'+fieldName+' adapp_field_options" name="_aol_app_'+fieldName+'[options]" value="'+fieldOptions+'" placeholder="Option1, Option2, Option3" style="'+style+'" /> &nbsp; <div class="button removeField">Delete</div></li>');
                            $('.'+fieldName+' .'+fieldType).attr('selected','selected');
                            $('#adapp_name').val('');
                            $('#adapp_field_type').val('text');
                        }
                        else{
                            $('#adapp_name').css('border','1px solid #F00');

                        }

                    });

                    /* Application Field Type change for existing fields. */
                    $('#app_form_fields').on('change', 'li .adapp_field_type',function(){

                        var fieldType=$(this).val();

                        if(!(fieldType == 'text' || fieldType == 'date' || fieldType == 'text_area' || fieldType == 'file')){
                           $(this).next().show();
                        }
                        else{
                           $(this).next().hide();
                        }
                    }); 


                    /*Add Job Feature*/
                    $('#addFeature').click(function(){
                        var fieldNameRaw=$('#adfeature_name').val(); // Get Raw value.
                        var fieldNameRaw = fieldNameRaw.trim();    // Remove White Spaces from both ends.
                        var fieldName = fieldNameRaw.replace(" ", "_"); //Replace white space with _.

                        var fieldVal = $('#adfeature_value').val();
                        var fieldVal = fieldVal.trim();

                        if(fieldName != '' && fieldVal!=''){
                            $('#ad_features').append('<li class="'+fieldName+'"><label for="'+fieldName+'">'+fieldNameRaw+'</label> <input type="text" name="_aol_feature_'+fieldName+'" value="'+fieldVal+'" > &nbsp; <div class="button removeField">Delete</div></li>');
                            $('#adfeature_name').val(""); //Reset Field value.
                            $('#adfeature_value').val(""); //Reset Field value.
                        }
                    });
                    /*Remove Job app or ad Feature Fields*/
                    $('.adpost_fields').on('click', 'li .removeField',function(){
                        $(this).parent('li').remove();
                    });         

                });
            </script>         
        <?php
        }
        
        public function application_form_fields( $post ) {
            //global $adfields;
            // Add a nonce field so we can check for it later.
            wp_nonce_field( 'myplugin_adpost_meta_awesome_box', 'adpost_meta_box_nonce' );

            /*
             * Use get_post_meta() to retrieve an existing value
             * from the database and use the value for the form.
             */
            ?>
            <div class="app_form_fields adpost_fields">
                <ol id="app_form_fields">
                    <?php
                    if(isset($post)):
                        $keys=get_post_custom_keys($post->ID);
                        if($keys == NULL){ 
                            $default_fields = get_option('aol_default_fields') or $default_fields = array();
                            $keys = array_keys($default_fields);
                        }
                            foreach($keys as $key):
                                if(substr($key, 0, 9)=='_aol_app_'):

                                    $val=get_post_meta($post->ID, $key, TRUE) or $val=$default_fields[$key] ;
                                    !is_array($val)? $val=  unserialize($val): $val;
                                    $fields = NULL;
                                    foreach($this->app_field_types as $field_key => $field_val){
                                        if($val['type']==$field_key) $fields .= '<option value="'.$field_key.'" selected>'.$field_val.'</option>';
                                        else $fields .= '<option value="'.$field_key.'" >'.$field_val.'</option>';
                                    }                   
                                    //if($key.'[type]'=='text'){
                                        echo '<li class="'.$key.'"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><select class="adapp_field_type" name="'.$key.'[type]">'.$fields.'</select>';
                                        if(!($val['type']=='text' or $val['type']=='date' or $val['type']=='text_area' or $val['type']=='file' )):
                                            echo '<input type="text" name="'.$key.'[options]" value="'.$val['options'].'" placeholder="Option1, option2, option3" />';
                                        else:
                                            echo '<input type="text" name="'.$key.'[options]" placeholder="Option1, option2, option3" style="display:none;"  />';
                                        endif;
                                        echo ' &nbsp; <div class="button removeField">Delete</div></li>';
                                    //}
                                endif;
                            endforeach;
                        endif;
                    ?>
                </ol>
            </div>  
            

            <?php
            $this->application_fields_generator($this->app_field_types);
        }     
        
        /**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
        function save_metas( $post_id ) {

            /*
             * We need to verify this came from our screen and with proper authorization,
             * because the save_post action can be triggered at other times.
             */

            // Check if our nonce is set.
            if ( ! isset( $_POST['adpost_meta_box_nonce'] ) ) {
                    return;
            }

            // Verify that the nonce is valid.
            if ( ! wp_verify_nonce( $_POST['adpost_meta_box_nonce'], 'myplugin_adpost_meta_awesome_box' ) ) {
                    return;
            }

            // If this is an autosave, our form has not been submitted, so we don't want to do anything.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                    return;
            }

            // Check the user's permissions.
            if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

                    if ( ! current_user_can( 'edit_page', $post_id ) ) {
                            return;
                    }

            } else {

                    if ( ! current_user_can( 'edit_post', $post_id ) ) {
                            return;
                    }
            }

            /* OK, it's safe for us to save the data now. */

            //Delete fields.
            $old_keys = get_post_custom_keys($post_id);
            $new_keys = array_keys($_POST);
            $removed_keys = array_diff($old_keys, $new_keys); //List of removed meta keys.
            foreach($removed_keys as $key => $val):
                if(substr($val, 0, 4) == '_aol') delete_post_meta($post_id, $val); //Remove meta from the db.
            endforeach;

            // Add new value.
            foreach ($_POST as $key => $val):
                // Make sure that it is set.
                if ( substr($key, 0, 13)=='_aol_feature_' and isset( $val ) ) {
                    //Sanitize user input.
                    $my_data = sanitize_text_field( $val );
                    update_post_meta( $post_id, $key,  $my_data); // Add new value.
                }

                // Make sure that it is set.
                elseif ( substr($key, 0, 9)=='_aol_app_' and isset( $val ) ) {
                    $my_data = serialize($_POST[$key]);
                    update_post_meta( $post_id, $key,  $my_data); // Add new value.
                }
                    //Update the meta field in the database.
            endforeach;
        }  

}

  /**
  * This class is responsible for plugin Settings.
  * 
  * 
  * @since      1.3
  * @package    Applyonline_settings
  * @author     Farhan Noor
  **/
class Applyonline_Settings extends Applyonline_MetaBoxes{
    
    private $version;

    public function __construct($version) {
        
        parent::__construct(); //Acitvating Parent's constructor
        
        $this->version = $version;
        
        //Registering Submenus.
        add_action('admin_menu', array($this, 'sub_menus'));
        
        //Registering Settings.
        add_action( 'admin_init', array($this, 'registers_settings') );
    }


    public function sub_menus(){
        add_submenu_page( 'edit.php?post_type=aol_ad', 'AOL Settings', 'Settings', 'manage_options', 'settings', array($this, 'settings_page_callback') );
    }

    public function registers_settings(){
        register_setting( 'aol_settings_group', 'aol_recipients_emails' );
        register_setting( 'aol_settings_group', 'aol_application_message' );
        register_setting( 'aol_settings_group', 'aol_thankyou_page' );
        register_setting( 'aol_settings_group', 'aol_slug', 'sanitize_title' ); 
        
        //On update of aol_slug field, update permalink too.
        add_action('update_option_aol_slug', array($this, 'refresh_permalink'));
    }
    
    public function refresh_permalink(){
        //Re register post type for proper Flush Rules.
        $slug = get_option('aol_slug', 'ads');
        if(empty($slug)) $slug = 'ads';
        /*Register Main Post Type*/
        register_post_type('aol_ad', array('has_archive' => true, 'rewrite' => array('slug'=>  $slug)));
        
        flush_rewrite_rules();
    }

    public function settings_page_callback(){
        if ( !empty( $_POST['aol_default_app_fields'] ) && check_admin_referer( 'aol_awesome_pretty_nonce','aol_default_app_fields' ) ) {
            //Remove unnecessary fields
            foreach($_POST as $key => $val){
                if(substr($key, 0, 4) != '_aol') unset($_POST[$key]);
            }
            
            //Save aol default fields in DB.
            update_option('aol_default_fields', $_POST);
        }
        ob_start();
        ?>
            <div class="wrap">
                <h2>Apply Online <small class="wp-caption alignright"><i>version <?php echo $this->version; ?></i></small></h2>
                <h2 class="nav-tab-wrapper">
                        <a class="nav-tab nav-tab-active" data-id="alerts">General</a>
                        <a class="nav-tab" data-id="templates">Defaults</a>
                        <a class="nav-tab" data-id="how-to">How to</a>
                </h2>              
                <form action="options.php" method="post" name="">
                    <div class="tab-data first" id="alerts">
                        <?php 
                            settings_fields( 'aol_settings_group' ); 
                            do_settings_sections( 'aol_settings_group' );
                        ?>
                        <table class="form-table">
                            <tr>
                                <th><label for="alert-emails">List of e-mails to get application alerts</label></th>
                                <td><textarea id="alert-emails" class="small-text code" name="aol_recipients_emails" cols="50" rows="5"><?php echo esc_attr( get_option('aol_recipients_emails') ); ?></textarea><p class="description">Just one email id in one line.</p></td>
                            </tr>
                            <tr>
                                <th><label for="alert-message">Application submission message</label></th>
                                <td>
                                    <textarea id="alert-message" class="small-text code" name="aol_application_message" cols="50" rows="5" id="aol_submission_default_message"><?php echo esc_attr( get_option('aol_application_message','Your application has been submitted successfully. We will get back to you very soon.') ); ?></textarea>
                                    <br />
                                    <button id="aol_submission_default" class="button">Default Message</button>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="thank-page">Thank you page:</label></th>
                                <td>
                                    <select id="thank-page" name="aol_thankyou_page">
                                        <option value=""><?php echo esc_attr( __( 'Select page' ) ); ?></option> 
                                        <?php 
                                        $selected = get_option('aol_thankyou_page');
                                        
                                         $pages = get_pages();
                                         foreach ( $pages as $page ) {
                                             $attr = null;
                                             if($selected == $page->ID) $attr = 'selected';

                                               $option = '<option value="' . $page->ID . '" '.$attr.'>';
                                               $option .= $page->post_title;
                                               $option .= '</option>';
                                               echo $option;
                                         }
                                        ?>
                                   </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="aol_slug">Ads slug</label></th>
                                <td>
                                    <input id="aol_slug" type="text" name="aol_slug" placeholder="ads" value="<?php echo esc_attr( get_option('aol_slug') ); ?>" />
                                    <p class="description">Default permalink is <?php bloginfo('url'); ?>/<b>ads</b>/</p>
                                </td>
                            </tr>
                        </table>
                        <?php submit_button(); ?>
                    </div>
                </form>
                <form id="template_form" method="post">
                    <div id="templates" class="tab-data">
                        <h3>Application form default fields</h3><hr />
                        <div class="app_form_fields adpost_fields">
                            <ol id="app_form_fields">
                                <?php 
                                    $app_fields = $this->app_field_types;
                                    settings_fields( 'aol_application_template' );
                                    do_settings_sections( 'aol_application_template' );
                            
                                    $keys= get_option('aol_default_fields');
                                    if($keys != NULL):
                                        foreach($keys as $key => $val):
                                            if(substr($key, 0, 9)=='_aol_app_'):

                                                $fields = NULL;
                                                foreach($app_fields as $field_key => $field_val){
                                                    if($val['type']==$field_key) $fields .= '<option value="'.$field_key.'" selected>'.$field_val.'</option>';
                                                    else $fields .= '<option value="'.$field_key.'" >'.$field_val.'</option>';
                                                }
                                                //if($key.'[type]'=='text'){
                                                    echo '<li class="'.$key.'"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><select class="adapp_field_type" name="'.$key.'[type]">'.$fields.'</select>';
                                                    if(!($val['type']=='text' or $val['type']=='date' or $val['type']=='text_area' or $val['type']=='file')):
                                                        echo '<input type="text" name="'.$key.'[options]" value="'.$val['options'].'" placeholder="Option1, option2, option3" />';
                                                    else:
                                                        echo '<input type="text" name="'.$key.'[options]" placeholder="Option1, option2, option3" style="display:none;"  />';
                                                    endif;
                                                    echo ' &nbsp; <div class="button removeField">Delete</div></li>';
                                                //}
                                            endif;
                                        endforeach;
                                    endif;
                                ?>
                            </ol>
                        </div>  
                        <?php $this->application_fields_generator($this->app_field_types); ?>
                        <hr />
                        <?php submit_button(); ?>
                    </div>
                    <?php wp_nonce_field( 'aol_awesome_pretty_nonce','aol_default_app_fields' ); ?>
                </form>
                <div class="tab-data wrap" id="how-to">
                    <div class="card" style="max-width:100%">
                        <h3>How to create an ad?</h3>
                        In your WordPress admin panel, go to "Apply Online" menu and add a new ad listing.

                        <h3>How to show ad listings on the front-end?</h3>
                        1. The url <b><a href="<?php echo get_bloginfo('url').'/'.  get_option('aol_slug', 'ads'); ?>" target="_blank" ><?php echo get_bloginfo('url').'/'.  get_option('aol_slug', 'ads'); ?></a></b> lists all the applications using your theme's default look and feel.<br />
                        &nbsp; &nbsp;&nbsp;(If above not working, try saving <a href="<?php echo get_admin_url().'/options-permalink.php'; ?>"  >permalinks</a> without any change)<br />
                        2. Write [aol] shortcode in an existing page or add a new page and write shortcode anywhere in the page editor. Now click on VIEW to see all of your ads on front-end.

                        <h3>Can I show few adds on front-end?</h3>
                        Yes, you can show any number of ads on your website by using shortcode with "ads" attribute. Ad ids must be separated with commas i.e. [aol ads="1,2,3"].

                        <h3>Can I show ads from particular category only?</h3>
                        Yes, you can show ads from any category / categories using "categories" attribute. Categories' ids must be separated with commas i.e. [aol categories="1,2,3"].

                        <h3>Can I show ads without excerpt/summary?</h3>
                        Yes, use shortcode with "excerpt" attribute i.e. [aol excerpt="no"]

                        <h3>What attributes can i use in the shortcode?</h3>
                        Default shortcode with all attributes is [aol categories="1,2,3" ads="1,2,3" excerpt="no"]. Use only required attributes.

                        <h3>How can i get the id of a category or ad?</h3>
                        In admin panel, move your mouse pointer on an item in categories or ads table. Now you can view item ID in the info bar of the browser.
                    </div>
                    
                    <div class="card" style="max-width:100%">
                        <h2>Developers Section</h2>
                        <h4>apply_filters( 'aol_content', $content, $features, $form )</h4> 
                        <p>Above hook can be used to modify the output of [aol] shortcode. This hook returns $content. You can use this filter hook in your theme's functions.php file in this way:</p>
                        <p>
                            <strong>add_filter('aol_content', 'my_custom_function', 10, 3); </strong> <br />
                            function my_custom_function( $content, $features, $form ){<br />
                                &nbsp; &nbsp; &nbsp;//Modiy $content here <br />
                                &nbsp; &nbsp; &nbsp;return $content; <br />
                            }
                        </p>
                        <hr />
                        <h4>Custom theme template</h4> 
                        <p>To get complete control over the output, you can create archive file archive-aol_ad.php and template file single-aol_ad.php in your theme with your own html structure. Two functions are available to get content of an application:</p>
                        <ul>
                            <ol><b>aol_features</b> This functions outputs features of an application.</ol>
                            <ol><b>aol_form</b> This functions outputs application form.</ol>
                        </ul>
                    </div>
                </div>
            </div>
            <script>
                jQuery(document).ready(function($){
                    $('.tab-data:first').show();
                    $('.nav-tab').click(function(){
                        $('.nav-tab').removeClass('nav-tab-active');
                        $(this).addClass('nav-tab-active');

                        var target = $(this).data("id");

                        $('.tab-data').hide();
                        $("#"+target).show();
                    });
                });
            </script>
            <style>
                h3{margin-bottom: 5px;}
                .nav-tab{cursor: pointer}
                .tab-data{display: none;}
            </style>
        <?php
        return ob_get_flush();
    }           
 }

  