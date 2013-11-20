<?php global $theme; ?>
    
    <div <?php post_class('post clearfix'); ?> id="post-<?php the_ID(); ?>">
    	<?php /*
        <div class="postmeta-primary">
			
            <span class="meta_date"><?php echo get_the_date(); ?></span>
           &nbsp;  <span class="meta_categories"><?php the_category(', '); ?></span>

                <?php if(comments_open( get_the_ID() ))  {
                    ?> &nbsp; <span class="meta_comments"><?php comments_popup_link( __( 'No comments', 'themater' ), __( '1 Comment', 'themater' ), __( '% Comments', 'themater' ) ); ?></span><?php
                } ?>
			
        </div>
        */ ?> 
        
        
        <?php
            if(has_post_thumbnail())  {
                ?>
                <div class="featured-image-container"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a></div><?php  
            }
        ?>
            
        <div class="entry clearfix">
            <h2 class="title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themater' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <?php
               // the_content('');
               the_excerpt();
            ?>
            <?php
            $photo = get_post_custom_values('photo');
            $video = get_post_custom_values('video');
            $logo = get_post_custom_values('logo');
			?>
			<ul class="event-links">
				<?php if($photo): ?>
					<li>
						<a href="<?php echo $photo[0] ?>"><?php echo __('View photo') ?></a>
					</li>
				<?php endif ?>
				<?php if($video): ?>
					<li>
						<a href="<?php echo $video[0] ?>"><?php echo __('Video clip') ?></a>
					</li>
				<?php endif ?>
			</ul>
			<?php if($logo[0]): ?>
				<div class="press-logo">
					<img src="<?php echo $logo[0] ?>" />
				</div>
			<?php endif; ?>
			
	        <?php if($theme->display('read_more')) { ?>
	        <div class="readmore">
	            <a href="<?php the_permalink(); ?>#more-<?php the_ID(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themater' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php $theme->option('read_more'); ?></a>
	        </div>
	        <?php } ?>			
			
        </div>
        

        
    </div><!-- Post ID <?php the_ID(); ?> -->