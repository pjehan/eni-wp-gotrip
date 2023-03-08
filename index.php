<?php get_header(); ?>

<section class="grid">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/card', get_post_type()); ?>
    <?php endwhile; else : ?>
        <p>Aucun élément à afficher</p>
    <?php endif; ?>
</section>

<?php get_footer(); ?>