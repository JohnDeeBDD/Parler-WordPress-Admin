<?php

namespace ParlerAdmin;

class RemoteSites{
    
    public function returnShortcode(){
        $output = "<table><tr><td>Site:</td><td>Email:</td></tr>";
        
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'webhook',
        );
        $the_query = new \WP_Query( $args );
        if ($the_query->have_posts()) {
            while ( $the_query->have_posts() ) :
            $the_query->the_post();
            $title = get_the_title();
            $content = get_the_content();
            $output = $output . "<tr><td><a href = '$title/wp-json/parler/published-list' target = '_blank'>$title</a></td><td>$content</td></tr>";
            endwhile;
        }
        $output = $output . "</table>";
        
        return $output;
    }
    
}