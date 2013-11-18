<?php /* get_header(); ?>

    <div id="main-fullwidth">
        
        <div class="woocommerce">
           <?php if(function_exists('woocommerce_content')) { woocommerce_content(); } ?>
       </div>
        
    </div><!-- #main-fullwidth -->
    
<?php get_footer(); */ ?>

<?php global $theme; get_header(); ?>

    <div id="main">
    
        <?php $theme->hook('main_before'); ?>

        <div id="content" class="two-columns">
            
	        <div class="woocommerce">
	           <?php if(function_exists('woocommerce_content')) { woocommerce_content(); } ?>
	       	</div>
        
        </div><!-- #content -->
    
        <div id="sidebar-primary" class="two-columns">
		      <?php
		      if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('primary-sidebar') ) :
		      endif; ?>
		</div>
        
        <?php $theme->hook('main_after'); ?>
        
    </div><!-- #main -->
    
<?php get_footer(); ?>