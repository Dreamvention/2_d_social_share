<?php
$_['d_social_share'] = array(
    "status" => "-",
    'cdn_lib' => false,
    'custom_url' => 'http://google.com',
    'id_placement' => '',
    'native' => false,
    "buttons" => array(),
    "design" => array(
        'size' => 'medium',
        'sizes' => array(
            'medium' => array(
                'padding' => '5px 10px',
                'font-size' => '25px'
            ),
            'small' => array(
                'padding' => '8px',
                'font-size' => '10px'
            ),
            'nano' => array(
                'padding' => '5px',
                'font-size' => '5px'
            )
        ),
        'text_sizes' => array(
            'large' => 'text_large',
            'huge' => 'text_huge',
            'medium' => 'text_medium',
            'small' => 'text_small',
            'nano' => 'text_nano'
        ),
        'style' => 'classic',
        'rounded' => true,
        'styles' => array(
            'flat',
            'classic',
            'minimal',
            'plain',
            'custom' => array(
                'shadow' => 'outer_shadow',//set class
                'border_radius' => 'no',
                'border_radius_set' => array(
                    'yes' => 'border-radius:2px',//set css value
                    'no' => 'border-radius:0',
                    'round' => 'border-radius:100%;',
                    'custom' => ''
                ),
                'width' => '45px',//uses when brdradius set
                'type' => 'floating',
                'count_position' => 'right'
            ),
        ),
    ),
    'share' => array(
        'text_to_share' => "Text to share",
        'showLabel' => false,
        'showCount' => true,
        'shareIn' => 'popup',
        'breakpoints' => array(
            'smallScreenWidth' => 640,
            'largeScreenWidth' => 1024
        )
    ),
    'popup_size' => array(
        'width' => '200px',
        'height' => '300px'
    ),
);
// admin http://joxi.ru/RmzbE7zh0B35Mm
// twitter http://opensharecount.com
?>