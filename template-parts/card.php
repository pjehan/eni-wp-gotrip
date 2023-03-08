<article class="card">
    <?php the_post_thumbnail('medium'); ?>
    <h2><?php the_title(); ?></h2>
    <p><?php the_excerpt(); ?></p>
    <a href="<?php the_permalink(); ?>" class="btn">
        Voir plus
    </a>
</article>