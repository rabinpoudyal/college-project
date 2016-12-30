<?php

/**
 * Fired during plugin activation
 *
 * @link       http://wpreloaded.com/farhan-noor
 * @since      1.0.0
 *
 * @package    Applyonline
 * @subpackage Applyonline/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Applyonline
 * @subpackage Applyonline/includes
 * @author     Farhan Noor <farhan.noor@yahoo.com>
 */
class Applyonline_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
            
            //Register CPT here for proper Flush Rules.
            $slug = get_option('aol_slug', 'ads');
            if(empty($slug)) $slug = 'ads';
            register_post_type('aol_ad', array('has_archive' => true, 'rewrite' => array('slug'=>  $slug)));
            flush_rewrite_rules();
            
            $term = wp_insert_term( 
                    'Admission',
                    'aol_ad_category',
                    array(
                        'slug'=>'admission',
                        'description'=>'Ads for admission in the school'
                        )
                    );
            if(!is_wp_error($term)):
                wp_insert_term( 
                        'Business School',
                        'aol_ad_category',
                        array(
                            'slug'=>'business',
                            'description'=>'Online admissions of Business school',
                            'parent' => $term['term_id'],
                            )
                        );

                wp_insert_term( 
                        'Computer Scinces',
                        'aol_ad_category',
                        array(
                            'slug'=>'computer-science',
                            'description'=>'Online admissions of Computer Sciences department',
                            'parent' => $term['term_id'],
                            )
                        );
            endif;
            
            $term = wp_insert_term( 
                    'Career',
                    'aol_ad_category',
                    array(
                        'slug'=>'career',
                        'description'=>'Use this category as a job board'
                        )
                    );
            
            if(!is_wp_error($term)):
                wp_insert_term( 
                        'Finance Department',
                        'aol_ad_category',
                        array(
                            'slug'=>'finance-department',
                            'description'=>'All job ads of Finance department',
                            'parent' => $term['term_id'],
                            )
                        );
                wp_insert_term( 
                        'Marketing Department',
                        'aol_ad_category',
                        array(
                            'slug'=>'marketing-department',
                            'description'=>'All job ads of Marketing department',
                            'parent' => $term['term_id'],
                            )
                        );
            endif;
            
            //Insert default fields.
            $fields = array (
                '_aol_app_Name' => 
                array (
                  'type' => 'text',
                  'options' => '',
                ),
                '_aol_app_eMail' => 
                array (
                  'type' => 'text',
                  'options' => '',
                ),
            );
            update_option('aol_default_fields', $fields);
             
        }

}
