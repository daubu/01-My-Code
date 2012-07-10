<?php
    /* DEFAULT SETTINGS FOR CUSTOM BOXES */
    /* POSTS SETTINGS */
    /* RELATED POSTS */
    _box::$default[ 'posts-settings' ][ 'similar-use']                          = 'no';
    _box::$default[ 'posts-settings' ][ 'similar-default']                      = 'yes';
    _box::$default[ 'posts-settings' ][ 'similar-number']                       =  3;
    _box::$default[ 'posts-settings' ][ 'similar-criteria' ]                    = null;
    
    /* LIKE SETTINGS */
    _box::$default[ 'posts-settings' ][ 'likes-use' ]                           = 'no';
    _box::$default[ 'posts-settings' ][ 'likes-limit' ]                         =  50;
    
    /* SOCIAL SETTINGS */
    _box::$default[ 'posts-settings' ][ 'social-use' ]                          = 'yes';
    _box::$default[ 'posts-settings' ][ 'social-default' ]                      = 'yes';
    
    /* OTHER SETTINGS */
    _box::$default[ 'posts-settings' ][ 'author-box-use' ]                      = 'yes';
    _box::$default[ 'posts-settings' ][ 'author-box' ]                          = 'no';
    _box::$default[ 'posts-settings' ][ 'source-use' ]                          = 'no';
    _box::$default[ 'posts-settings' ][ 'archive-use' ]                         = 'no';
    _box::$default[ 'posts-settings' ][ 'archive' ]                             = 'no';
    _box::$default[ 'posts-settings' ][ 'meta-use' ]                            = 'yes';
    _box::$default[ 'posts-settings' ][ 'meta' ]                                = 'yes';
    
    
    $resource = isset( $_POST['args'][0] ) ? $_POST['args'][0] : -1;
    
    $resources = _core::method( '_resources' , 'get' );
    $postID = isset( $_GET['post'] ) ? $_GET['post'] : 0;
    
    if( $resource == -1 && isset ( $_GET[ 'post_type' ] ) ){
        $resource = _resources::getCustomIdByPostType( $_GET[ 'post_type' ] );
    }else{
        if( $resource == -1 ){
            $resource = _resources::getCustomIdByPostType( 'post' );
        }
    }
    
    if( $resource > -1 ){
        if(  isset( $resources[ $resource ][ 'taxonomy' ][0][ 'slug' ] ) ){
            _box::$default[ 'posts-settings' ][ 'similar-criteria'] = $resources[ $resource ][ 'taxonomy' ][0][ 'slug' ];
            
            $similar_use_js                                         = "tools.v( 'input.similar-use' )";
            $similar_default_js                                     = "tools.v( 'input.similar-default' )";
            $similar_number_js                                      = "tools.v( 'select#similar-number' )";
            $similar_criteria_js                                    = "tools.v( 'select#similar-criteria' )";
            
        }else{
            _box::$default[ 'posts-settings' ][ 'similar-use']      = 'no';
            
            $similar_use_js                                         = "'no'";
            $similar_default_js                                     = "'no'";
            $similar_number_js                                      = 3;
            $similar_criteria_js                                    = "''";
        }
        
        /* RELATED POSTS */
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'similar-use' ] ) ){
            $similar_use            = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'similar-use' ];
        }else{
            $similar_use            = _box::$default[ 'posts-settings' ][ 'similar-use' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'similar-default' ] ) ){
            $similar_default        = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'similar-default' ];
        }else{
            $similar_default        = _box::$default[ 'posts-settings' ][ 'similar-default' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'similar-number' ] ) ){
            $similar_number         = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'similar-number' ];
        }else{
            $similar_number         = _box::$default[ 'posts-settings' ][ 'similar-number' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'similar-criteria' ] ) ){
            $similar_criteria       = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'similar-criteria' ];
        }else{
            $similar_criteria       = _box::$default[ 'posts-settings' ][ 'similar-criteria' ];
        }
        
        /* LIKE SETTINGS */
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'likes-limit' ] ) ){
            $likes_use              = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ];
        }else{
            $likes_use              = _box::$default[ 'posts-settings' ][ 'likes-use' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'likes-limit' ] ) ){
            $likes_limit            = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'likes-limit' ];
        }else{
            $likes_limit            = _box::$default[ 'posts-settings' ][ 'likes-limit' ];
        }
        
        /* SOCIAL SETTINGS */
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'social-use' ] ) ){
            $social_use             = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'social-use' ];
        }else{
            $social_use             = _box::$default[ 'posts-settings' ][ 'social-use' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'social-default' ] ) ){
            $social_default         = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'social-default' ];
        }else{
            $social_default         = _box::$default[ 'posts-settings' ][ 'social-default' ];
        }
        
        /* OTHER SETTINGS */
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'author-box-use' ] ) ){
            $author_box_use         = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'author-box-use' ];
        }else{
            $author_box_use         = _box::$default[ 'posts-settings' ][ 'author-box-use' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'author-box' ] ) ){
            $author_box             = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'author-box' ];
        }else{
            $author_box             = _box::$default[ 'posts-settings' ][ 'author-box' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'source-use' ] ) ){
            $source_use             = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'source-use' ];
        }else{
            $source_use             = _box::$default[ 'posts-settings' ][ 'source-use' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'archive-use' ] ) ){
            $archive_use            = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'archive-use' ];
        }else{
            $archive_use            = _box::$default[ 'posts-settings' ][ 'archive-use' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'archive' ] ) ){
            $archive                = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'archive' ];
        }else{
            $archive                = _box::$default[ 'posts-settings' ][ 'archive' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'meta-use' ] ) ){
            $meta_use               = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'meta-use' ];
        }else{
            $meta_use               = _box::$default[ 'posts-settings' ][ 'meta-use' ];
        }
        
        if( isset(  $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'meta' ] ) ){
            $meta                   = $resources[ $resource ][ 'boxes' ][ 'posts-settings' ][ 'meta' ];
        }else{
            $meta                   = _box::$default[ 'posts-settings' ][ 'meta' ];
        }
        
    }else{
        
        $similar_use                = _box::$default[ 'posts-settings' ][ 'similar-use' ];
        $similar_default            = _box::$default[ 'posts-settings' ][ 'similar-default' ];
        $similar_number             = _box::$default[ 'posts-settings' ][ 'similar-number' ];
        $similar_criteria           = _box::$default[ 'posts-settings' ][ 'similar-criteria' ];

        /* LIKE SETTINGS */
        $likes_use                  = _box::$default[ 'posts-settings' ][ 'likes-use' ];
        $likes_limit                = _box::$default[ 'posts-settings' ][ 'likes-limit' ];

        /* SOCIAL SETTINGS */
        $social_use                 = _box::$default[ 'posts-settings' ][ 'social-use' ];
        $social_default             = _box::$default[ 'posts-settings' ][ 'social-default' ];

        /* OTHER SETTINGS */
        $author_box_use             = _box::$default[ 'posts-settings' ][ 'author-box-use' ];
        $author_box                 = _box::$default[ 'posts-settings' ][ 'author-box' ];
        $source_use                 = _box::$default[ 'posts-settings' ][ 'source-use' ];
        $archive_use                = _box::$default[ 'posts-settings' ][ 'archive-use' ];
        $archive                    = _box::$default[ 'posts-settings' ][ 'archive' ];
        $meta_use                   = _box::$default[ 'posts-settings' ][ 'meta-use' ];
        $meta                       = _box::$default[ 'posts-settings' ][ 'meta' ];
        
        $similar_use_js             = "tools.v( 'input.similar-use' )";
        $similar_default_js         = "tools.v( 'input.similar-default' )";
        $similar_number_js          = "tools.v( 'select#similar-number' )";
        $similar_criteria_js        = "tools.v( 'select#similar-criteria' )";
    }

    $program = array(
        'title' => __( 'Program builder' , _DEV_ ),
        'type' => array(
            'slug' => 'program',
            'instance' => array( '_box' , 'program' ),
            'context' => 'normal',
            'priority' => 'default'
        )
    );

    $attachDocs = array(
        'title' => __( 'Attached Documents' , _DEV_ ),
        'type' => array(
            'slug' => 'attachdocs',
            'instance' => array( '_box' , 'attachdocs' ),
            'context' => 'normal',
            'priority' => 'default'
        )
    );

    $map = array(
        'title' => __( 'Map' , _DEV_ ),
        'type' => array(
            'slug' => 'map',
            'instance' => array( '_box' , 'map' ),
            'context' => 'normal',
            'priority' => 'default'
        ),
        'fields' => array(
            array(
                'type' => 'cd--panel-markers',
                'content' => _map::markers( $postID )
            ),
            array(
                'type' => 'cd--map',
                'content' => _map::panel( $postID )
            ),
        )
    );

    $layout = array(
        'title' => __( 'Layout' , _DEV_ ),
        'type' => array(
            'slug' => 'layout',
            'instance' => array( '_box' , 'layout' ),
            'context' => 'side',
            'priority' => 'default'
        ),
        'fields' => array(
            'style' => array(
                'type' => 'sh--select',
                'label' => __( 'Select layout for this post' , _DEV_ ),
                'values' => array(
                    'left' => __( 'Left Sidebar' , _DEV_ ),
                    'right' => __( 'Right Sidebar' , _DEV_ ),
                    'full' => __( 'Full Width' , _DEV_ )
                ),
                'cvalue' => 'right',
                'action' => "tools.hs.select( this , { 'full' : '.layout-sidebar' } )"
            ),
            'sidebar' => array(
                'type' => 'sh--select',
                'classes' => 'layout-sidebar',
                'label' => __( 'Select sidebar for this post' , _DEV_ ),
                'values' => _sidebar::getList()
            )
        )
    );
    
    $additional = array(
        'title' => __( 'Additional Info' , _DEV_ ),
        'settings' => array(
            'type' => 'box--additional',
            'classes' => 'box-additional',
            'title' => __( 'Additional Info' , _DEV_ ),
            'content' => array(
                __( 'Fields' , _DEV_ ) => array(
                    array(
                        'type' => 'cd--code',
                        'content' => _additional::panel( $resource )
                    ),
                    
                    array( 'type' => 'cd--start-add-form' , 'content' => '<div class="additional-add-form">' ),
                    array(
                        'type' => 'stbox--text',
                        'label' => __( 'Field label' , _DEV_ ),
                        'set' => 'field-label'
                    ),
                    array(
                        'type' => 'stbox--select',
                        'label' => __( 'Field type' , _DEV_ ),
                        'set' => 'field-type',
                        'values' => array( 
                            'text' => __( 'Short text input' , _DEV_ ),
                            'textarea' => __( 'Long text input' , _DEV_ )
                        )
                    ),
                    array( 'type' => 'cd--end-add-form' , 'content' => '</div>' ),
                    
                    
                    array( 'type' => 'cd--submit' , 'content' => '<div class="addbox-submit-action">' ),
                    array( 
                        'type' => 'ln--button' ,  'value' => __( 'Add' , _DEV_ ) , 
                        'action' => "additional.r( 'add' , [ 
                            " . $resource . " ,
                            tools.v( '#field-label' ),
                            tools.v( '#field-type' ), ]);" 
                    ),
                    array( 'type' => 'ln--button' , 'value' => __( 'Cancel' , _DEV_ ) , 'action' => "field.h('.box-additional');" , 'btnType' => 'secondary' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Successfully executed' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'success hidden' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Error, try again' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'error hidden' ),
                    array( 'type' => 'cd--submit' , 'content' => '<div class="clear"></div></div>' )
                )
            )
        ),
        'type' => array(
            'slug' => 'additional',
            'instance' => array( '_box' , 'additional' ),
            'context' => 'normal',
            'priority' => 'default'
        )
    );

    $posts_settings = array(
        'title' => __( 'Posts Settings' , _DEV_ ),
        'settings' => array(
            'type' => 'box--posts-settings',
            'classes' => 'box-posts-settings',
            'title' => __( 'Posts  Settings' , _DEV_ ),
            'content' => array(
                __( 'Related Posts' , _DEV_ ) => array(
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'User related posts' , _DEV_ ),
                        'cvalue' => $similar_use,
                        'set' => 'similar-use',
                        'action' => "tools.sh.check( this , { 'yes' : '.similar-posts' } );"
                    ),
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Choose which default value (Yes or No) will be displayed for related posts on posts page' , _DEV_ ),
                        'cvalue' => $similar_default,
                        'set' => 'similar-default',
                        'classes' => 'similar-posts'
                    ),
                    array(
                        'type' => 'stbox--select',
                        'label' => __( 'Number of related posts' , _DEV_ ),
                        'values' => _tools::digit( 20 , 1 ),
                        'value' => $similar_number,
                        'set' => 'similar-number',
                        'classes' => 'similar-posts'
                    ),
                    array(
                        'type' => 'stbox--select',
                        'label' => __( 'Related posts criteria' , _DEV_ ),
                        'values' => _taxonomy::get(),
                        'value' => $similar_criteria,
                        'set' => 'similar-criteria',
                        'classes' => 'similar-posts'
                    ),
                    array( 'type' => 'cd--submit' , 'content' => '<div class="editbox-submit-action">' ),
                    array( 
                        'type' => 'ln--button' ,  'value' => __( 'Ok' , _DEV_ ) , 
                        'action' => "box.r( 'edit' , [ " . 
                             $resource . ",
                            'posts-settings',
                              $similar_use_js , " . 
                            " $similar_default_js , " .
                            " $similar_number_js , " .
                            " $similar_criteria_js , " .
                        
                            " tools.v( 'input.likes-use' ), " .
                        
                            " tools.v( 'input.social-use' ), " .
                            " tools.v( 'input.social-default' ), " .
                            
                            " tools.v( 'input.author-box-use' ), " .
                            " tools.v( 'input.author-box' ), " .
                            " tools.v( 'input.source-use' ), " .
                            " tools.v( 'input.archive-use' ), " .
                            " tools.v( 'input.archive' ), " .
                            " tools.v( 'input.meta-use' ), " .
                            " tools.v( 'input.meta' )
                        ]);"
                    ),
                    array( 'type' => 'ln--button' , 'value' => __( 'Cancel' , _DEV_ ) , 'action' => "field.h('.box-posts-settings');" , 'btnType' => 'secondary' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Successfully modified' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'success hidden' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Error, try again' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'error hidden' ),
                    array( 'type' => 'cd--submit' , 'content' => '<div class="clear"></div></div>' )
                ),
                __( 'Likes Settings' , _DEV_ ) => array(
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Use Likes for this type of custom posts' , _DEV_ ),
                        'value' => $likes_use,
                        'set' => 'likes-use',
                        'action' => "tools.sh.check( this , { 'yes' : '.use-likes-settings' } );"
                    ),
                    array(
                        'type' => 'stbox--digit',
                        'label' => __( 'Minimum number of Likes to set Featured' , _DEV_ ),
                        'value' => $likes_limit,
                        'set' => 'likes-limit',
                    ),
                    
                    array( 'type' => 'cd--result' , 'content' => '<div><span class="btn result reset"></span></div>' ),
                    array(
                        'type' => 'stbox--button',
                        'value' => __( 'Reset Likes limit' , _DEV_ ),
                        'action' => 'likes.reset( ' . $resource . ' , tools.v(\'#likes-limit\') , 1 );',
                        'hint' => __( 'Set minimum number of Likes to change post into Featured' , _DEV_ )
                    ),
                    
                    array( 'type' => 'cd--result' , 'content' => '<div><span class="btn result generate"></span></div>' ),
                    array(
                        'type' => 'stbox--button',
                        'value' => __( 'Generate Likes' , _DEV_ ),
                        'action' => 'likes.generate( ' . $resource . ' , 1 );',
                        'hint' => __( 'Generate random number of Likes for posts.' , _DEV_ ) . '<p><span style="color:#990000">' . __(  'WARNING! This will reset all current Likes for this custom post type.' , _DEV_ ) . '</span></p>'
                    ),
                    
                    array( 'type' => 'cd--result' , 'content' => '<div><span class="btn result remove"></span></div>' ),
                    array(
                        'type' => 'stbox--button',
                        'value' => __( 'Remove Likes' , _DEV_ ),
                        'action' => "(function(){ if( confirm( '" . __( 'Are you sure you want to remove all Likes for this custom posts?' , _DEV_ ) . "' ) ){ likes.remove( " . $resource . " , 1 ); }})()",
                        'hint' => __( 'Remove all Likes for this costom posts type' , _DEV_ )
                    ),
                    array( 'type' => 'cd--submit' , 'content' => '<div class="editbox-submit-action">' ),
                    array( 
                        'type' => 'ln--button' ,  'value' => __( 'Ok' , _DEV_ ) , 
                        'action' => "box.r( 'edit' , [ " . 
                             $resource . ",
                            'posts-settings',
                              $similar_use_js , " . 
                            " $similar_default_js , " .
                            " $similar_number_js , " .
                            " $similar_criteria_js , " .
                        
                            " tools.v( 'input.likes-use' ), " .
                        
                            " tools.v( 'input.social-use' ), " .
                            " tools.v( 'input.social-default' ), " .
                            
                            " tools.v( 'input.author-box-use' ), " .
                            " tools.v( 'input.author-box' ), " .
                            " tools.v( 'input.source-use' ), " .
                            " tools.v( 'input.archive-use' ), " .
                            " tools.v( 'input.archive' ), " .
                            " tools.v( 'input.meta-use' ), " .
                            " tools.v( 'input.meta' )
                        ]);"
                    ),
                    array( 'type' => 'ln--button' , 'value' => __( 'Cancel' , _DEV_ ) , 'action' => "field.h('.box-posts-settings');" , 'btnType' => 'secondary' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Successfully modified' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'success hidden' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Error, try again' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'error hidden' ),
                    array( 'type' => 'cd--submit' , 'content' => '<div class="clear"></div></div>' )
                    
                    
                ),
                __( 'Social Settings' , _DEV_ ) => array(
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Use social sharing for this custom post' , _DEV_ ),
                        'value' => $social_use,
                        'set' => 'social-use',
                        'action' => "tools.sh.check( this , { 'yes' : '.social-options' } )"
                    ),
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Choose which default value (Yes or No) will be displayed for social sharing on posts' , _DEV_ ),
                        'value' => $social_default,
                        'set' => 'social-default',
                    ),
                    
                    array( 'type' => 'cd--submit' , 'content' => '<div class="editbox-submit-action">' ),
                    array( 
                        'type' => 'ln--button' ,  'value' => __( 'Ok' , _DEV_ ) , 
                        'action' => "box.r( 'edit' , [ " . 
                             $resource . ",
                            'posts-settings',
                              $similar_use_js , " . 
                            " $similar_default_js , " .
                            " $similar_number_js , " .
                            " $similar_criteria_js , " .
                        
                            " tools.v( 'input.likes-use' ), " .
                        
                            " tools.v( 'input.social-use' ), " .
                            " tools.v( 'input.social-default' ), " .
                            
                            " tools.v( 'input.author-box-use' ), " .
                            " tools.v( 'input.author-box' ), " .
                            " tools.v( 'input.source-use' ), " .
                            " tools.v( 'input.archive-use' ), " .
                            " tools.v( 'input.archive' ), " .
                            " tools.v( 'input.meta-use' ), " .
                            " tools.v( 'input.meta' )
                        ]);"
                    ),
                    array( 'type' => 'ln--button' , 'value' => __( 'Cancel' , _DEV_ ) , 'action' => "field.h('.box-posts-settings');" , 'btnType' => 'secondary' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Successfully modified' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'success hidden' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Error, try again' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'error hidden' ),
                    array( 'type' => 'cd--submit' , 'content' => '<div class="clear"></div></div>' )
                ),
                __( 'Other Settings' , _DEV_ ) => array(
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Use Author Box for this custom post' , _DEV_ ),
                        'value' => $author_box_use,
                        'set' => 'author-box-use',
						'hint' => __( 'This will enable the author box on posts. Edit user description in Users -> Your Profile'  , _DEV_ ),
                        'action' => "tools.sh.check( this , { 'yes' : '.author-box-options' } )"
                    ),
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Choose which default value (Yes or No) will be displayed for author box' , _DEV_ ),
                        'value' => $author_box,
                        'set' => 'author-box'
                    ),
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Use source for this custom post' , _DEV_ ),
                        'value' => $source_use,
                        'set' => 'source-use'
                    ),
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Use archiving for this custom post' , _DEV_ ),
                        'value' => $archive_use,
                        'set' => 'archive-use',
                        'action' => "tools.sh.check( this , { 'yes' : '.archive-options' } )"
                    ),
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Choose which default value (Yes or No) will be displayed for post archiving' , _DEV_ ),
                        'value' => $archive,
                        'set' => 'archive'
                    ),
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Use meta for this custom post' , _DEV_ ),
                        'value' => $meta_use,
                        'set' => 'meta-use',
                        'action' => "tools.sh.check( this , { 'yes' : '.meta-options' } )"
                    ),
                    array(
                        'type' => 'stbox--logic-radio',
                        'label' => __( 'Choose which default value (Yes or No) will be displayed for post meta' , _DEV_ ),
                        'value' => $meta,
                        'set' => 'meta',
                    ),
                    
                    array( 'type' => 'cd--submit' , 'content' => '<div class="editbox-submit-action">' ),
                    array( 
                        'type' => 'ln--button' ,  'value' => __( 'Ok' , _DEV_ ) , 
                        'action' => "box.r( 'edit' , [ " . 
                             $resource . ",
                            'posts-settings',
                              $similar_use_js , " . 
                            " $similar_default_js , " .
                            " $similar_number_js , " .
                            " $similar_criteria_js , " .
                        
                            " tools.v( 'input.likes-use' ), " .
                        
                            " tools.v( 'input.social-use' ), " .
                            " tools.v( 'input.social-default' ), " .
                            
                            " tools.v( 'input.author-box-use' ), " .
                            " tools.v( 'input.author-box' ), " .
                            " tools.v( 'input.source-use' ), " .
                            " tools.v( 'input.archive-use' ), " .
                            " tools.v( 'input.archive' ), " .
                            " tools.v( 'input.meta-use' ), " .
                            " tools.v( 'input.meta' )
                        ]);"
                    ),
                    array( 'type' => 'ln--button' , 'value' => __( 'Cancel' , _DEV_ ) , 'action' => "field.h('.box-posts-settings');" , 'btnType' => 'secondary' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Successfully modified' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'success hidden' ),
                    array( 'type' => 'ln--mssg' , 'value' => __( 'Error, try again' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'error hidden' ),
                    array( 'type' => 'cd--submit' , 'content' => '<div class="clear"></div></div>' )
                )
            )
        ),
        'type' => array(
            'slug' => 'posts-settings',
            'instance' => array( '_box' , 'posts_settings' ),
            'context' => 'normal',
            'priority' => 'high'
        ),
        'fields' => array(
            
            'similar' => array( 
                'type' => 'st--logic-radio',
                'label' => __( 'Show related posts' , _DEV_ ),
                'hint' => __( 'Show related posts on this post' , _DEV_ ),
                'cvalue' => $similar_default,
            ),
            'likes' => array(
                'type' => 'st--logic-radio',
                'label' => __( 'Show post Likes' , _DEV_ ),
                'hint' => __( 'Show post likes on this post'  , _DEV_ ),
                'cvalue' => 'yes'
            ),
            'social' => array( 
                'type' => 'st--logic-radio',
                'label' => __( 'Show social sharing on this post' , _DEV_ ),
                'cvalue' => $social_default ,
            ),
            
            'author-box' => array(
                'type' => 'st--logic-radio',
                'label' => __( 'Show author box on this post'  , _DEV_ ),
                'cvalue' => $author_box
            ),
            'source' => array( 
                'type' => 'st--text',
                'label' => __( 'Post source' , _DEV_ ),
                'hint' => __(  'Example: http://cosmothemes.com' ,  _DEV_ )
            ),
            
            'meta' => array( 
                'type' => 'st--logic-radio',
                'label' => __( 'Show post meta' , _DEV_ ),
                'hint' => __( 'Show post meta on this post' , _DEV_ ),
                'cvalue' => $meta
            ),
            'background-image' => array(
                'type' => 'st--upload',
                'label' => __( 'Upload or choose image from media library' , _DEV_ ),
                'hint' => __( 'This will be the background image for this post' , _DEV_ ),
                'btnType' => 'secondary'
            ),
            'background-position' => array(
                'type' => 'st--select',
                'label' => __( 'Image background position' , _DEV_ ),
                'values' => array(
                    'left' => __( 'Left' , _DEV_ ),
                    'center' => __( 'Center' , _DEV_ ),
                    'right' => __( 'Right' , _DEV_ )
                )
            ),
            'background-repeat' => array(
                'type' => 'st--select',
                'label' => __( 'Image background repeat' , _DEV_ ),
                'values' => array(
                    'no-repeat' => __( 'No Repeat' , _DEV_ ),
                    'repeat' => __( 'Tile' , _DEV_ ),
                    'repeat-x' => __( 'Tile Horizontally' , _DEV_ ),
                    'repeat-y' => __( 'Tile Vertically' , _DEV_ )
                )
            ),
            'background-attachment-type' => array(
                'type' => 'st--select',
                'label' => __( 'Image background attachment type' , _DEV_ ),
                'values' => array(
                    'scroll' => __( 'Scroll' , _DEV_ ),
                    'fixed' => __( 'Fixed' , _DEV_ )
                )
            ),
            'background-color' => array(
                'type' => 'st--color-picker',
                'label' => __( 'Set background color for this post' , _DEV_ )
            )
        )
    );
    
    $slideshow = array(
        'title' => __( 'Additional slideshow items' , _DEV_ ),
        'nopanel' => true,
        'type' => array(
            'slug' => 'slideshow',
            'instance' => array( '_box' , 'slideshow' ),
            'context' => 'normal',
            'priority' => 'default'
        )
    );
    
    $resources = _core::method( '_resources' , 'get' );
    $type = array( 'none' => __( 'Manual add' , _DEV_ ) );
    
    if( !empty( $resources ) ){
        foreach( $resources as $res ){
            if( !isset( $res[ 'noshcode' ] ) ){
                $type[ $res[ 'slug' ] ] = $res[ 'stitle' ];
            }
        }
    }
    
    if( _core::method( $postID , 'sl-settings' , 'type' ) == 'none' ){
        $manual_classes = 'add-manual-hint';
        $automat_classes = 'add-automat-hint hidden';
    }else{
        $manual_classes = 'add-manual-hint hidden';
        $automat_classes = 'add-automat-hint';
    }
    
    $sl_settings = array(
        'title' => __( 'Slideshow settings' , _DEV_ ),
        'nopanel' => true,
        'type' => array(
            'slug' => 'sl-settings',
            'instance' => array( '_box' , 'sl_settings' ),
            'context' => 'normal',
            'priority' => 'default'
        ),
        'fields' => array(
            'type' => array(
                'type' => 'st--select',
                'label' => __( 'Select posts type for this slideshow' , _DEV_ ),
                'hint' => __( '' , _DEV_ ),
                'values' => $type,
                'action'=>"tools.sh.select(this,{ 'none':'.add-manual-hint', 'else' : '.add-automat-hint'})"
            ),
            'hint-manual' => array(
                'type' => 'st--hint',
                'value' => __( 'Select this value if you wish to populate your slideshow with items other than your posts. Use Additional slideshow items box below.' , _DEV_ ),
                'classes' => $manual_classes
            ),
            'hint-automat' => array(
                'type' => 'st--hint',
                'value' => __( 'Select this value if you wish to automatically populate your slideshow. Use Additional slideshow items box below to add additional images.' , _DEV_ ),
                'classes' => $automat_classes
            ),        
            'random' => array(
                'type' => 'st--logic-radio',
                'label' => __( 'Show slideshow items randomly' , _DEV_ ),
                'classes' => $automat_classes
            )
        )
    );

	$format = array(
        'title' => __( 'Format' , _DEV_ ),
        'nopanel' => true,
        'type' => array(
            'slug' => 'format',
            'instance' => array( '_box' , 'format' ),
            'context' => 'normal',
            'priority' => 'default'
        ),
		'fields' => array(
			'init' => array(
				'type'=>"no--form-upload-init"
			),
			'type' => array(
				'type' => 'st--select',
				'label' => __( 'Select post format ' , _DEV_ ),
				'values' => array(
					'standard' => __('Standard'	, _DEV_ ),
					'image' => __( 'Image' , _DEV_ ),
					'video' => __( 'Video', _DEV_ ),
					'audio' => __( 'Audio', _DEV_ ),
					'link' => __( 'Attachment', _DEV_ )
				),
				'action'=>"tools.sh.select(this,{'image':'.image-uploader', 'video':'.video-uploader','audio':'.audio-uploader','link':'.file-uploader'})"
			),
			'image-uploader'=>array(
				'type' => 'ni--form-upload',
				'format' => 'image',
				'post_id' => $postID
			),
			'video-uploader'=>array(
				'type' => 'ni--form-upload',
				'format' => 'video',
				'post_id' => $postID
			),
			'audio-uploader'=>array(
				'type' => 'ni--form-upload',
				'format' => 'audio',
				'post_id' => $postID
			),
			'file-uploader'=>array(
				'type' => 'ni--form-upload',
				'format' => 'link',
				'post_id' => $postID
			)
		)
    );
    
    _box::$boxes['general']['sl-settings']      = $sl_settings;
    _box::$boxes['general']['slideshow']        = $slideshow;
    _box::$boxes['general']['posts-settings']   = $posts_settings;
    _box::$boxes['general']['attachdocs']       = $attachDocs;
    _box::$boxes['general']['map']              = $map;
    _box::$boxes['general']['program']          = $program;
    /*_box::$boxes['general']['register']         = $register;*/
    _box::$boxes['general']['layout']           = $layout;
    _box::$boxes['general']['additional']       = $additional;
	_box::$boxes['general']['format']			= $format;
/*	_box::$boxes['general']['paid_content']		= $paid_content;*/
    
    /*_box::$boxes['event']['register']           = $register;*/
    _box::$boxes['event']['program']            = $program;
    _box::$boxes['event']['layout']             = $layout;
    _box::$boxes['event']['additional']         = $additional;
    _box::$boxes['event']['posts-settings']     = $posts_settings;
    
    _box::$boxes['paper']['posts-settings']     = $posts_settings;
    _box::$boxes['paper']['attachdocs']         = $attachDocs;
    _box::$boxes['paper']['layout']             = $layout;
    _box::$boxes['paper']['additional']         = $additional;
    
    _box::$boxes['people']['layout']            = $layout;
    _box::$boxes['people']['additional']        = $additional;
    _box::$boxes['people']['posts-settings']    = $posts_settings;
    
    _box::$boxes['location']['posts-settings']  = $posts_settings;
    _box::$boxes['location']['map']             = $map;
    _box::$boxes['location']['layout']          = $layout;
    _box::$boxes['location']['additional']      = $additional;
?>