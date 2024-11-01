<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Tags Limit WP and WooCommerce
Description: Limit the nummber of Tags in Default Widget and WooCommerce Tags Widget. You can easily add the number of tags cloud to display on the default widget of WordPress and WooCommerce. You can easily manage those tags from Customizer settings. Go to Appearance > Customize > Tag Options to check the available options.
Version:     1.0.0
Author:      WPEntire
Author URI:  https://www.wpentire.com
License:     GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: tags-limit-wp-and-woocommerce
*/

//Customizer to Change the number of Tags in WordPress and WooCommerce. 
function tlwpwc_customizer_register( $wp_customize ){

$wp_customize->add_panel( 'tlwpwc_tags_wp_wc', array(
					'priority' => 10,
					'capability' => 'edit_theme_options',
					'theme_supports' => '',
					'title' => __( 'Tag Options', 'tags-limit-wp-and-woocommerce' ),
					'description' => '', 
					) );
				
				//WordPress Default Tag Widget limit section
				$wp_customize->add_section( 'tlwpwc_wp_tags_section', array(
					'priority' => 10,
					'capability' => 'edit_theme_options',
					'theme_supports' => '',
					'title' => __( 'WP Default Tag', 'tags-limit-wp-and-woocommerce' ),
					'description' => '', 
					'panel' => 'tlwpwc_tags_wp_wc'
					) );
		
				$wp_customize->add_setting(
				       'tlwpwc_wp_tags_limit',
				       array(
				           'default'     => 10,
				           'sanitize_callback' => 'absint',
				       )
				   );
				
				$wp_customize->add_control(
				           'tlwpwc_wp_tags_limit',
				           array(
				               'label'      => __( 'Number of Tags in Default WP Tag Cloud Widget', 'tags-limit-wp-and-woocommerce' ),
				               'section'    => 'tlwpwc_wp_tags_section',
				               'settings'   => 'tlwpwc_wp_tags_limit',
				               'type'      => 'number',
				       )
				);

				//WooCommerce Tags Limit Section
				if ( class_exists( 'WooCommerce' ) ):
				$wp_customize->add_section( 'tlwpwc_wc_tags_section', array(
					'priority' => 10,
					'capability' => 'edit_theme_options',
					'theme_supports' => '',
					'title' => __( 'WooCommerce Default Tag', 'tags-limit-wp-and-woocommerce' ),
					'description' => '', 
					'panel' => 'tlwpwc_tags_wp_wc'
					) );
				
				$wp_customize->add_setting(
				       'tlwpwc_wc_tags_limit',
				       array(
				           'default'     => 10,
				           'sanitize_callback' => 'absint',
				       )
				   );
				
				$wp_customize->add_control(
				           'tlwpwc_wc_tags_limit',
				           array(
				               'label'      => __( 'Number of Tags in WooCommerce Tag Cloud Widget', 'tags-limit-wp-and-woocommerce' ),
				               'section'    => 'tlwpwc_wc_tags_section',
				               'settings'   => 'tlwpwc_wc_tags_limit',
				               'type'      => 'number',
				       )
				);
			endif;

}
add_action( 'customize_register', 'tlwpwc_customizer_register' );

/*
* Limit Number Of Tags in WordPress Default Tags Widget 
*/
	
if( ! function_exists( 'tlwpwc_tag_widget_limit' ) ) :
function tlwpwc_tag_widget_limit($args){
	if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
		$tlwpwc_wp_tags_number = absint(get_theme_mod('tlwpwc_wp_tags_limit'));
	$args['number'] = $tlwpwc_wp_tags_number; 
	}
	return $args;
	}

endif;
add_filter('widget_tag_cloud_args', 'tlwpwc_tag_widget_limit');

/*
* Limit Number Of Tags in WordPress Default Tags Widget 
*/
if( ! function_exists( 'tlwpwc_woocommerce_tag_cloud_widget' ) ) :
function tlwpwc_woocommerce_tag_cloud_widget() {
	$tlwpwc_wc_tags_number = absint(get_theme_mod('tlwpwc_wc_tags_limit'));
	
    $args = array(
        'number' => $tlwpwc_wc_tags_number,
        'taxonomy' => 'product_tag'
    );
    return $args;
}
add_filter( 'woocommerce_product_tag_cloud_widget_args', 'tlwpwc_woocommerce_tag_cloud_widget' );
endif;