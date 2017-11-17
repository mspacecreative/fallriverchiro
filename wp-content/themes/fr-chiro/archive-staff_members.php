<?php
get_header();
?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
				<?php get_template_part('includes/staff_members_loop'); ?>
			</div>
		<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php  get_footer(); ?>