<?php
_resources::$resources = array(
    array(
        'nopanel' => true,
        'noregister' => true,
        'parent' => -1,
        'stitle' => 'Post',
        'ptitle' => 'Posts',
        'type' => 'general',
        'slug' => 'post',
        'boxes' => array(
            'posts-settings' => array(
                'similar-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'similar' ),
                'similar-default' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'similar' ),
                'similar-number' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'similar-number' ),
                'similar-criteria' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'similar-criteria' ),
                'similar-view' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'similar-view' ),

                'likes-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'likes' , 'use' ),
                'likes-limit' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'likes' , 'limit' ),

                'social-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'social' ),
                'social-single-default' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'social' ),
                'social-list-view' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'social' ),

                'author-box-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'author-box' ),
                'author-box' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'author-box' ),
                'source-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'source' ),
                'archive-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'archive' ),
                'archive' => 'no',
                'meta-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'posts' , 'meta' ),
                'meta' => 'yes',
            ),
            'layout' => array(
                'style' => _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , 'single'  ),
                'sidebar' => _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , 'single_sidebar'  )
            ),
            'format' => array(
            )
        ),
        'taxonomy' => array(
			array(
				'hierarchical' => 'hierarchical',
				'slug' => 'category',
				'ptitle' => 'Categories'
			),
			array(
				'hierarchical' => '',
				'slug' => 'post_tag',
				'ptitle' => 'Tags'
			)
		)
    ),
    array(
        'nopanel' => true,
        'noregister' => true,
        'parent' => -1,
        'stitle' => 'Page',
        'ptitle' => 'Pages',
        'type' => 'general',
        'slug' => 'page',
        'boxes' => array(
            'posts-settings' => array(
                'social-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'pages' , 'social' ),
                'social-single-default' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'pages' , 'social' ),
                'social-list-view' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'pages' , 'social' ),
                'likes-use' => 'no',
                'author-box-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'pages' , 'author-box' ),
                'author-box' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'pages' , 'author-box' ),
                'source-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'pages' , 'source' ),
                'meta-use' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'pages' , 'meta' ),
                'meta' => 'yes',
            ),
            'layout' => array(
                'style' => _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , 'page'  ),
                'sidebar' => _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , 'page_sidebar'  )
            )
        ),
    )    
);
?>