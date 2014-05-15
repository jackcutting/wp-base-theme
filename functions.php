<?php

	register_nav_menus( array(
		'main' => __( 'Main Navigation', 'text_domain' )
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
	
	function content( $limit ) {
		$content = explode( ' ', get_the_content(), $limit );
		if ( count( $content ) >= $limit ) {
			array_pop( $content );
			$content = implode( " ", $content ) . '...';
		} else {
			$content = implode( " ", $content );
		} 
		$content = preg_replace( '/\[.+\]/', '', $content );
		$content = apply_filters( 'the_content', $content ); 
		return $content;
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
		wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/assets/js/jquery.bxslider.min.js', array( 'jquery' ), '4.1.1', true );
	}
	add_action( 'wp_enqueue_scripts', 'queue_scripts' );

?>