<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <h1><?php the_title(); ?></h1>

    <div>
        <?php echo get_the_term_list(get_the_ID(), 'location', '', ', '); ?>
        <!--
        <?php $locations = get_the_terms(get_the_ID(), 'location'); ?>
        <ul>
            <?php foreach ($locations as $location) : ?>
                <li><?= $location->name ?></li>
            <?php endforeach; ?>
        </ul>
        -->
    </div>

    <?php the_post_thumbnail(); ?>
    <?php the_content(); ?>

    <h2>Langues</h2>
    <?php echo get_the_term_list(get_the_ID(), 'language', '', ', '); ?>

<?php endwhile; else : ?>
    <p>Aucun élément à afficher</p>
<?php endif; ?>

<?php get_footer(); ?>