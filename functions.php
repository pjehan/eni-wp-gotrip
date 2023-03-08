<?php

use Carbon_Fields\Block;
use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('after_setup_theme', 'crb_load');
function crb_load() {
    require_once('vendor/autoload.php');
    Carbon_Fields::boot();
}


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
        'menu_icon' => 'dashicons-airplane',
        //'show_in_rest' => true,
        'rewrite' => ['slug' => 'voyages'],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt']
    ]);

    register_taxonomy('location', ['trip'], [
        'label' => 'Emplacements',
        'rewrite' => ['slug' => 'emplacement'],
        'hierarchical' => true
    ]);

    register_taxonomy('language', ['trip'], [
        'label' => 'Langues',
        'rewrite' => ['slug' => 'langue'],
        'hierarchical' => false
    ]);
}

add_action('carbon_fields_register_fields', 'gotrip_trip_register_field');
function gotrip_trip_register_field() {
    Container::make_post_meta('trip_container', 'Données du voyage')
        ->where('post_type', '=', 'trip')
        ->add_fields([
            Field::make_text('duration', 'Durée')
                ->set_attribute('type', 'number')
                ->set_help_text('Durée en heures'),
            Field::make_text('group_size', 'Taille du groupe')
                ->set_attribute('type', 'number'),
            Field::make_complex('highlights', 'Points intéressants')
                ->setup_labels([ 'singular_name' => 'Point intéressant', 'plural_name' => 'Points intéressants' ])
                ->set_layout('tabbed-horizontal')
                ->add_fields([
                    Field::make_text('highlight_text', 'Texte')
                ]),
            Field::make_media_gallery('gallery', 'Images')
                ->set_type('image')
        ]);

    // Ajouter une image (drapeau) sur les emplacements
    Container::make_term_meta('location_custom_fields', 'Données de l\'emplacement')
        ->where('term_taxonomy', '=', 'location')
        ->add_fields([
                Field::make_image('flag', 'Drapeau')
        ]);

    // Block Gutenberg pour afficher la liste des voyages
    Block::make('Liste voyages')
        ->set_category('gotrip', 'Go Trip', 'airplane')
        ->set_icon('list-view')
        ->add_fields([
            Field::make_association('tax_location', 'Emplacement')
                ->set_types([
                    [ 'type' => 'term', 'taxonomy' => 'location' ]
                ])
        ])
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {
            $locations = $fields['tax_location'];
            $locations_ids = array_map(fn($location) => $location['id'], $locations);
            /*
            $locations_ids = [];
            foreach ($locations as $location) {
                $locations_ids[] = $location['id'];
            }
            */
            $trips = new WP_Query([
                'post_type' => 'trip',
                'tax_query' => [
                    [ 'taxonomy' => 'location', 'field' => 'term_id', 'terms' => $locations_ids ]
                ]
            ]);
            ?>
            <ul>
                <?php while($trips->have_posts()) : ?>
                    <?php $trips->the_post(); ?>
                    <li>
                        <?php the_title(); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php
            wp_reset_postdata();
        });

    // Block Gutenberg pour afficher la liste des pays
    Block::make('Liste pays')
        ->set_category('gotrip')
        ->set_icon('admin-site')
        ->add_fields([
            Field::make_checkbox('display_flag', 'Afficher drapeau')
        ])
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {
            $display_flag = $fields['display_flag'];
            $countries = get_terms([
                'taxonomy' => 'location',
                'parent' => 0
            ]);
            ?>
            <ul>
                <?php foreach($countries as $country) : ?>
                    <li>
                        <?php if ($display_flag) : ?>
                            <?php echo wp_get_attachment_image(carbon_get_term_meta($country->term_id, 'flag'), 'thumbnail') ?>
                        <?php endif; ?>
                        <?= $country->name; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
        });
}

add_action('after_setup_theme', 'gotrip_after_setup_theme');
function gotrip_after_setup_theme() {
    gotrip_register_trip_cpt();
    flush_rewrite_rules();
}
