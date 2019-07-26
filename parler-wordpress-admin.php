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

function resetWebhook(){
    $urls = "";
    update_option( 'parler-urls', $urls);
}

function catchWebhook(){
    $newUrl =  $_POST['site-url'];
    $email = $_POST['email'];
    $urls = get_option('parler-urls');
    //var_dump($urls);die();
      
        if (strpos($urls, $newUrl) !== false) {}else{
            $newEntry = "Site: $newUrl Admin: $email <br />";
            $urls = $urls . $newEntry;
            update_option( 'parler-urls', $urls); 
        }
}

add_shortcode('parler-webhook', 'returnParlerURLs');

function returnParlerURLs(){
    $head = "<h2>Remote sites running Parler WordPress Plugin</h2><a href = '/parler-urls/?parler-webhook-reset=yes'>RESET</a><br />";
    $urls = get_option('parler-urls');
    $x = ($head . $urls);  
    return $x;
}



//die('plugin');
include_once('Webhooks.class.php');