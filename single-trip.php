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

    <?php foreach (carbon_get_the_post_meta('gallery') as $image_id) : ?>
        <?= wp_get_attachment_image($image_id, 'large'); ?>
    <?php endforeach; ?>

    <div>
        Durée : <?php echo carbon_get_the_post_meta('duration'); ?> heures
        <br>
        Nombre de personnes max : <?php echo carbon_get_the_post_meta('group_size'); ?>
    </div>

    <?php the_content(); ?>

    <h2>Langues</h2>
    <?php echo get_the_term_list(get_the_ID(), 'language', '', ', '); ?>

    <h2>Points intéressants</h2>
    <ul>
        <?php foreach (carbon_get_the_post_meta('highlights') as $highlight) : ?>
            <li>
                <?= $highlight['highlight_text']; ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?php endwhile; else : ?>
    <p>Aucun élément à afficher</p>
<?php endif; ?>

<?php get_footer(); ?>