<?php
defined('ABSPATH') or die('No script kiddies please!');
wp_enqueue_script('trustindex-js', 'https://cdn.trustindex.io/loader.js', [], false, true);
?>
<div class="ti-box rate-us en">
<div class="ti-box-head">
<div class="ti-row">
<div class="ti-col">
<h1><?php echo TrustindexPlugin_airbnb::___('Please help us by reviewing our Plugin.'); ?></h1>
<p><?php echo TrustindexPlugin_airbnb::___("We've spent a lot of time developing this software. If you use the free version, you can still support us by leaving a review!"); ?></p>
<p><?php echo TrustindexPlugin_airbnb::___('Thank you in advance!'); ?></p>
<a class="btn-text btn-lg" href="https://wordpress.org/support/plugin/<?php echo $trustindex_pm_airbnb->get_plugin_slug(); ?>/reviews/?rate=5#new-post" target="_blank"><?php echo TrustindexPlugin_airbnb::___('Click here to rate us!'); ?></a>
</div>
</div>
</div>
<hr>
<div class="ti-row">
<div class="ti-col-12">
<div src='https://cdn.trustindex.io/loader.js?<?php echo '89f194388a0c3874c25adcae2f'; ?>'></div>
</div>
</div>
</div>