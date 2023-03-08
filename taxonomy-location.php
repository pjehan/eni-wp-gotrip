<?php get_header(); ?>

    <?php $term = get_queried_object();  ?>
    <h1>Liste des voyages : <?php echo $term->name; ?></h1>

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