<label class="ti-left-label"><span><?php echo TrustindexPlugin_airbnb::___('%s Business URL', [ "Airbnb" ]); ?>:</span></label>
<div class="input">
<input
class="form-control"
placeholder="<?php echo TrustindexPlugin_airbnb::___('e.g.:') . ' ' . esc_attr($exampleUrl); ?>"
id="page-link"
type="text"
required="required"
/>
<span class="info-text"><?php echo TrustindexPlugin_airbnb::___("Type your business/company's URL and select from the list"); ?></span>
<img class="loading" src="<?php echo admin_url('images/loading.gif'); ?>" />
<div class="results"
data-errortext="<?php echo TrustindexPlugin_airbnb::___('Please add your URL again: this is not a valid %s page.', [ "Airbnb" ]); ?>"
></div>
</div>
<button class="btn btn-text btn-check"><?php echo TrustindexPlugin_airbnb::___('Check'); ?></button>