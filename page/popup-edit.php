<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$result = '0';
$result = iframepopup_cls_dbquery::popup_count($did);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', IFRAMEPOP_TDOMAIN); ?></strong></p></div><?php
}
else
{
	$iframepopup_errors = array();
	$iframepopup_success = '';
	$iframepopup_error_found = FALSE;
	
	$data = array();
	$data = iframepopup_cls_dbquery::popup_select($did);
	
	// Preset the form fields
	$form = array(
		'id' => $data[0]['id'],
		'title' => $data[0]['title'],
		'url' => $data[0]['url'],
		'width' => $data[0]['width'],
		'height' => $data[0]['height'],
		'transitionin' => $data[0]['transitionin'],
		'transitionout' => $data[0]['transitionout'],
		'centeronscroll' => $data[0]['centeronscroll'],
		'titleshow' => $data[0]['titleshow'],
		'expiration' => $data[0]['expiration'],
		'starttime' => $data[0]['starttime'],
		'overlaycolor' => $data[0]['overlaycolor'],
		'group' => $data[0]['group'],
		'timeout' => $data[0]['timeout']
	);
}
// Form submitted, check the data
if (isset($_POST['iframepopup_form_submit']) && $_POST['iframepopup_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('iframepopup_form_edit');
	
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
	$form['id'] = isset($_POST['id']) ? $_POST['id'] : '';

	//	No errors found, we can add this Group to the table
	if ($iframepopup_error_found == FALSE)
	{	
		$action = iframepopup_cls_dbquery::popup_act($form, "ups");
		if($action == "sus")
		{
			$iframepopup_success = __('Details was successfully updated.', IFRAMEPOP_TDOMAIN);
		}
		elseif($action == "err")
		{
			$iframepopup_success = __('Oops unexpected error occurred.', IFRAMEPOP_TDOMAIN);
			$iframepopup_error_found = TRUE;
		}
	}
}

if ($iframepopup_error_found == TRUE && isset($iframepopup_errors[0]) == TRUE)
{
	?><div class="error fade"><p><strong><?php echo $iframepopup_errors[0]; ?></strong></p></div><?php
}
if ($iframepopup_error_found == FALSE && strlen($iframepopup_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $iframepopup_success; ?> 
		<a href="<?php echo IFRAMEPOP_ADMINURL; ?>"><?php _e('Click here', IFRAMEPOP_TDOMAIN); ?></a> 
		<?php _e('to view the details', IFRAMEPOP_TDOMAIN); ?></strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo IFRAMEPOP_URL; ?>page/setting.js"></script>
<script language="JavaScript" src="<?php echo IFRAMEPOP_URL; ?>inc/color/jscolor.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(IFRAMEPOP_PLUGIN_DISPLAY, IFRAMEPOP_TDOMAIN); ?></h2>
	<form name="iframepopup_form" method="post" action="#" onsubmit="return _iframepopup_submit()"  >
      <h3><?php _e('Update details', IFRAMEPOP_TDOMAIN); ?></h3>
	  
	  	<label for="tag-a"><?php _e('Iframe URL', IFRAMEPOP_TDOMAIN); ?></label>
		<input name="url" type="text" id="url" value="<?php echo $form['url']; ?>" size="70" maxlength="255" />
		<p><?php _e('Enter URL to display in Iframe popup window. URL must start with either http or https.', IFRAMEPOP_TDOMAIN); ?><br />Example: http://www.gopiplus.com/</p>
		
		<label for="tag-a"><?php _e('Popup title', IFRAMEPOP_TDOMAIN); ?></label>
		<input name="title" type="text" id="title" value="<?php echo $form['title']; ?>" size="70" maxlength="255" />
		<p><?php _e('Enter your title for popup window.', IFRAMEPOP_TDOMAIN); ?></p>

		<label for="tag-a"><?php _e('Width', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="width" id="width">
			<option value='30%' <?php if($form['width'] == '30%') { echo "selected='selected'" ; } ?>>30%</option>
			<option value='35%' <?php if($form['width'] == '35%') { echo "selected='selected'" ; } ?>>35%</option>
			<option value='40%' <?php if($form['width'] == '40%') { echo "selected='selected'" ; } ?>>40%</option>
			<option value='45%' <?php if($form['width'] == '45%') { echo "selected='selected'" ; } ?>>45%</option>
			<option value='50%' <?php if($form['width'] == '50%') { echo "selected='selected'" ; } ?>>50%</option>
			<option value='55%' <?php if($form['width'] == '55%') { echo "selected='selected'" ; } ?>>55%</option>
			<option value='60%' <?php if($form['width'] == '60%') { echo "selected='selected'" ; } ?>>60%</option>
			<option value='65%' <?php if($form['width'] == '65%') { echo "selected='selected'" ; } ?>>65%</option>
			<option value='70%' <?php if($form['width'] == '70%') { echo "selected='selected'" ; } ?>>70%</option>
			<option value='75%' <?php if($form['width'] == '75%') { echo "selected='selected'" ; } ?>>75%</option>
			<option value='80%' <?php if($form['width'] == '80%') { echo "selected='selected'" ; } ?>>80%</option>
			<option value='85%' <?php if($form['width'] == '85%') { echo "selected='selected'" ; } ?>>85%</option>
			<option value='90%' <?php if($form['width'] == '90%') { echo "selected='selected'" ; } ?>>90%</option>
		</select>
		<p><?php _e('Select your width percentage for popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Height', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="height" id="height">
			<option value='30%' <?php if($form['height'] == '30%') { echo "selected='selected'" ; } ?>>30%</option>
			<option value='35%' <?php if($form['height'] == '35%') { echo "selected='selected'" ; } ?>>35%</option>
			<option value='40%' <?php if($form['height'] == '40%') { echo "selected='selected'" ; } ?>>40%</option>
			<option value='45%' <?php if($form['height'] == '45%') { echo "selected='selected'" ; } ?>>45%</option>
			<option value='50%' <?php if($form['height'] == '50%') { echo "selected='selected'" ; } ?>>50%</option>
			<option value='55%' <?php if($form['height'] == '55%') { echo "selected='selected'" ; } ?>>55%</option>
			<option value='60%' <?php if($form['height'] == '60%') { echo "selected='selected'" ; } ?>>60%</option>
			<option value='65%' <?php if($form['height'] == '65%') { echo "selected='selected'" ; } ?>>65%</option>
			<option value='70%' <?php if($form['height'] == '70%') { echo "selected='selected'" ; } ?>>70%</option>
			<option value='75%' <?php if($form['height'] == '75%') { echo "selected='selected'" ; } ?>>75%</option>
			<option value='80%' <?php if($form['height'] == '80%') { echo "selected='selected'" ; } ?>>80%</option>
			<option value='85%' <?php if($form['height'] == '85%') { echo "selected='selected'" ; } ?>>85%</option>
			<option value='90%' <?php if($form['height'] == '90%') { echo "selected='selected'" ; } ?>>90%</option>
		</select>
		<p><?php _e('Select your height percentage for popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Transition In', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="transitionin" id="transitionin">
			<option value='fade' <?php if($form['transitionin'] == 'fade') { echo "selected='selected'" ; } ?>>fade</option>
			<option value='elastic' <?php if($form['transitionin'] == 'elastic') { echo "selected='selected'" ; } ?>>elastic</option>
			<option value='none' <?php if($form['transitionin'] == 'none') { echo "selected='selected'" ; } ?>>none</option>
		</select>
		<p><?php _e('Transition type while opening popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Transition Out', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="transitionout" id="transitionout">
			<option value='fade' <?php if($form['transitionout'] == 'fade') { echo "selected='selected'" ; } ?>>fade</option>
			<option value='elastic' <?php if($form['transitionout'] == 'elastic') { echo "selected='selected'" ; } ?>>elastic</option>
			<option value='none' <?php if($form['transitionout'] == 'none') { echo "selected='selected'" ; } ?>>none</option>
		</select>
		<p><?php _e('Transition type while closing popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Center on scroll', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="centeronscroll" id="centeronscroll">
			<option value='true' <?php if($form['centeronscroll'] == 'true') { echo "selected='selected'" ; } ?>>true</option>
			<option value='false' <?php if($form['centeronscroll'] == 'false') { echo "selected='selected'" ; } ?>>false</option>
		</select>
		<p><?php _e('If true, popup window is centered while scrolling page.', IFRAMEPOP_TDOMAIN); ?></p>

		<label for="tag-a"><?php _e('Show Title', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="titleshow" id="titleshow">
			<option value='true' <?php if($form['titleshow'] == 'true') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='false' <?php if($form['titleshow'] == 'false') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('Display title under popup window.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Start Date', IFRAMEPOP_TDOMAIN); ?></label>
		<input name="starttime" type="text" id="starttime" value="<?php echo substr($form['starttime'],0,10); ?>" maxlength="10" />
		<p><?php _e('Please enter popup display start date in this format YYYY-MM-DD', IFRAMEPOP_TDOMAIN); ?></p>			
		
		<label for="tag-a"><?php _e('Expiration Date', IFRAMEPOP_TDOMAIN); ?></label>
		<input name="expiration" type="text" id="expiration" value="<?php echo substr($form['expiration'],0,10); ?>" maxlength="10" />
		<p><?php _e('Please enter popup expiration date in this format YYYY-MM-DD', IFRAMEPOP_TDOMAIN); ?></p>	
		
		<label for="tag-a"><?php _e('Overlay Color', IFRAMEPOP_TDOMAIN); ?></label>
		<input class="color" name="overlaycolor" type="text" id="overlaycolor" value="<?php echo $form['overlaycolor']; ?>" maxlength="7" />
		<p><?php _e('Color of the overlay for popup window. (Example: #666666)', IFRAMEPOP_TDOMAIN); ?></p>	
		
		<label for="tag-a"><?php _e('Category', IFRAMEPOP_TDOMAIN); ?></label>
		<?php
		$thisselected = "";
		?>
		<select name="group" id="group">
			<?php 
			for($i=1; $i<=15; $i++) 
			{ 
				if($form['group'] == "Category".$i) 
				{ 
					$thisselected = "selected='selected'" ; 
				}
				?><option value='Category<?php echo $i; ?>' <?php echo $thisselected; ?>>Category<?php echo $i; ?></option><?php
				$thisselected = "";
			} 
			?>
		</select>
		<p><?php _e('Select category for this popup content.', IFRAMEPOP_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Timeout', IFRAMEPOP_TDOMAIN); ?></label>
		<select name="timeout" id="timeout">
			<option value='1000' <?php if($form['timeout'] == '1000') { echo "selected='selected'" ; } ?>>1 Sec</option>
			<option value='2000' <?php if($form['timeout'] == '2000') { echo "selected='selected'" ; } ?>>2 Sec</option>
			<option value='4000' <?php if($form['timeout'] == '4000') { echo "selected='selected'" ; } ?>>4 Sec</option>
			<option value='6000' <?php if($form['timeout'] == '6000') { echo "selected='selected'" ; } ?>>6 Sec</option>
			<option value='8000' <?php if($form['timeout'] == '8000') { echo "selected='selected'" ; } ?>>8 Sec</option>
			<option value='10000' <?php if($form['timeout'] == '10000') { echo "selected='selected'" ; } ?>>10 Sec</option>
			<option value='12000' <?php if($form['timeout'] == '12000') { echo "selected='selected'" ; } ?>>12 Sec</option>
			<option value='15000' <?php if($form['timeout'] == '15000') { echo "selected='selected'" ; } ?>>15 Sec</option>
			<option value='20000' <?php if($form['timeout'] == '20000') { echo "selected='selected'" ; } ?>>20 Sec</option>
		</select>
		<p><?php _e('Timeout to open popup window.', IFRAMEPOP_TDOMAIN); ?></p>
	  
      <input name="id" id="id" type="hidden" value="<?php echo $form['id']; ?>">
      <input type="hidden" name="iframepopup_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Submit', IFRAMEPOP_TDOMAIN); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_iframepopup_redirect()" value="<?php _e('Cancel', IFRAMEPOP_TDOMAIN); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_iframepopup_help()" value="<?php _e('Help', IFRAMEPOP_TDOMAIN); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('iframepopup_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo IFRAMEPOP_OFFICIAL; ?></p>
</div>