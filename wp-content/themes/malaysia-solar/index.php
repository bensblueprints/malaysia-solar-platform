<?php
/**
 * The main template file
 *
 * @package Malaysia_Solar
 */

get_header();
?>

<section class="page-header">
    <div class="container">
        <?php if (is_home() && !is_front_page()): ?>
            <h1><?php single_post_title(); ?></h1>
        <?php elseif (is_archive()): ?>
            <?php the_archive_title('<h1>', '</h1>'); ?>
        <?php elseif (is_search()): ?>
            <h1><?php printf(__('Search Results for: %s', 'malaysia-solar'), get_search_query()); ?></h1>
        <?php else: ?>
            <h1><?php _e('Latest News', 'malaysia-solar'); ?></h1>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (have_posts()): ?>
            <div class="grid grid-3 gap-xl">
                <?php while (have_posts()): the_post(); ?>
                    <article class="card">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="product-image" style="aspect-ratio: 16/9;">
                                <?php the_post_thumbnail('large', array('style' => 'width:100%;height:100%;object-fit:cover;')); ?>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 style="margin-bottom: var(--space-sm);">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p style="font-size: 0.875rem; color: var(--medium-gray); margin-bottom: var(--space-md);">
                                <?php echo get_the_date(); ?>
                            </p>
                            <p style="margin-bottom: var(--space-md);">
                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-ghost">
                                Read More
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div style="margin-top: var(--space-2xl); display: flex; justify-content: center;">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '&larr; Previous',
                    'next_text' => 'Next &rarr;',
                ));
                ?>
            </div>

        <?php else: ?>
            <div style="text-align: center; padding: var(--space-3xl);">
                <h2><?php _e('No posts found', 'malaysia-solar'); ?></h2>
                <p><?php _e('Sorry, no content matched your criteria.', 'malaysia-solar'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
