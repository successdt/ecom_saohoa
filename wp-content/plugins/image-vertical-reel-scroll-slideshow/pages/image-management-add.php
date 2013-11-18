<div class="wrap">
<?php
$ivrss_errors = array();
$ivrss_success = '';
$ivrss_error_found = FALSE;

// Preset the form fields
$form = array(
	'ivrss_path' => '',
	'ivrss_link' => '',
	'ivrss_target' => '',
	'ivrss_title' => '',
	'ivrss_order' => '',
	'ivrss_status' => '',
	'ivrss_type' => ''
);

// Form submitted, check the data
if (isset($_POST['ivrss_form_submit']) && $_POST['ivrss_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('ivrss_form_add');
	
	$form['ivrss_path'] = isset($_POST['ivrss_path']) ? $_POST['ivrss_path'] : '';
	if ($form['ivrss_path'] == '')
	{
		$ivrss_errors[] = __('Please enter the image path.', WP_ivrss_UNIQUE_NAME);
		$ivrss_error_found = TRUE;
	}

	$form['ivrss_link'] = isset($_POST['ivrss_link']) ? $_POST['ivrss_link'] : '';
	if ($form['ivrss_link'] == '')
	{
		$ivrss_errors[] = __('Please enter the target link.', WP_ivrss_UNIQUE_NAME);
		$ivrss_error_found = TRUE;
	}
	
	$form['ivrss_target'] = isset($_POST['ivrss_target']) ? $_POST['ivrss_target'] : '';
	$form['ivrss_title'] = isset($_POST['ivrss_title']) ? $_POST['ivrss_title'] : '';
	$form['ivrss_order'] = isset($_POST['ivrss_order']) ? $_POST['ivrss_order'] : '';
	$form['ivrss_status'] = isset($_POST['ivrss_status']) ? $_POST['ivrss_status'] : '';
	$form['ivrss_type'] = isset($_POST['ivrss_type']) ? $_POST['ivrss_type'] : '';

	//	No errors found, we can add this Group to the table
	if ($ivrss_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_ivrss_TABLE."`
			(`ivrss_path`, `ivrss_link`, `ivrss_target`, `ivrss_title`, `ivrss_order`, `ivrss_status`, `ivrss_type`)
			VALUES(%s, %s, %s, %s, %d, %s, %s)",
			array($form['ivrss_path'], $form['ivrss_link'], $form['ivrss_target'], $form['ivrss_title'], $form['ivrss_order'], $form['ivrss_status'], $form['ivrss_type'])
		);
		$wpdb->query($sql);
		
		$ivrss_success = __('New image details was successfully added.', WP_ivrss_UNIQUE_NAME);
		
		// Reset the form fields
		$form = array(
			'ivrss_path' => '',
			'ivrss_link' => '',
			'ivrss_target' => '',
			'ivrss_title' => '',
			'ivrss_order' => '',
			'ivrss_status' => '',
			'ivrss_type' => ''
		);
	}
}

if ($ivrss_error_found == TRUE && isset($ivrss_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $ivrss_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($ivrss_error_found == FALSE && strlen($ivrss_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $ivrss_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=image-vertical-reel-scroll-slideshow">Click here</a> to view the details</strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/image-vertical-reel-scroll-slideshow/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo WP_ivrss_TITLE; ?></h2>
	<form name="ivrss_form" method="post" action="#" onsubmit="return ivrss_submit()"  >
      <h3>Add new image details</h3>
      <label for="tag-image">Enter image path</label>
      <input name="ivrss_path" type="text" id="ivrss_path" value="" size="125" />
      <p>Where is the picture located on the internet</p>
      <label for="tag-link">Enter target link</label>
      <input name="ivrss_link" type="text" id="ivrss_link" value="" size="125" />
      <p>When someone clicks on the picture, where do you want to send them</p>
      <label for="tag-target">Enter target option</label>
      <select name="ivrss_target" id="ivrss_target">
        <option value='_blank'>_blank</option>
        <option value='_parent'>_parent</option>
        <option value='_self'>_self</option>
        <option value='_new'>_new</option>
      </select>
      <p>Do you want to open link in new window?</p>
      <label for="tag-title">Enter image reference</label>
      <input name="ivrss_title" type="text" id="ivrss_title" value="" size="125" />
      <p>Enter image reference. This is only for reference.</p>
      <label for="tag-select-gallery-group">Select gallery type</label>
      <select name="ivrss_type" id="ivrss_type">
        <option value='GROUP1'>Group1</option>
        <option value='GROUP2'>Group2</option>
        <option value='GROUP3'>Group3</option>
        <option value='GROUP4'>Group4</option>
        <option value='GROUP5'>Group5</option>
        <option value='GROUP6'>Group6</option>
        <option value='GROUP7'>Group7</option>
        <option value='GROUP8'>Group8</option>
        <option value='GROUP9'>Group9</option>
        <option value='GROUP0'>Group0</option>
		<option value='Widget'>Widget</option>
		<option value='Sample'>Sample</option>
      </select>
      <p>This is to group the images. Select your slideshow group. </p>
      <label for="tag-display-status">Display status</label>
      <select name="ivrss_status" id="ivrss_status">
        <option value='YES'>Yes</option>
        <option value='NO'>No</option>
      </select>
      <p>Do you want the picture to show in your galler?</p>
      <label for="tag-display-order">Display order</label>
      <input name="ivrss_order" type="text" id="ivrss_order" size="10" value="" maxlength="3" />
      <p>What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.</p>
      <input name="ivrss_id" id="ivrss_id" type="hidden" value="">
      <input type="hidden" name="ivrss_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button-primary" value="Insert Details" type="submit" />
        <input name="publish" lang="publish" class="button-primary" onclick="ivrss_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="ivrss_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('ivrss_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo WP_ivrss_LINK; ?></p>
</div>