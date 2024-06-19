<?php

// Añadir este código en tu archivo wpgraphql.php

add_action('graphql_register_types', function() {
    // Registrar el campo URL
    register_graphql_field('anuncio', 'miAnuncioUrl', [
        'type' => 'String',
        'description' => __('URL del anuncio', 'your-textdomain'),
        'resolve' => function($post) {
            return get_post_meta($post->ID, '_miAnuncio_url', true);
        }
    ]);

    // Registrar el campo Clicks
    register_graphql_field('anuncio', 'miAnuncioClicks', [
        'type' => 'Int',
        'description' => __('Cantidad de clics del anuncio', 'your-textdomain'),
        'resolve' => function($post) {
            return (int) get_post_meta($post->ID, '_miAnuncio_clicks', true);
        }
    ]);

    // Registrar el campo Size
    register_graphql_field('anuncio', 'miAnuncioSize', [
        'type' => 'String',
        'description' => __('Tamaño del anuncio', 'your-textdomain'),
        'resolve' => function($post) {
            return get_post_meta($post->ID, '_miAnuncio_size', true);
        }
    ]);

    // Registrar el campo Image
    register_graphql_field('anuncio', 'miAnuncioImage', [
        'type' => 'String',
        'description' => __('Imagen del anuncio', 'your-textdomain'),
        'resolve' => function($post) {
            return get_post_meta($post->ID, '_miAnuncio_image', true);
        }
    ]);

    // Registrar el campo HtmlAnuncio
    register_graphql_field('anuncio', 'htmlAnuncio', [
            'type' => 'String',
            'description' => __('HTML del anuncio', 'your-textdomain'),
            'resolve' => function($post) {
                $url = get_post_meta($post->ID, '_miAnuncio_url', true);
                $size = get_post_meta($post->ID, '_miAnuncio_size', true);
                $image = get_post_meta($post->ID, '_miAnuncio_image', true);
                ob_start();
                ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="mi-anuncio-ad-link" data-postid="<?php echo esc_attr($post->ID); ?>">
                    <?php echo wp_get_attachment_image($image, $size); ?>
                </a>
                <?php
                return ob_get_clean();
            }
    ]);


});
