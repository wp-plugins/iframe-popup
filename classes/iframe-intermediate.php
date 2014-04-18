<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class iframepopup_cls_intermediate
{
	public static function iframepopup_admin()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(IFRAMEPOP_DIR.'page'.DIRECTORY_SEPARATOR.'popup-add.php');
				break;
			case 'edit':
				require_once(IFRAMEPOP_DIR.'page'.DIRECTORY_SEPARATOR.'popup-edit.php');
				break;
			case 'set':
				require_once(IFRAMEPOP_DIR.'page'.DIRECTORY_SEPARATOR.'popup-setting.php');
				break;
			default:
				require_once(IFRAMEPOP_DIR.'page'.DIRECTORY_SEPARATOR.'popup-show.php');
				break;
		}
	}
}
?>