<?php

	register_nav_menus( array(
		'main' => __( 'Main Navigation', 'text_domain' ),
	) );	
		
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'banner', 960, 495, true );
	
	function give_linked_images_class( $html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
	
		$classes = 'lightbox';
	
		if ( preg_match( '/<a.*? class=".*?">/', $html ) ) {
			$html = preg_replace( '/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html );
		} else {
			$html = preg_replace( '/(<a.*?)>/', '$1 class="' . $classes . '" >', $html );
		}
		return $html;
	
	}
	// add_filter( 'image_send_to_editor', 'give_linked_images_class', 10, 8 );
	
	function excerpt( $limit ) {
		$excerpt = explode( ' ', get_the_excerpt(), $limit );
		if ( count( $excerpt ) >= $limit ) {
			array_pop( $excerpt );
			$excerpt = implode( " ", $excerpt ) . '...';
		} else {
			$excerpt = implode( " ", $excerpt );
		} 
		$excerpt = preg_replace( '`\[[^\]]*\]`' , '', $excerpt );
		return $excerpt;
	}

	function remove_menus(){
	
		// remove_menu_page( 'index.php' );                  //Dashboard
		remove_menu_page( 'edit.php' );                   //Posts
		// remove_menu_page( 'upload.php' );                 //Media
		// remove_menu_page( 'edit.php?post_type=page' );    //Pages
		remove_menu_page( 'edit-comments.php' );          //Comments
		// remove_menu_page( 'themes.php' );                 //Appearance
		// remove_menu_page( 'plugins.php' );                //Plugins
		// remove_menu_page( 'users.php' );                  //Users
		remove_menu_page( 'tools.php' );                  //Tools
		// remove_menu_page( 'options-general.php' );        //Settings
	
	}
	add_action( 'admin_menu', 'remove_menus' );

	function remove_theme_editor(){

		$editor = remove_submenu_page( 'themes.php', 'theme-editor.php' );

	}
	add_action( 'admin_init', 'remove_theme_editor' );

	function queue_scripts() {
		wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600' );
		wp_enqueue_style( 'theme-css', get_stylesheet_uri() );
		wp_enqueue_style( 'bxslider', get_template_directory_uri() . '/assets/js/jquery.bxslider.css' );
		wp_enqueue_script( 'html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js', array(), '3.7', false );
		wp_enqueue_script( 'theme-js', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ), '1', true );
		wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/assets/js/jquery.bxslider.min.js', array( 'jquery' ), '4.1.1', true );
	}
	add_action( 'wp_enqueue_scripts', 'queue_scripts' );

	function lead_shortcode( $atts, $content ) {
		$atts = extract( shortcode_atts( array( 'default'=>'values' ),$atts ) );
		return '<p class="lead">' . $content . '</p>';
	}
	add_shortcode( 'lead','lead_shortcode' );

	function divider_shortcode() {
		return '<div class="divider"></div>';
	}
	add_shortcode( 'divider','divider_shortcode' );
	add_shortcode( 'divide','divider_shortcode' );

	function paginate( $query = null ){

		// If custom query is passed through, set $query equal to the global $wp_query
		if( is_null( $query ) ){
			global $wp_query;
			$query = $wp_query;
		}

		// Get total number of pages
		$total = $query->max_num_pages;

		// Only do something if there is more than one page
		if ( $total > 1 ) {

			// Get current page
			if ( ! $current = get_query_var( 'paged' ) )
				$current = 1;

			// Set the format - wether permalinks are set or not
			// $format = (empty( get_option( 'permalink_structure' ) ) ? '&page=%#%' : 'page/%#%/');
			// $format = empty( get_option( 'permalink_structure' ) ) ? '&page=%#%' : '/page/%#%/';

			$args = array(
				'base'					=> get_pagenum_link( 1 ) . '%_%',
				'format'				=> '&paged=%#%',
				'total'					=> $total,
				'current'				=> $current,
				'show_all'				=> false,
				'end_size'				=> 1,
				'mid_size'				=> 2,
				'prev_next'				=> false,
				// 'prev_text'				=> __('<i class="fa fa-angle-left"></i> Previous'),
				// 'next_text'				=> __('Next <i class="fa fa-angle-right"></i>'),
				'prev_text'				=> __('&lt; Previous'),
				'next_text'				=> __('Next &gt;'),
				'type'					=> 'array',
				'add_args'				=> false,
				'add_fragment'			=> '',
				'before_page_number'	=> '',
				'after_page_number'		=> ''
			);

			$pages = paginate_links( $args );

			$html = '<div class="pagination"><ul class="pagination-links">';
			foreach ($pages as $page) {
				$html .= ( strpos( $page, 'current' ) ? '<li class="active">' . $page . '</li>' : '<li>' . $page . '</li>' );
			}
			$html .= '</ul></div>';

			return $html;

		} else {
			return '';
		}

	}

?>