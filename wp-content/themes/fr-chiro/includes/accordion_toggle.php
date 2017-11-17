<div class="accordion-container">
	
	<?php if( have_rows('dropdown_toggles') ):
	      while ( have_rows('dropdown_toggles') ) : the_row(); ?>
	
	<div class="faq-container">
		<p class="question"><span class="icon-container"><i class="fa fa-plus"></i></span><?php the_sub_field('toggle_title'); ?></p>
		<div class="answer clearfix">
		
		<?php 
		
		$image = get_sub_field('toggle_image');
		$toggle_wysiwyg = get_sub_field('toggle_wysiwyg');
		
		if( !empty($image) ): ?>
		
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="toggle_img" />
		
		<?php endif;
		
		the_sub_field('toggle_content');
		
		if ( $toggle_wysiwyg ):
			
			echo $toggle_wysiwyg;
		
		endif ?>
		
		</div>
	</div>
	
	<?php endwhile; endif; ?>
	
</div>