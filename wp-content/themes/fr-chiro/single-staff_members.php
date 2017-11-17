<?php
get_header();
?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
				<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						
						<div class="clearfix">
							<h1><?php the_title(); ?></h1>
							<div class="staff-content-portrait"><?php if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'medium', array( 'class' => 'profile-img' ));
							} ?></div>
							
							<div><?php the_content(); ?></div>
						</div>
				<?php endwhile; else : ?>
					<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
				<?php endif; ?>
				
				<div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #e9e9e9;">
					<h2 style="padding-top: 0;"><?php _e('Other Practitioners'); ?></h2>
					<?php get_template_part('includes/staff_members_loop_custom'); ?>
				</div>
			</div>
		<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php  get_footer(); ?>