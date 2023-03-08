<?php get_header(); ?>

<section class="grid">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : ?>
            <?php the_post(); ?>

            <article class="card">
                <?php the_post_thumbnail('medium'); ?>
                <h2><?php the_title(); ?></h2>
                <?php echo get_the_term_list(get_the_ID(), 'location', '', ', '); ?>
                <p><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>" class="btn">
                    Voir plus
                </a>
            </article>

        <?php endwhile; ?>
    <?php else: ?>
        <p>Il n'y a pas de voyages :(</p>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
