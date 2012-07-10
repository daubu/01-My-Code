<?php

    global $post;
    $resources = _core::method( '_resources' , 'get' );
    $customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $post -> ID );
    
    if( !empty( $resources[ $customID ][ 'taxonomy' ] ) && is_array( $resources[ $customID ][ 'taxonomy' ] ) ){
        foreach( $resources[ $customID ][ 'taxonomy' ] as $taxonomy ){
            if( !isset( $taxonomy[ 'hierarchical' ] ) || ( isset( $taxonomy[ 'hierarchical' ] ) && ( empty( $taxonomy[ 'hierarchical' ] ) ||  $taxonomy[ 'hierarchical' ] != 'hierarchical' ) ) ){
                $terms = wp_get_post_terms( $post -> ID , $taxonomy[ 'slug' ] , array( "fields" => "all" ) );

                if( !empty( $terms ) ){
                    echo '<aside class="widget">';
                    echo '<h4 class="widget-title">' . $taxonomy[ 'ptitle' ] . '</h4>';
                    echo '<p class="delimiter">&nbsp;</p>';

                    foreach( $terms as $term ){
                        if( isset( $term -> slug ) && isset( $term -> name  ) ){
                            echo '<p class="tags"><a href="' . get_term_link( $term -> slug , $taxonomy[ 'slug' ] ) . '">' . $term -> name . '</a></p>';
                        }
                    }

                    echo '</aside>';
                }
            }
        }
    }

?>