<?php

	/**
	 * Echo theme specific tags for styling widget
	 */
	echo $before_widget;

	echo $before_title . $title . $after_title;

	/**
	 * Custom query arguments
	 * @var array
	 */
	$args = array(
		'post_type' => 'notice',
		'post_status' => 'publish',
		'posts_per_page' => $count
		);
	$query = null;
	/**
	 * Run a WP Query to get all notices
	 * @var WP_Query
	 */
	$query = new WP_Query($args);

	/**
	 * Check if notices exist and display output accordingly
	 */
	if( $query->have_posts() ){
		global $post;
		if( 'scroll' == $type ) {
			if( $direction == 'down' )
				echo '<div class="msnb_notice scroll-down">';
			else
				echo '<div class="msnb_notice scroll-up">';
		}
		else {
			echo '<div class="msnb_notice">';
		}
		/**
		 * Output the required notices in a list
		 */
		echo '<ul class="notice-list">';
		while ( $query->have_posts() ) {
			$query->the_post();
			if ( get_post_meta( $post->ID, 'msnb_notice_url', true ) == '' ) {
				echo '<li> <a href="' . 
					get_permalink() . '" target="_blank">' . get_the_title() . '</a></li>';
			}
			else {
				echo '<li><a href="' . get_post_meta( $post->ID, 'msnb_notice_url', true ) 
					. '" target="_blank">' . get_the_title() . '</a></li>';
			}
		}
		echo "</ul></div>";

		wp_enqueue_style( 'msnb_notice_style', MSNB_DIR_URL . 'css/msnb_style.css' );
	}
	else {
		echo "No notices yet.";
	}

	/**
	 * Reset WP Query post data
	 */
	wp_reset_postdata();

	echo $after_widget;