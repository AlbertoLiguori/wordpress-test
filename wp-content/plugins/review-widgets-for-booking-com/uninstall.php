<?php
require_once plugin_dir_path( __FILE__ ) . 'trustindex-plugin.class.php';
$trustindex_pm_booking = new TrustindexPlugin_booking("booking", __FILE__, "10.9", "Widgets for Booking.com Reviews", "Booking.com");
$trustindex_pm_booking->uninstall();
?>