<?php
// Función del shortcode para mostrar un anuncio
function mis_anuncio_display_ad( $atts ) {
    $atts = shortcode_atts(
        array(
            'id' => '',
        ),
        $atts,
        'mis_anuncio_ad'
    );

    $post_id = $atts['id'];

    // Obtener los metadatos del anuncio
    // $ad_link = get_post_meta( $post_id, '_mis_anuncio_ad_link', true );
    // $ad_image = get_the_post_thumbnail_url( $post_id, 'full' );

    $url = get_post_meta($post_id, '_miAnuncio_url', true);
    $size = get_post_meta($post_id, '_miAnuncio_size', true);
    $image = get_post_meta($post_id, '_miAnuncio_image', true);

    // Contador de clics (deberás implementar la lógica de actualización en js/click-counter.js)
    // $click_count = get_post_meta( $post_id, '_mis_anuncio_click_count', true );
    $clicks = get_post_meta($post_id, '_miAnuncio_clicks', true);

    // Construir el HTML del anuncio
    ob_start();
    ?>
    <div class="mi-anuncio-ad-container">
        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" class="mi-anuncio-ad-link" data-postid="<?php echo esc_attr( $post_id ); ?>">
            <?php echo wp_get_attachment_image($image, $size); ?>
        </a>
        <p class="mi-anuncio-click-count"><?php printf( __( 'Clicks: %s', 'mi-anuncio' ), esc_html( $clicks ) ); ?></p>
    </div>
    <?php
    return ob_get_clean();
}

// Registrar el shortcode
function mis_anuncio_register_shortcodes() {
    add_shortcode( 'anuncio', 'mis_anuncio_display_ad' );
}

add_action( 'init', 'mis_anuncio_register_shortcodes' );
?>
