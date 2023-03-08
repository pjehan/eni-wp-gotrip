<?php get_header(); ?>

    <section class="grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : ?>
                <?php the_post(); ?>

                <?php get_template_part('template-parts/card', 'trip'); ?>

            <?php endwhile; ?>
        <?php else: ?>
            <p>Il n'y a pas de voyages :(</p>
        <?php endif; ?>
    </section>

<?php get_footer(); ?>