<div class="profile-wrapper clearfix">
<?php 
	global $wp_query;
	$this_post = $post->ID;
	query_posts(array('post_type' => 'staff_members', 'post__not_in' => array($this_post), 'posts_per_page' => -1 ));
	
	while ( have_posts() ) : the_post(); ?>
			
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
		
<?php endwhile; wp_reset_query(); ?>
		
</div>