<?php
/**
 * Single post template
 *
 * @package Malaysia_Solar
 */

get_header();
?>

<article <?php post_class(); ?>>
    <section class="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span>/</span>
                <a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a>
                <span>/</span>
                <span><?php the_title(); ?></span>
            </div>
            <h1><?php the_title(); ?></h1>
            <p style="color: var(--medium-gray); margin-top: var(--space-md);">
                <?php echo get_the_date(); ?> &bull; <?php echo get_the_author(); ?>
            </p>
        </div>
    </section>

    <section class="section">
        <div class="container container-narrow">
            <?php if (has_post_thumbnail()): ?>
                <div style="margin-bottom: var(--space-xl); border-radius: var(--radius-xl); overflow: hidden;">
                    <?php the_post_thumbnail('full', array('style' => 'width:100%;height:auto;')); ?>
                </div>
            <?php endif; ?>

            <div class="post-content" style="font-size: 1.0625rem; line-height: 1.8;">
                <?php the_content(); ?>
            </div>

            <?php if (has_tag()): ?>
                <div style="margin-top: var(--space-xl); padding-top: var(--space-xl); border-top: 1px solid rgba(10,22,40,0.1);">
                    <strong>Tags:</strong>
                    <?php the_tags('', ', '); ?>
                </div>
            <?php endif; ?>

            <!-- Post Navigation -->
            <div style="margin-top: var(--space-2xl); display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-lg);">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                <?php if ($prev_post): ?>
                    <a href="<?php echo get_permalink($prev_post); ?>" class="card" style="padding: var(--space-lg); text-decoration: none;">
                        <span style="font-size: 0.875rem; color: var(--medium-gray);">&larr; Previous</span>
                        <h4 style="margin-top: var(--space-xs); color: var(--space-deep);"><?php echo get_the_title($prev_post); ?></h4>
                    </a>
                <?php else: ?>
                    <div></div>
                <?php endif; ?>

                <?php if ($next_post): ?>
                    <a href="<?php echo get_permalink($next_post); ?>" class="card" style="padding: var(--space-lg); text-decoration: none; text-align: right;">
                        <span style="font-size: 0.875rem; color: var(--medium-gray);">Next &rarr;</span>
                        <h4 style="margin-top: var(--space-xs); color: var(--space-deep);"><?php echo get_the_title($next_post); ?></h4>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</article>

<!-- Related Posts CTA -->
<section class="cta-section section">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Go Solar?</h2>
            <p>Get your free personalized quote and start saving on your electricity bills today.</p>
            <a href="<?php echo esc_url(home_url('/get-a-quote/')); ?>" class="btn btn-secondary btn-lg">
                Get Free Quote
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
