<?php
/*
 Plugin Name: Parler WordPress Admin
 Plugin URI:
 Description:
 Version: 1
 Author: John Dee
 Author URI: https://generalchicken.net
 */

namespace ParlerAdmin;

require_once (plugin_dir_path(__FILE__). 'src/ParlerAdmin/autoloader.php');

$WebhookReceiver = new WebhookReceiver;

$ManualHookFeature = new ManualHookFeature;
$ManualHookFeature->enableManualHookFeature();


if(isset($_GET['parler-webhook-reset'])){
    add_action('init', 'resetWebhook');
    delete_option('parler-one-time-update' );
    delete_option('parler-urls' );
    die('reset');
}


include_once('Webhooks.class.php');

add_shortcode('remote-parler-sites', array(new RemoteSites, 'returnShortcode'));
