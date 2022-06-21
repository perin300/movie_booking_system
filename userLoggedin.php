<?php
	/*
	*Template Name: User LogIn
	*/
	
get_header();
get_template_part('partials/page-header');
?>
<section class="main-content page-layout-<?php echo $page_layout; ?>">
		<div class="container">
			<div class="row">
         	<?php
			if(is_user_logged_in())
			{
				echo do_shortcode('[wppb-login]');
			}
			else
			{
				echo do_shortcode('[wppb-login]');
			?>	
            	<p><a class="button button-primary" href="http://localhost/movie_ticket/forgot password" data-wplink-url-error="true" data-wplink-edit="true">Forgot Password? click here to recover it!</a></p><br>
                
				<p><a class="button button-primary" href="http://localhost/movie_ticket/register/" data-wplink-url-error="true" data-wplink-edit="true">Register</a></p>
			<?php
            }
            get_footer();
            ?>
			</div>
        </div>
     </section>