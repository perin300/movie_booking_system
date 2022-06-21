<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

get_header();

get_template_part('partials/page-header');

$post_meta		= get_post_meta($post->ID, '_sidebar', true);
$page_layout	= esc_attr(isset($post_meta['page_sidebar']) ? $post_meta['page_sidebar'] : 'full');
$page_column	= esc_attr($page_layout == 'full' ? '12' : '8');

if ($page_layout == 'fluid') {
	get_template_part('partials/page', 'section');
} else {
?>
	<section class="main-content page-layout-<?php echo $page_layout; ?>">
		<div class="container">
			<div class="row">

				<?php amy_movie_page_sidebar('left', $page_layout); ?>

				<div class="col-md-<?php echo $page_column; ?>">
					<div class="page-content">
						<?php
						while (have_posts()) {
							the_post();
							the_content();

							wp_link_pages(
								array(
									'before' 		=> '<nav class="amy-page-break amy-pagination">',
									'after'  		=> '</nav>',
									'link_before'	=> '<span class="current">',
									'link_after'	=> '</span>',
								)
							);

							do_action('amy_movie_page_end');

							if (comments_open() || '0' != get_comments_number()) {
								comments_template('', true);
							}
						}
						?>
					</div>
				</div>

				<?php amy_movie_page_sidebar('right', $page_layout); ?>

			</div>
			<div class="row">
				<div class="col-md-12">
					<?php dynamic_sidebar('blog-after'); ?>
				</div>
			</div>
		</div>
	</section>
<?php
}

get_footer();
