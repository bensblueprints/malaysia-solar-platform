<?php
/**
 * Default page template
 *
 * @package Malaysia_Solar
 */

get_header();
?>

<section class="page-header">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<section class="section">
    <div class="container container-narrow">
        <div class="page-content" style="font-size: 1.0625rem; line-height: 1.8;">
            <?php
            while (have_posts()):
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
