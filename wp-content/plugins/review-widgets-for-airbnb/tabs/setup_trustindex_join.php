<?php
defined('ABSPATH') or die('No script kiddies please!');
$ti_success = "";
if (isset($_COOKIE['ti-success'])) {
$ti_success = sanitize_text_field($_COOKIE['ti-success']);
setcookie('ti-success', '', time() - 60, "/");
}
$ti_error = null;
$ti_command = isset($_POST['command']) ? sanitize_text_field($_POST['command']) : null;
if (!in_array($ti_command, [ 'connect', 'disconnect' ])) {
$ti_command = null;
}
if ($ti_command === 'connect') {
check_admin_referer('connect-reg_' . $trustindex_pm_airbnb->get_plugin_slug());
$sanitizedEmail = sanitize_email($_POST['email']);
$sanitizedPassword = stripslashes(sanitize_text_field(htmlentities($_POST['password'], ENT_QUOTES)));
if ($sanitizedEmail && $sanitizedPassword) {
$serverOutput = $trustindex_pm_airbnb->connect_trustindex_api([
'signin' => [
'username' => $sanitizedEmail,
'password' => html_entity_decode($sanitizedPassword),
],
'callback' => bin2hex(openssl_random_pseudo_bytes(10))
], 'connect');
if ($serverOutput['success']) {
setcookie('ti-success', 'connected', time() + 60, '/');
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=' . sanitize_text_field($_GET['tab']));
exit;
}
else {
$ti_error = TrustindexPlugin_airbnb::___('Wrong e-mail or password!');
}
}
else {
$ti_error = TrustindexPlugin_airbnb::___('You must provide a password and a valid e-mail!');
}
}
else if ($ti_command === 'disconnect') {
check_admin_referer('disconnect-reg_' . $trustindex_pm_airbnb->get_plugin_slug());
delete_option($trustindex_pm_airbnb->get_option_name('subscription-id'));
setcookie('ti-success', 'disconnected', time() + 60, '/');
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=' . sanitize_text_field($_GET['tab']));
exit;
}
$trustindexSubscriptionId = $trustindex_pm_airbnb->is_trustindex_connected();
$widgetNumber = $trustindex_pm_airbnb->get_trustindex_widget_number();
?>
<?php if ($ti_success === 'connected'): ?>
<?php echo TrustindexPlugin_airbnb::get_noticebox('success', TrustindexPlugin_airbnb::___('Trustindex account successfully connected!')); ?>
<?php elseif ($ti_success === 'disconnected'): ?>
<?php echo TrustindexPlugin_airbnb::get_noticebox('success', TrustindexPlugin_airbnb::___('Trustindex account successfully disconnected!')); ?>
<?php endif; ?>
<?php if ($ti_error): ?>
<?php echo TrustindexPlugin_airbnb::get_noticebox('error', $ti_error); ?>
<?php endif; ?>
<div class="ti-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_airbnb::___('Connect your Trustindex account'); ?></div>
<p><strong><?php echo TrustindexPlugin_airbnb::___('You can connect your %s with your Trustindex account, and can display your widgets easier.', [ 'Widgets for Airbnb Reviews' ]); ?></strong></p>
<?php if ($trustindexSubscriptionId): ?>
<?php
$tiWidgets = $trustindex_pm_airbnb->get_trustindex_widgets();
$tiPackage = is_array($tiWidgets) && $tiWidgets && isset($tiWidgets[0]['package']) ? $tiWidgets[0]['package'] : null;
?>
<p>
<?php echo TrustindexPlugin_airbnb::___('Your %s is connected.', [ TrustindexPlugin_airbnb::___('Trustindex account') ]); ?><br />
- <?php echo TrustindexPlugin_airbnb::___('Your subscription ID:'); ?> <strong><?php echo esc_html($trustindexSubscriptionId); ?></strong><br />
<?php if ($tiPackage): ?>
- <?php echo TrustindexPlugin_airbnb::___('Your package:'); ?> <strong><?php echo esc_html(TrustindexPlugin_airbnb::___($tiPackage)); ?></strong>
<?php endif; ?>
</p>
<?php if ($tiPackage === 'free'): ?>
<?php echo TrustindexPlugin_airbnb::get_noticebox('error', TrustindexPlugin_airbnb::___("Once the trial period has expired, the widgets will not appear. You can subscribe or switch back to the \"%s\" tab", [ TrustindexPlugin_airbnb::___('Free Widget Configurator') ])); ?>
<?php elseif ($tiPackage === 'trial'): ?>
<?php echo TrustindexPlugin_airbnb::get_noticebox('warning', TrustindexPlugin_airbnb::___("Once the trial period has expired, the widgets will not appear. You can subscribe or switch back to the \"%s\" tab", [ TrustindexPlugin_airbnb::___('Free Widget Configurator') ])); ?>
<?php endif; ?>
<form method="post" action="">
<input type="hidden" name="command" value="disconnect" />
<?php wp_nonce_field('disconnect-reg_' . $trustindex_pm_airbnb->get_plugin_slug()); ?>
<div class="text-center">
<button class="btn btn-text btn-refresh" type="submit" style="margin-top: 20px; margin-bottom: 0"><?php echo TrustindexPlugin_airbnb::___('Disconnect'); ?></button>
</div>
</form>
<?php else: ?>
<div class="ti-row">
<form id="form-connect" class="box-content ti-col-6" method="post" action="">
<input type="hidden" name="command" value="connect" />
<?php wp_nonce_field('connect-reg_' . $trustindex_pm_airbnb->get_plugin_slug()); ?>
<div class="form-group">
<label for="ti-reg-email2">E-mail</label>
<input
type="email"
placeholder="E-mail"
name="email"
class="form-control"
required="required"
id="ti-reg-email2"
value="<?php echo esc_attr($current_user->user_email); ?>"
/>
</div>
<div class="form-group">
<label for="ti-reg-password2"><?php echo TrustindexPlugin_airbnb::___('Password'); ?></label>
<input
type="password"
placeholder="<?php echo TrustindexPlugin_airbnb::___('Password'); ?>"
name="password"
class="form-control"
required="required"
id="ti-reg-password2"
/>
<span class="dashicons dashicons-visibility ti-toggle-password"></span>
</div>
<button type="submit" class="btn btn-primary"><?php echo TrustindexPlugin_airbnb::___('CONNECT ACCOUNT');?></button>
<br />
<p class="text-center">
<a class="btn-text btn-default" href="<?php echo 'https://admin.trustindex.io/'; ?>forgot-password" target="_blank"><?php echo TrustindexPlugin_airbnb::___('Have you forgotten your password?'); ?></a>
<a class="btn-text btn-default" href="https://www.trustindex.io/ti-redirect.php?a=sys&c=wp-airbnb-4" target="_blank"><?php echo TrustindexPlugin_airbnb::___('Create a new Trustindex account');?></a>
</p>
</form>
<div class="ti-col-6"></div>
</div>
<?php endif; ?>
</div>
<?php if ($trustindexSubscriptionId): ?>
<div class="ti-box disabled">
<div class="ti-box-header"><?php echo TrustindexPlugin_airbnb::___('Manage your Trustindex account'); ?></div>
<a class="btn-text" href="<?php echo 'https://admin.trustindex.io/'; ?>widget" target="_blank" <?php if ($ti_success == 'connected'): ?>data-autoclick="true"<?php endif; ?>><?php echo TrustindexPlugin_airbnb::___("Go to Trustindex's admin!"); ?></a>
<?php if ($ti_success === 'connected'): ?>
<?php echo TrustindexPlugin_airbnb::get_noticebox('success', TrustindexPlugin_airbnb::___('We will redirect you to the admin panel automatically in some seconds...')); ?>
<?php endif; ?>
</div>
<div class="ti-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_airbnb::___('Insert your widget into your wordpress site using shortcode'); ?></div>
<?php if ($trustindexSubscriptionId): ?>
<?php if ($widgetNumber): ?>
<p>
<?php echo TrustindexPlugin_airbnb::___('You have got %d widgets saved in Trustindex admin.', [ $widgetNumber ]); ?>
</p>
<?php foreach ($tiWidgets as $wcIndex => $wc): ?>
<p><strong><?php echo esc_html($wc['name']); ?>:</strong></p>
<?php if ($wc['widgets']): ?>
<ul>
<?php foreach ($wc['widgets'] as $wiNum => $w): ?>
<li>
<?php echo esc_html($wiNum + 1); ?>.
<a href=".ti-w-<?php echo esc_attr($wcIndex .'-'. $wiNum); ?>" class="btn-toggle" data-ti-id="<?php echo esc_attr($w['id']); ?>"><?php echo esc_html($w['name']); ?></a>
<div style="display: none" class="ti-w-<?php echo esc_attr($wcIndex .'-'. $wiNum); ?>">
<code class="code-ti-w-<?php echo esc_attr($wcIndex .'-'. $wiNum); ?>">[<?php echo $trustindex_pm_airbnb->get_shortcode_name(); ?> data-widget-id="<?php echo esc_attr($w['id']); ?>"]</code>
<a href=".code-ti-w-<?php echo esc_attr($wcIndex .'-'. $wiNum); ?>" class="btn-text btn-copy2clipboard"><?php echo TrustindexPlugin_airbnb::___('Copy to clipboard'); ?></a>
<br />
<br />
</div>
</li>
<?php endforeach; ?>
</ul>
<?php else: ?>
-
<?php endif; ?>
<?php endforeach; ?>
<?php else: ?>
<div style="margin: 0 -15px">
<?php echo TrustindexPlugin_airbnb::get_noticebox('warning', 'You have no widgets saved!'); ?>
</div>
<?php endif; ?>
<p>
<a class="btn-text" href="<?php echo 'https://admin.trustindex.io/'; ?>widget" target="_blank"><?php echo TrustindexPlugin_airbnb::___('Create more!'); ?></a>
</p>
<?php endif; ?>
</div>
<?php endif; ?>