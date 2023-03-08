<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="container site-header">
    <?php if(has_custom_logo()) : ?>
        <?php the_custom_logo(); ?>
    <?php else: ?>
        <?php bloginfo('name'); ?>
    <?php endif; ?>

    <?php wp_nav_menu([ 'theme_location' => 'primary', 'container' => 'nav', 'container_class' => 'menu-primary' ]) ?>
</header>

<main class="container">