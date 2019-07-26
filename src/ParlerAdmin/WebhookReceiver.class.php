<?php 

namespace ParlerAdmin;

class WebhookReceiver {
    
    public function __construct(){
        //die('WebhookReceiver');
        if (isset($_POST['parler-site-url'])){
            // die('incoming!');
            add_action('init', array($this, 'createWebhook'));
        }
    }
    
    public function createWebhook(){
        
        $siteUrl = "error. No site URL given.";
        if(isset($_POST['parler-site-url'])){
            $siteUrl = $_POST['parler-site-url'];
        }
        
        $senderEmail = "error. No sender email given.";
        if(isset($_POST['parler-sender'])){
            $senderEmail = $_POST['parler-sender'];
        }
        // Gather post data.
        $my_post = array(
            'post_title'    => $siteUrl,
            'post_type'     => 'webhook',
            'post_content'  => $senderEmail,
            'post_status'   => 'publish',
            'post_author'   => 1
        );
        
        // Insert the post into the database.
        wp_insert_post( $my_post );
   
    }
}