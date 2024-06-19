<?php
// Registrar el Custom Post Type 'miAnuncio'
function miAnuncio_custom_post_type() {
    $labels = array(
        'name'                  => _x('Anuncios', 'Post type general name', 'mis-anuncios'),
        'singular_name'         => _x('Anuncio', 'Post type singular name', 'mis-anuncios'),
        'menu_name'             => _x('Anuncios', 'Admin Menu text', 'mis-anuncios'),
        'name_admin_bar'        => _x('Anuncio', 'Add New on Toolbar', 'mis-anuncios'),
        'add_new'               => __('Añadir Nueva', 'mis-anuncios'),
        'add_new_item'          => __('Añadir Nueva Anuncio', 'mis-anuncios'),
        'new_item'              => __('Nueva Anuncio', 'mis-anuncios'),
        'edit_item'             => __('Editar Anuncio', 'mis-anuncios'),
        'view_item'             => __('Ver Anuncio', 'mis-anuncios'),
        'all_items'             => __('Todas las Anuncios', 'mis-anuncios'),
        'search_items'          => __('Buscar Anuncios', 'mis-anuncios'),
        'parent_item_colon'     => __('Anuncios Padre:', 'mis-anuncios'),
        'not_found'             => __('No se encontraron Anuncios.', 'mis-anuncios'),
        'not_found_in_trash'    => __('No se encontraron Anuncios en la papelera.', 'mis-anuncios'),
        'featured_image'        => _x('Imagen Destacada', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'mis-anuncios'),
        'set_featured_image'    => _x('Establecer imagen destacada', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'mis-anuncios'),
        'remove_featured_image' => _x('Eliminar imagen destacada', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'mis-anuncios'),
        'use_featured_image'    => _x('Usar como imagen destacada', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'mis-anuncios'),
        'archives'              => _x('Archivo de Anuncios', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'mis-anuncios'),
        'insert_into_item'      => _x('Insertar en la Anuncio', 'Overrides the “Insert into post” phrase. Added in 4.4', 'mis-anuncios'),
        'uploaded_to_this_item' => _x('Subido a esta Anuncio', 'Overrides the “Uploaded to this post” phrase. Added in 4.4', 'mis-anuncios'),
        'filter_items_list'     => _x('Filtrar lista de Anuncios', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”. Added in 4.4', 'mis-anuncios'),
        'items_list_navigation' => _x('Navegación de lista de Anuncios', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”. Added in 4.4', 'mis-anuncios'),
        'items_list'            => _x('Lista de Anuncios', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”. Added in 4.4', 'mis-anuncios'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'Anuncio'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'thumbnail',),
        'show_in_rest'       => true,
    );

    register_post_type('miAnuncio', $args);
}
add_action('init', 'miAnuncio_custom_post_type');
?>
