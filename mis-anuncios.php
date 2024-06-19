<?php
/**
 * Plugin Name: Mis-Anuncios
 * Plugin URI: http://tusitio.com/mi-anuncios
 * Description: Un plugin para gestionar anuncios publicitarios.
 * Version: 1.0
 * Author: Jose vargas
 * Author URI: http://tusitio.com
 * License: GPL2
 * Text Domain: mis-anuncios
 * Domain Path: /languages/
 */

// Asegúrate de que WordPress entienda que este es un plugin.
defined( 'ABSPATH' ) or die( '¡Acceso directo no permitido!' );

// Incluir los tipos de publicaciones personalizadas, metaboxes y shortcodes.
require_once plugin_dir_path( __FILE__ ) . 'includes/custom-post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/meta-boxes.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';

// Ahora tendrás los siguientes tamaños disponibles para tus imágenes:
function custom_image_sizes() {
    add_image_size('leaderboard', 728, 90, true);
    add_image_size('large_rectangle', 336, 280, true);
    add_image_size('medium_rectangle', 300, 250, true);
    add_image_size('mobile_banner', 300, 50, true);
    add_image_size('wide_skyscraper', 160, 600, true);
}
add_action('after_setup_theme', 'custom_image_sizes');


// Cargar los estilos y scripts.
function mis_anuncios_enqueue_scripts() {
    wp_enqueue_style( 'mi-anuncio-style', plugins_url( 'css/style.css', __FILE__ ) );
    wp_enqueue_script( 'mi-anuncio-click-counter', plugins_url( 'js/click-counter.js', __FILE__ ), array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'mis_anuncios_enqueue_scripts' );

// // Cargar el text domain para la localización.
// function mis_anuncios_load_textdomain() {
//     load_plugin_textdomain( 'mis-anuncios', false, basename( dirname( __FILE__ ) ) . '/languages/' );
// }
// add_action( 'plugins_loaded', 'mis_anuncios_load_textdomain' );

?>
