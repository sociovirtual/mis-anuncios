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
require_once plugin_dir_path( __FILE__ ) . 'includes/wpgraphql.php';

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

        // Localize script para pasar datos de AJAX
    wp_localize_script('mi-anuncio-click-counter', 'mi_anuncio_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mi_anuncio_nonce')
    ));
}
add_action( 'wp_enqueue_scripts', 'mis_anuncios_enqueue_scripts' );

// // Cargar el text domain para la localización.
// function mis_anuncios_load_textdomain() {
//     load_plugin_textdomain( 'mis-anuncios', false, basename( dirname( __FILE__ ) ) . '/languages/' );
// }
// add_action( 'plugins_loaded', 'mis_anuncios_load_textdomain' );


// Manejar la solicitud AJAX
function mi_anuncio_increment_click_count() {
    // Verificar nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mi_anuncio_nonce')) {
        wp_send_json_error(array('error' => 'Nonce verification failed.'));
        return;
    }

    // Obtener el ID del post
    $post_id = intval($_POST['post_id']);

    // Obtener el contador de clics actual
    $click_count = get_post_meta($post_id, '_miAnuncio_clicks', true);
    $click_count = $click_count ? $click_count : 0;

    // Incrementar el contador de clics
    $click_count++;
    update_post_meta($post_id, '_miAnuncio_clicks', $click_count);

    // Enviar respuesta exitosa con el nuevo contador de clics
    wp_send_json_success(array('click_count' => $click_count));
}
add_action('wp_ajax_mi_anuncio_increment_click_count', 'mi_anuncio_increment_click_count');
add_action('wp_ajax_nopriv_mi_anuncio_increment_click_count', 'mi_anuncio_increment_click_count');


// Agregar columnas personalizadas en la lista de anuncios
function mi_anuncio_columns($columns) {
    $columns['mi_anuncio_url'] = __('URL', 'mis-anuncios');
    $columns['mi_anuncio_clicks'] = __('Clicks', 'mis-anuncios');
    $columns['mi_anuncio_size'] = __('Tamaño', 'mis-anuncios');
    $columns['mi_anuncio_shortcode'] = __('Shortcode', 'mis-anuncios');
    return $columns;
}
add_filter('manage_mianuncio_posts_columns', 'mi_anuncio_columns');

// Mostrar datos en las columnas personalizadas
function mi_anuncio_custom_column($column, $post_id) {
    switch ($column) {
        case 'mi_anuncio_url':
            echo esc_url(get_post_meta($post_id, '_miAnuncio_url', true));
            break;
        case 'mi_anuncio_clicks':
            echo esc_html(get_post_meta($post_id, '_miAnuncio_clicks', true));
            break;
        case 'mi_anuncio_size':
            echo esc_html(get_post_meta($post_id, '_miAnuncio_size', true));
            break;
        case 'mi_anuncio_shortcode':
            echo '[anuncio id="' . esc_attr($post_id) . '"]';
            break;
    }
}
add_action('manage_mianuncio_posts_custom_column', 'mi_anuncio_custom_column', 10, 2);


?>
