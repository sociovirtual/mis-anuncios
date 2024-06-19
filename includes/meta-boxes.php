<?php
// Registrar meta boxes
function miAnuncio_register_meta_boxes() {
    add_meta_box('miAnuncio_info', __('Información del Anuncio', 'mis-anuncios'), 'miAnuncio_meta_box_callback', 'miAnuncio','normal','high');
}
add_action('add_meta_boxes', 'miAnuncio_register_meta_boxes');

// Callback para mostrar el contenido del meta box
function miAnuncio_meta_box_callback($post) {
    // Añadir un campo nonce para verificarlo más tarde.
    wp_nonce_field('miAnuncio_save_meta_box_data', 'miAnuncio_meta_box_nonce');

    // Obtener valores actuales de los campos para mostrarlos en el formulario.
    $url = get_post_meta($post->ID, '_miAnuncio_url', true);
    $clicks = get_post_meta($post->ID, '_miAnuncio_clicks', true);
    $size = get_post_meta($post->ID, '_miAnuncio_size', true);
    $image = get_post_meta($post->ID, '_miAnuncio_image', true);

    // Formulario del meta box
    echo '<label for="miAnuncio_url">' . __('URL del Anuncio', 'mis-anuncios') . '</label>';
    echo '<input type="text" id="miAnuncio_url" name="miAnuncio_url" value="' . esc_attr($url) . '" size="25" />';
    echo '<br/><br/>';

    echo '<label for="miAnuncio_clicks">' . __('Clicks del Anuncio', 'mis-anuncios') . '</label>';
    echo '<input type="number" id="miAnuncio_clicks" name="miAnuncio_clicks" value="' . esc_attr($clicks) . '" size="25" />';
    echo '<br/><br/>';

    // Selector de tamaño del anuncio
    // echo '-->'.$size;
    echo '<label for="miAnuncio_size">' . __('Tamaño del Anuncio', 'mis-anuncios') . '</label>';
    echo '<select id="miAnuncio_size" name="miAnuncio_size">
            <option value="leaderboard" ' . selected($size, 'leaderboard', false) . '>Leaderboard (728x90)</option>
            <option value="large_rectangle" ' . selected($size, 'large_rectangle', false) . '>Large Rectangle (336x280)</option>
            <option value="medium_rectangle" ' . selected($size, 'medium_rectangle', false) . '>Medium Rectangle (300x250)</option>
            <option value="mobile_banner" ' . selected($size, 'mobile_banner', false) . '>Mobile Banner (300x50)</option>
            <option value="wide_skyscraper" ' . selected($size, 'wide_skyscraper', false) . '>Wide Skyscraper (160x600)</option>
        </select>';
    echo '<br/><br/>';

    // Imagen
    echo '<label for="miAnuncio_image">' . __('Imagen Anuncio', 'mis-anuncios') . '</label>';
    echo '<br/>';
    if ($image) {
        // echo '<div><img src="' . esc_url(wp_get_attachment_image_url($image, $size )) . '" />';
        echo wp_get_attachment_image($image, $size);
        echo '<br/><a href="#" id="remove_miAnuncio_image">Eliminar</a><br/></div>';
    }
    echo '<input type="hidden" id="miAnuncio_image" name="miAnuncio_image" value="' . esc_attr($image) . '"  />';
    echo '<button class="button" id="upload_miAnuncio_image"> Subir/Seleccionar Anuncio</button>';
    echo '<br/><br/>';

    ?>
    <script>
    jQuery(document).ready(function($) {
        // Subir/Seleccionar Imagen
        $('#upload_miAnuncio_image').click(function(e) {
            e.preventDefault();
            var custom_uploader = wp.media({
                title: 'Seleccionar Anuncio',
                button: {
                    text: 'Agregar Anuancio'
                },
                multiple: false
            });
            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#miAnuncio_image').val(attachment.id);
                $('#miAnuncio_image').before('<img src="' + attachment.url + '" style="max-width:200px;height:auto;"/><br/><a href="#" id="remove_cinema_poster">Eliminar</a><br/>');
            });
            custom_uploader.open();
        });

        // Eliminar Imagen
        $(document).on('click', '#remove_miAnuncio_image', function(e) {
            e.preventDefault();
            $('#miAnuncio_image').val('');
            $('#miAnuncio_image').parent().find('img').attr('src', '').hide();
            $('#miAnuncio_image').parent().find('a').hide();
        });
    });
    </script>
    <?php
}

// Guardar los datos del meta box
function miAnuncio_save_meta_box_data($post_id) {
    // Verificar si el campo nonce está presente y es válido.
    if (!isset($_POST['miAnuncio_meta_box_nonce']) || !wp_verify_nonce($_POST['miAnuncio_meta_box_nonce'], 'miAnuncio_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Verificar si el usuario actual tiene permiso para editar el post.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Verificar si los campos están presentes antes de guardarlos.
    if (isset($_POST['miAnuncio_url'])) {
        update_post_meta($post_id, '_miAnuncio_url', sanitize_text_field($_POST['miAnuncio_url']));
    }

    if (isset($_POST['miAnuncio_clicks'])) {
        update_post_meta($post_id, '_miAnuncio_clicks', intval($_POST['miAnuncio_clicks']));
    }

    if (isset($_POST['miAnuncio_size'])) {
        update_post_meta($post_id, '_miAnuncio_size', sanitize_text_field($_POST['miAnuncio_size']));
    }

    if (isset($_POST['miAnuncio_image'])) {
        update_post_meta($post_id, '_miAnuncio_image', sanitize_text_field($_POST['miAnuncio_image']));
    }
}
add_action('save_post', 'miAnuncio_save_meta_box_data');
?>
