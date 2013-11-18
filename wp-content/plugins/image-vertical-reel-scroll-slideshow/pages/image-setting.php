<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php echo WP_ivrss_TITLE; ?></h2>
	<h3>Widget setting</h3>
    <?php
	$ivrss_title = get_option('ivrss_title');
	$ivrss_scrollercount = get_option('ivrss_scrollercount');
	$ivrss_scrollerheight = get_option('ivrss_scrollerheight');
	$ivrss_random = get_option('ivrss_random');
	$ivrss_type = get_option('ivrss_type');
	
	if (@$_POST['ivrss_submit']) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('ivrss_form_setting');
			
		$ivrss_title = stripslashes($_POST['ivrss_title']);
		$ivrss_scrollercount = stripslashes($_POST['ivrss_scrollercount']);
		$ivrss_scrollerheight = stripslashes($_POST['ivrss_scrollerheight']);
		$ivrss_random = stripslashes($_POST['ivrss_random']);
		$ivrss_type = stripslashes($_POST['ivrss_type']);

		update_option('ivrss_title', $ivrss_title );
		update_option('ivrss_scrollercount', $ivrss_scrollercount );
		update_option('ivrss_scrollerheight', $ivrss_scrollerheight );
		update_option('ivrss_random', $ivrss_random );
		update_option('ivrss_type', $ivrss_type );
		
		?>
		<div class="updated fade">
			<p><strong>Details successfully updated.</strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/image-vertical-reel-scroll-slideshow/pages/setting.js"></script>
    <form name="ivrss_form" method="post" action="">
      
	  <label for="tag-title">Enter widget title</label>
      <input name="ivrss_title" id="ivrss_title" type="text" value="<?php echo $ivrss_title; ?>" size="80" />
      <p>Enter widget title, Only for widget.</p>
      
	  <label for="tag-width">Display image count (Only number)</label>
      <input name="ivrss_scrollercount" id="ivrss_scrollercount" type="text" value="<?php echo $ivrss_scrollercount; ?>" />
      <p>No of images you want to display at the same time. (Example: 2)</p>
      
	  <label for="tag-height">Height of each image</label>
      <input name="ivrss_scrollerheight" id="ivrss_scrollerheight" type="text" value="<?php echo $ivrss_scrollerheight; ?>" />
      <p>Height of each images in the gallery. (Example: 170)</p>
	  
	  <label for="tag-height">Random order</label>
      <input name="ivrss_random" id="ivrss_random" type="text" value="<?php echo $ivrss_random; ?>" />
      <p>Image display random order. (Example: YES or NO)</p>
      
	  <label for="tag-height">Select your gallery group (Gallery  Type)</label>
      <!--<input name="ivrss_type" id="ivrss_type" type="text" value="<?php //echo $ivrss_type; ?>" />-->
	  <select name="ivrss_type" id="ivrss_type">
        <option value='GROUP1' <?php if($ivrss_type=='GROUP1') { echo 'selected' ; } ?>>Group1</option>
        <option value='GROUP2' <?php if($ivrss_type=='GROUP2') { echo 'selected' ; } ?>>Group2</option>
        <option value='GROUP3' <?php if($ivrss_type=='GROUP3') { echo 'selected' ; } ?>>Group3</option>
        <option value='GROUP4' <?php if($ivrss_type=='GROUP4') { echo 'selected' ; } ?>>Group4</option>
        <option value='GROUP5' <?php if($ivrss_type=='GROUP5') { echo 'selected' ; } ?>>Group5</option>
        <option value='GROUP6' <?php if($ivrss_type=='GROUP6') { echo 'selected' ; } ?>>Group6</option>
        <option value='GROUP7' <?php if($ivrss_type=='GROUP7') { echo 'selected' ; } ?>>Group7</option>
        <option value='GROUP8' <?php if($ivrss_type=='GROUP8') { echo 'selected' ; } ?>>Group8</option>
        <option value='GROUP9' <?php if($ivrss_type=='GROUP9') { echo 'selected' ; } ?>>Group9</option>
        <option value='GROUP0' <?php if($ivrss_type=='GROUP0') { echo 'selected' ; } ?>>Group0</option>
		<option value='Widget' <?php if($ivrss_type=='Widget') { echo 'selected' ; } ?>>Widget</option>
		<option value='sample' <?php if($ivrss_type=='Sample') { echo 'selected' ; } ?>>Sample</option>
      </select>
      <p>This field is to group the images. Select your group name to fetch the images for widget.</p>
      
	  <input name="ivrss_submit" id="ivrss_submit" class="button-primary" value="Submit" type="submit" />
	  <input name="publish" lang="publish" class="button-primary" onclick="ivrss_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="ivrss_help()" value="Help" type="button" />
	  <?php wp_nonce_field('ivrss_form_setting'); ?>
    </form>
  </div>
  <br /><p class="description"><?php echo WP_ivrss_LINK; ?></p>
</div>
