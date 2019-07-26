<?php 

namespace ParlerAdmin;

class WebhookReceiver {
    
    public function __construct(){
        //die('WebhookReceiver');
        //if (isset($_POST['parler-site-url'])){
            // die('incoming!');
            //add_action('init', array($this, 'createWebhook'));
       // }
        
        add_action('rest_api_init', array($this,'registerAPIroute'));
        //add_action('init', array($this,'showIDs'));
        
        
    }
    
    public function registerAPIroute(){
        register_rest_route(
            'parler',
            'webhookReceiver',
            array(
                'methods' => 'POST',
                'callback' =>
                array(
                    $this,
                    'createWebhook',
                ),
                'permission_callback' =>
                function () {
                    return true;
                    
                }
                )
            );
    }
    
    public function showIDs(){
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'webhook',
                'post_title' => "http://localhost:8888"
            );
            $the_query = new \WP_Query( $args );
            if ($the_query->have_posts()) {
                while ( $the_query->have_posts() ) :
                $the_query->the_post();
                wp_delete_post(get_the_ID());
                endwhile;
            }
            wp_reset_postdata();
        
    }
    
    public function deleteOldHooks($title){
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'webhook',
            'post_title' => $title
        );
        $the_query = new \WP_Query( $args );
        if ($the_query->have_posts()) {
            while ( $the_query->have_posts() ) :
            $the_query->the_post();
            wp_delete_post(get_the_ID());
            endwhile;
        }
        wp_reset_postdata();
    }
    
    public function createWebhook(){
        
        $siteUrl = "error. No site URL given.";
        if(isset($_POST['parler-site-url'])){
            $siteUrl = $_POST['parler-site-url'];
            //$this->deleteOldHooks($siteUrl);
        }
        
        $senderEmail = "error. No sender email given.";
        if(isset($_POST['parler-sender'])){
            $senderEmail = $_POST['parler-sender'];
        }
        
        
        
        ob_start();
        var_dump($_REQUEST);
        $result = ob_get_clean();
        
        // Gather post data.
        $my_post = array(
            'post_title'    => $siteUrl,
            'post_type'     => 'webhook',
            'post_content'  => $result,
            'post_status'   => 'publish',
            'post_author'   => 1
        );
        
        // Insert the post into the database.
        wp_insert_post( $my_post );
        unset($_REQUEST);
   
    }
}