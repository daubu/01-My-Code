<?php
    $resources = _core::method( '_resources' , 'get' );
    $customID = _attachment::getCustomIDByPostID( $post -> ID );
    
    $flag = true;
    
    if( isset( $resources[ $customID ][ 'taxonomy' ] ) ) {
        foreach( $resources[ $customID ][ 'taxonomy' ] as $taxonomy ) {
            
            if( isset( $taxonomy[ 'hierarchical' ] ) &&  $taxonomy[ 'hierarchical' ] == 'hierarchical' ) {
                $terms = wp_get_post_terms( $post -> ID , $taxonomy[ 'slug' ] , array( "fields" => "all" ) );

                if( !empty( $terms ) ) {
                    foreach( $terms as $term ) {
                        
                        if( $flag ) {
                            echo '<ul>';
                            $flag = false;
                        }
                        
                        if( isset( $term -> slug ) && isset( $term -> name  ) ) {
                            echo '<li><a href="' . get_term_link( $term -> slug , $taxonomy[ 'slug' ] ) . '">' . $term -> name . '</a></li>';
                        }
                    }
                }
            }
        }
    }
    
    if( !$flag ) {
        echo '</ul>';
    }
?>