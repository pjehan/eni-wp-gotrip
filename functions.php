<?php
add_action('wp_enqueue_scripts', 'gotrip_enqueue_styles');
function gotrip_enqueue_styles() {
    wp_enqueue_style('gotrip-style', get_template_directory_uri() . '/style.css', [], wp_get_theme()->get('Version'));
}

add_action('after_setup_theme', 'gotrip_register_menu');
function gotrip_register_menu() {
    register_nav_menu('primary', 'Menu principal');
}

add_action('after_setup_theme', 'gotrip_theme_support');
function gotrip_theme_support() {
    // Générer la balise <title> dans le <head>
    add_theme_support('title-tag');

    // Ajouter la gestion du logo du site
    add_theme_support('custom-logo', [
        'height' => 150,
        'width' => 300,
        'flex-width' => true,
    ]);

    // Activation des images à la une
    add_theme_support('post-thumbnails');

    // Gestion du HTML5
    add_theme_support('html5');
}

add_action('widgets_init', 'gotrip_widgets_init');
function gotrip_widgets_init() {
    register_sidebar([
        'id' => 'footer',
        'name' => 'Pied de page',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>'
    ]);
}

add_action('init', 'gotrip_register_trip_cpt');
function gotrip_register_trip_cpt() {
    register_post_type('trip', [
        'labels' => [
            'name' => 'Voyages',
            'singular_name' => 'Voyage',
            'menu_name' => 'Voyages'
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'voyages'],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt']
    ]);
}
