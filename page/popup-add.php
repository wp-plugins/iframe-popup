<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$iframepopup_errors = array();
$iframepopup_success = '';
$iframepopup_error_found = FALSE;

// Preset the form fields
$form = array(
	'id' => '',
	'title' => '',
	'url' => '',
	'width' => '',
	'height' => '',
	'transitionin' => '',
	'transitionout' => '',
	'centeronscroll' => '',
	'titleshow' => '',
	'expiration' => '',
	'starttime' => '',
	'overlaycolor' => '',
	'group' => '',
	'timeout' => ''
);

// Form submitted, check the data
if (isset($_POST['iframepopup_form_submit']) && $_POST['iframepopup_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('iframepopup_form_add');
	
	$form['title'] = isset($_POST['title']) ? $_POST['title'] : '';
	if ($form['title'] == '')
	{
		$iframepopup_errors[] = __('Enter your title for popup window.', IFRAMEPOP_TDOMAIN);
		$iframepopup_error_found = TRUE;
	}
	
	$form['url'] = isset($_POST['url']) ? $_POST['url'] : '';
	if ($form['url'] == '')
	{
		$iframepopup_errors[] = __('Enter URL to display in Iframe popup window. URL must start with either http or https', IFRAMEPOP_TDOMAIN);
		$iframepopup_error_found = TRUE;
	}

	$form['width'] = isset($_POST['width']) ? $_POST['width'] : '';
	$form['height'] = isset($_POST['height']) ? $_POST['height'] : '';
	$form['transitionin'] = isset($_POST['transitionin']) ? $_POST['transitionin'] : '';
	$form['transitionout'] = isset($_POST['transitionout']) ? $_POST['transitionout'] : '';
	$form['centeronscroll'] = isset($_POST['centeronscroll']) ? $_POST['centeronscroll'] : '';
	$form['titleshow'] = isset($_POST['titleshow']) ? $_POST['titleshow'] : '';
	$form['expiration'] = isset($_POST['expiration']) ? $_POST['expiration'] : '';
	$form['starttime'] = isset($_POST['starttime']) ? $_POST['starttime'] : '';
	$form['overlaycolor'] = isset($_POST['overlaycolor']) ? $_POST['overlaycolor'] : '';
	$form['group'] = isset($_POST['group']) ? $_POST['group'] : '';
	$form['timeout'] = isset($_POST['timeout']) ? $_POST['timeout'] : '';

	//	No errors found, we can add this Group to the table
	if ($iframepopup_error_found == FALSE)
	{
		$action = iframepopup_cls_dbquery::popup_act($form, "ins");
		if($action == "sus")
		{
			$iframepopup_success = __('New details was successfully added.', IFRAMEPOP_TDOMAIN);
		}
		elseif($action == "err")
		{
			$iframepopup_success = __('Oops unexpected error occurred.', IFRAMEPOP_TDOMAIN);
			$iframepopup_error_found = TRUE;
		}

		// Reset the form fields
		$form = array(
			'id' => '',
			'title' => '',
			'url' => '',
			'width' => '',
			'height' => '',
			'transitionin' => '',
			'transitionout' => '',
			'centeronscroll' => '',
			'titleshow' => '',
			'expiration' => '',
			'starttime' => '',
			'overlaycolor' => '',
			'group' => '',
			'timeout' => ''
		);
	}
}

if ($iframepopup_error_found == TRUE && isset($iframepopup_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $iframepopup_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($iframepopup_error_found == FALSE && strlen($iframepopup_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $iframepopup_success; ?> <a href="<?php echo IFRAMEPOP_ADMINURL; ?>"><?php _e('Click here', IFRAMEPOP_TDOMAIN); ?></a> 
			<?php _e('to view the details', IFRAMEPOP_TDOMAIN); ?></strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo IFRAMEPOP_URL; ?>page/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(IFRAMEPOP_PLUGIN_DISPLAY, IFRAMEPOP_TDOMAIN); ?></h2>
	<form name="iframepopup_form" method="post" action="#" onsubmit="return _iframepopup_submit()"  >
      <h3><?php _e('Add details', IFRAMEPOP_TDOMAIN); ?></h3>
      
	  	<label for="tag-a"><?php _e('Iframe URL', IFRAMEPOP_TDOMAIN); ?></label>
		<input name="url" type="text" id="url" value="" size="70" maxlength="255" />
		<p><?php _e('Enter URL to display in Iframe popup window. URL must start with either http or https.', IFRAMEPOP_TDOMAIN); ?><br />Example: http://www.gopiplus.com/</p>
		
		<label for="tag-a"><?php _e('Popup title', IFRAMEPOP_TDOMAIN); ?></label>
		<input name="title" type="text" id="title" value="" size="70" maxlength="255" />
		<p><?php _e('Enter your title for popup window.', IFRAMEPOP_TDOMAIN); ?></p>

		<label for="tag-a"><?php _e('Width', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="width" id="width">
			<option value='30%'>30%</option>
			<option value='35%'>35%</option>
			<option value='40%'>40%</option>
			<option value='45%'>45%</option>
			<option value='50%'>50%</option>
			<option value='55%'>55%</option>
			<option value='60%' selected="selected">60%</option>
			<option value='65%'>65%</option>
			<option value='70%'>70%</option>
			<option value='75%'>75%</option>
			<option value='80%'>80%</option>
			<option value='85%'>85%</option>
			<option value='90%'>90%</option>
		</select>
		<p><?php _e('Select your width percentage for popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Height', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="height" id="height">
			<option value='30%'>30%</option>
			<option value='35%'>35%</option>
			<option value='40%'>40%</option>
			<option value='45%'>45%</option>
			<option value='50%'>50%</option>
			<option value='55%'>55%</option>
			<option value='60%' selected="selected">60%</option>
			<option value='65%'>65%</option>
			<option value='70%'>70%</option>
			<option value='75%'>75%</option>
			<option value='80%'>80%</option>
			<option value='85%'>85%</option>
			<option value='90%'>90%</option>
		</select>
		<p><?php _e('Select your height percentage for popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Transition In', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="transitionin" id="transitionin">
			<option value='fade' selected="selected">fade</option>
			<option value='elastic'>elastic</option>
			<option value='none'>none</option>
		</select>
		<p><?php _e('Transition type while opening popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Transition Out', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="transitionout" id="transitionout">
			<option value='fade' selected="selected">fade</option>
			<option value='elastic'>elastic</option>
			<option value='none'>none</option>
		</select>
		<p><?php _e('Transition type while closing popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Center on scroll', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="centeronscroll" id="centeronscroll">
			<option value='true' selected="selected">true</option>
			<option value='false'>false</option>
		</select>
		<p><?php _e('If true, popup window is centered while scrolling page.', IFRAMEPOP_TDOMAIN); ?></p>

		<label for="tag-a"><?php _e('Show Title', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="titleshow" id="titleshow">
			<option value='true' selected="selected">YES</option>
			<option value='false'>NO</option>
		</select>
		<p><?php _e('Display title under popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Start Date', IFRAMEPOP_TDOMAIN); ?></label>
		<input name="starttime" type="text" id="starttime" value="2014-04-01" maxlength="10" />
		<p><?php _e('Please enter popup display start date in this format YYYY-MM-DD', IFRAMEPOP_TDOMAIN); ?></p>			
		
		<label for="tag-a"><?php _e('Expiration Date', IFRAMEPOP_TDOMAIN); ?></label>
		<input name="expiration" type="text" id="expiration" value="9999-12-31" maxlength="10" />
		<p><?php _e('Please enter popup expiration date in this format YYYY-MM-DD', IFRAMEPOP_TDOMAIN); ?></p>	
		
		<label for="tag-a"><?php _e('Overlay Color', IFRAMEPOP_TDOMAIN); ?></label>
		<input name="overlaycolor" type="text" id="overlaycolor" value="#666666" maxlength="7" />
		<p><?php _e('Color of the overlay for popup window. (Example: #666666)', IFRAMEPOP_TDOMAIN); ?></p>	
		
		<label for="tag-a"><?php _e('Category', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="group" id="group">
			<?php for($i=1; $i<=10; $i++) { ?>
				<option value='Category<?php echo $i; ?>'>Category<?php echo $i; ?></option>
			<?php } ?>
		</select>
		<p><?php _e('Select category for this popup content.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Timeout', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="timeout" id="timeout">
			<option value='1000'>1 Sec</option>
			<option value='2000'>2 Sec</option>
			<option value='4000' selected="selected">4 Sec</option>
			<option value='6000'>6 Sec</option>
			<option value='8000'>8 Sec</option>
			<option value='10000'>10 Sec</option>
			<option value='12000'>12 Sec</option>
			<option value='15000'>15 Sec</option>
			<option value='20000'>20 Sec</option>
		</select>
		<p><?php _e('Timeout to open popup window.', IFRAMEPOP_TDOMAIN); ?></p>
	  
      <input name="id" id="id" type="hidden" value="">
      <input type="hidden" name="iframepopup_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Submit', IFRAMEPOP_TDOMAIN); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_iframepopup_redirect()" value="<?php _e('Cancel', IFRAMEPOP_TDOMAIN); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_iframepopup_help()" value="<?php _e('Help', IFRAMEPOP_TDOMAIN); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('iframepopup_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo IFRAMEPOP_OFFICIAL; ?></p>
</div>