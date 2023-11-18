<div class="ti-box ti-rate-us-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_booking::___("How's experience with Trustindex?"); ?></div>
<p><?php echo TrustindexPlugin_booking::___('Rate us by clicking on the stars'); ?></p>
<div class="ti-quick-rating">
<?php for ($i = 5; $i >= 1; $i--): ?><div class="ti-star-check" data-value="<?php echo $i; ?>"></div><?php endfor; ?>
</div>
</div>
<div class="ti-modal ti-rateus-modal" id="ti-rateus-modal-feedback">
<div class="ti-modal-dialog">
<div class="ti-modal-content">
<span class="ti-close-icon btn-modal-close"></span>
<div class="ti-modal-body">
<div class="ti-rating-textbox">
<div class="ti-quick-rating">
<?php for ($i = 5; $i >= 1; $i--): ?><div class="ti-star-check" data-value="<?php echo $i; ?>"></div><?php endfor; ?>
<div class="clear"></div>
</div>
</div>
<div class="ti-rateus-title"><?php echo TrustindexPlugin_booking::___('Thanks for your feedback!<br />Let us know how we can improve.') ;?></div>
<input type="text" class="form-control" placeholder="<?php echo TrustindexPlugin_booking::___('Contact e-mail') ;?>" value="<?php echo $current_user->user_email; ?>" />
<textarea class="form-control" placeholder="<?php echo TrustindexPlugin_booking::___('Describe your experience') ;?>"></textarea>
</div>
<div class="ti-modal-footer">
<a href="#" class="btn-text btn-default btn-modal-close"><?php echo TrustindexPlugin_booking::___('Cancel') ;?></a>
<a href="#" class="btn-text btn-rateus-support"><?php echo TrustindexPlugin_booking::___('Contact our support') ;?></a>
</div>
</div>
</div>
</div>