<?php
defined('ABSPATH') or die('No script kiddies please!');
$autoUpdates = get_option('auto_update_plugins', []);
$pluginSlug = "review-widgets-for-booking-com/review-widgets-for-booking-com.php";
if (isset($_GET['auto_update'])) {
if (!in_array($pluginSlug, $autoUpdates)) {
array_push($autoUpdates, $pluginSlug);
update_option('auto_update_plugins', $autoUpdates, false);
}
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=advanced');
exit;
}
if (isset($_GET['toggle_css_inline'])) {
$v = intval($_GET['toggle_css_inline']);
update_option($trustindex_pm_booking->get_option_name('load-css-inline'), $v, false);
if ($v && is_file($trustindex_pm_booking->getCssFile())) {
unlink($trustindex_pm_booking->getCssFile());
}
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=advanced');
exit;
}
if (isset($_GET['delete_css'])) {
if (is_file($trustindex_pm_booking->getCssFile())) {
unlink($trustindex_pm_booking->getCssFile());
}
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=advanced');
exit;
}
if (isset($_POST['save-notification-email'])) {
$type = strtolower(trim(sanitize_text_field($_POST['type'])));
$email = strtolower(trim(sanitize_text_field($_POST['save-notification-email'])));
$trustindex_pm_booking->setNotificationParam($type, 'email', $email);
exit;
}
$yesIcon = '<span class="dashicons dashicons-yes-alt"></span>';
$noIcon = '<span class="dashicons dashicons-dismiss"></span>';
$pluginUpdated = ($trustindex_pm_booking->get_plugin_current_version() <= "10.9");
$cssInline = get_option($trustindex_pm_booking->get_option_name('load-css-inline'), 0);
$css = get_option($trustindex_pm_booking->get_option_name('css-content'));
?>
<div class="ti-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_booking::___('Notifications'); ?></div>
<ul class="troubleshooting-checklist">
<li>
<?php echo TrustindexPlugin_booking::___('Review download available'); ?>
<ul>
<li>
<?php
$isNotificationActive = !$trustindex_pm_booking->getNotificationParam('review-download-available', 'hidden', false);
echo TrustindexPlugin_booking::___('Notification') .': '. ($isNotificationActive ? $yesIcon : $noIcon); ?>
<?php if ($isNotificationActive): ?>
<a href="?page=<?php echo sanitize_text_field($_GET['page']); ?>&tab=advanced&notification=review-download-available&action=hide"><?php echo TrustindexPlugin_booking::___('Disable'); ?></a>
<?php else: ?>
<a href="?page=<?php echo sanitize_text_field($_GET['page']); ?>&tab=advanced&notification=review-download-available&action=unhide"><?php echo TrustindexPlugin_booking::___('Enable'); ?></a>
<?php endif; ?>
</li>
<?php /*
<li>
<div class="ti-notification-email">
<div class="ti-inner">
<span><?php echo TrustindexPlugin_booking::___('Send email notification to:'); ?></span>
<input type="text" data-type="review-download-available" class="form-control" value="<?php echo $trustindex_pm_booking->getNotificationParam('review-download-available', 'email', get_option('admin_email')); ?>" />
</div>
<span class="d-none ti-text-success"><?php echo TrustindexPlugin_booking::___('Saved'); ?></span>
<span class="d-none ti-text-danger"><?php echo TrustindexPlugin_booking::___('Invalid email'); ?></span>
<div class="ti-info-text"><?php echo TrustindexPlugin_booking::___('Leave the field blank if you do not want email notification.'); ?></div>
</div>
</li> */ ?>
</ul>
</li>
<li>
<?php echo TrustindexPlugin_booking::___('Review download finished'); ?>
<ul>
<li>
<?php
$isNotificationActive = !$trustindex_pm_booking->getNotificationParam('review-download-finished', 'hidden', false);
echo TrustindexPlugin_booking::___('Notification') .': '. ($isNotificationActive ? $yesIcon : $noIcon); ?>
<?php if ($isNotificationActive): ?>
<a href="?page=<?php echo sanitize_text_field($_GET['page']); ?>&tab=advanced&notification=review-download-finished&action=hide"><?php echo TrustindexPlugin_booking::___('Disable'); ?></a>
<?php else: ?>
<a href="?page=<?php echo sanitize_text_field($_GET['page']); ?>&tab=advanced&notification=review-download-finished&action=unhide"><?php echo TrustindexPlugin_booking::___('Enable'); ?></a>
<?php endif; ?>
</li>
<li>
<div class="ti-notification-email">
<div class="ti-inner">
<span><?php echo TrustindexPlugin_booking::___('Send email notification to:'); ?></span>
<input type="text" data-type="review-download-finished" class="form-control" value="<?php echo $trustindex_pm_booking->getNotificationParam('review-download-finished', 'email', get_option('admin_email')); ?>" />
</div>
<span class="d-none ti-text-success"><?php echo TrustindexPlugin_booking::___('Saved'); ?></span>
<span class="d-none ti-text-danger"><?php echo TrustindexPlugin_booking::___('Invalid email'); ?></span>
<div class="ti-info-text"><?php echo TrustindexPlugin_booking::___('Leave the field blank if you do not want email notification.'); ?></div>
</div>
</li>
</ul>
</li>
</ul>
</div>
<div class="ti-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_booking::___("Troubleshooting"); ?></div>
<p><strong><?php echo TrustindexPlugin_booking::___('If you have any problem, you should try these steps:'); ?></strong></p>
<ul class="troubleshooting-checklist">
<li>
<?php echo TrustindexPlugin_booking::___("Trustindex plugin"); ?>
<ul>
<li>
<?php echo TrustindexPlugin_booking::___('Use the latest version:') .' '. ($pluginUpdated ? $yesIcon : $noIcon); ?>
<?php if (!$pluginUpdated): ?>
<a href="/wp-admin/plugins.php"><?php echo TrustindexPlugin_booking::___('Update'); ?></a>
<?php endif; ?>
</li>
<li>
<?php echo TrustindexPlugin_booking::___('Use automatic plugin update:') .' '. (in_array($pluginSlug, $autoUpdates) ? $yesIcon : $noIcon); ?>
<?php if(!in_array($pluginSlug, $autoUpdates)): ?>
<a href="?page=<?php echo sanitize_text_field($_GET['page']); ?>&tab=advanced&auto_update"><?php echo TrustindexPlugin_booking::___("Enable"); ?></a>
<div class="ti-notice notice-warning">
<p><?php echo TrustindexPlugin_booking::___("You should enable it, to get new features and fixes automatically, right after they published!"); ?></p>
</div>
<?php endif; ?>
</li>
</ul>
</li>
<?php if($css): ?>
<li>
CSS
<ul>
<li><?php
$uploadDir = dirname($trustindex_pm_booking->getCssFile());
echo TrustindexPlugin_booking::___('writing permission') .' (<strong>'. $uploadDir .'</strong>): '. (is_writable($uploadDir) ? $yesIcon : $noIcon); ?>
</li>
<li>
<?php echo TrustindexPlugin_booking::___('CSS content:'); ?>
<?php
if (is_file($trustindex_pm_booking->getCssFile())) {
$content = file_get_contents($trustindex_pm_booking->getCssFile());
if ($content === $css) {
echo $yesIcon;
}
else {
echo $noIcon .' '. TrustindexPlugin_booking::___("corrupted") .'
<div class="ti-notice notice-warning">
<p><a href="?page='. sanitize_text_field($_GET['page']) .'&tab=advanced&delete_css">'. TrustindexPlugin_booking::___("Delete the CSS file at <strong>%s</strong>.", [ $trustindex_pm_booking->getCssFile() ]) .'</a></p>
</div>';
}
}
else {
echo $noIcon;
}
?>
<span class="ti-checkbox row" style="margin-top: 5px">
<input type="checkbox" value="1" <?php if ($cssInline): ?>checked<?php endif;?> onchange="window.location.href = '?page=<?php echo sanitize_text_field($_GET['page']); ?>&tab=advanced&toggle_css_inline=' + (this.checked ? 1 : 0)">
<label><?php echo TrustindexPlugin_booking::___('Enable CSS internal loading'); ?></label>
</span>
</li>
</ul>
</li>
<?php endif; ?>
<li>
<?php echo TrustindexPlugin_booking::___('If you are using cacher plugin, you should:'); ?>
<ul>
<li><?php echo TrustindexPlugin_booking::___('clear the cache'); ?></li>
<li><?php echo TrustindexPlugin_booking::___("exclude Trustindex's JS file:"); ?> <strong><?php echo 'https://cdn.trustindex.io/'; ?>loader.js</strong>
<ul>
<li><a href="#" onclick="jQuery('#list-w3-total-cache').toggle(); return false;">W3 Total Cache</a>
<ol id="list-w3-total-cache" style="display: none;">
<li><?php echo TrustindexPlugin_booking::___('Navigate to'); ?> "Performance" > "Minify"</li>
<li><?php echo TrustindexPlugin_booking::___('Scroll to'); ?> "Never minify the following JS files"</li>
<li><?php echo TrustindexPlugin_booking::___('In a new line, add'); ?> https://cdn.trustindex.io/*</li>
<li><?php echo TrustindexPlugin_booking::___('Save'); ?></li>
</ol>
</li>
</ul>
</li>
</ul>
</li>
<li>
<?php
$plugin_url = 'https://wordpress.org/support/plugin/' . $trustindex_pm_booking->get_plugin_slug();
$screenshot_url = 'https://snipboard.io';
$screencast_url = 'https://streamable.com/upload-video';
$pastebin_url = 'https://pastebin.com';
echo TrustindexPlugin_booking::___('If the problem/question still exists, please create an issue here: %s', [ '<a href="'. $plugin_url .'" target="_blank">'. $plugin_url .'</a>' ]);
?>
<br />
<?php echo TrustindexPlugin_booking::___('Please help us with some information:'); ?>
<ul>
<li><?php echo TrustindexPlugin_booking::___('Describe your problem'); ?></li>
<li><?php echo TrustindexPlugin_booking::___('You can share a screenshot with %s', [ '<a href="'. $screenshot_url .'" target="_blank">'. $screenshot_url .'</a>' ]); ?></li>
<li><?php echo TrustindexPlugin_booking::___('You can share a screencast video with %s', [ '<a href="'. $screencast_url .'" target="_blank">'. $screencast_url .'</a>' ]); ?></li>
<li><?php echo TrustindexPlugin_booking::___('If you have an (webserver) error log, you can copy it to the issue, or link it with %s', [ '<a href="'. $pastebin_url .'" target="_blank">'. $pastebin_url .'</a>' ]); ?></li>
<li><?php echo TrustindexPlugin_booking::___('And include the information below:'); ?></li>
</ul>
</li>
</ul>
<textarea class="ti-troubleshooting-info" readonly><?php include $trustindex_pm_booking->get_plugin_dir() . 'include' . DIRECTORY_SEPARATOR . 'troubleshooting.php'; ?></textarea>
<a href=".ti-troubleshooting-info" class="btn-text btn-copy2clipboard ti-pull-right ti-tooltip toggle-tooltip ti-tooltip-left">
<?php echo TrustindexPlugin_booking::___('Copy to clipboard') ;?>
<span class="ti-tooltip-message">
<span style="color: #00ff00; margin-right: 2px">✓</span>
<?php echo TrustindexPlugin_booking::___('Copied'); ?>
</span>
</a>
<div class="clear"></div>
</div>
<div class="ti-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_booking::___('Re-create plugin'); ?></div>
<p><?php echo TrustindexPlugin_booking::___('Re-create the database tables of the plugin.<br />Please note: this removes all settings and reviews.'); ?></p>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&recreate" class="btn-text btn-refresh ti-pull-right" style="margin-left: 0"><?php echo TrustindexPlugin_booking::___('Re-create plugin'); ?></a>
<div class="clear"></div>
</div>
<div class="ti-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_booking::___('Translation'); ?></div>
<p>
<?php echo TrustindexPlugin_booking::___('If you notice an incorrect translation in the plugin text, please report it here:'); ?>
 <a href="mailto:support@trustindex.io">support@trustindex.io</a>
</p>
</div>