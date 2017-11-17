<div class="staff_carousel">
	<div class="profile-wrapper clearfix">
	<?php 
	$args = array(
		'post_type' => 'staff_members', 
		'posts_per_page' => -1 
	);
	$loop = new WP_Query($args);
	if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); 
	?>
				
		<div class="profile">
				
				<div class="profile-img-container">
					<div class="profile-hover">
						<div class="icon-wrap">
							<div class="icon-inner">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<?php 
						if ( has_post_thumbnail() ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
							   <?php the_post_thumbnail( 'full' ); ?>
					<?php } ?>
				</div>
				
				<div class="profile-title">
					<div>
						<span class="member">
							<span class="member_name">
								<?php the_title(); ?> 
							</span><!--<br>
							<span class="member_cred">
								<?php the_field('member_creds'); ?>
							</span>-->
						</span>
					</div>
				</div>
		</div>
			
	<?php endwhile; endif; wp_reset_query(); ?>
			
	</div>
</div>