<?php
$_['d_social_share'] = array(
    "status" => "1",
    'custom_url' => '',// may be
    "buttons" => array(),
    "design" => array(
        'size' => 'medium',
        'sizes' => array(
            'extra_small' => array(
                'padding' => '.4rem',
                'font-size' => '1.2em'
            ),
            'small' => array(
                'padding' => '.6rem',
                'font-size' => '1.6em'
            ),
            'medium' => array(
                'padding' => '.7rem',
                'font-size' => '2rem'
            ),
            'large' => array(
                'padding' => '1rem',
                'font-size' => '1.5rem'
            ),
            'huge' => array(
                'padding' => '2rem',
                'font-size' => '2.5rem'
            ),
            'custom'=>array()
        ),
        'placement' => 'normal',
        'placements' => array('normal', 'bottom', 'left', 'right'),
        'rounded' => true,
        'style' => 'classic',
        'styles' => array(
            'flat',
            'classic',
            'minimal',
            'plain',
            'custom' => array(
                'jssocials-shares'=>'',
                'jssocials-share'=>'',
                'jssocials-share-count-box'=>'',
                'jssocials-share-no-count'=>''
            ),
        ),
    ),
    'config' => array(
        'text_to_share' => "Text to share",
        'showLabel' => false,
        'showCount' => true,
        'shareIn' => 'popup',
        'breakpoints' => array(
            'smallScreenWidth' => 640,
            'largeScreenWidth' => 1024
        ),
        'popup_size' => array(
            'width' => '200px',
            'height' => '300px'
        ),
    ),

);
// admin http://joxi.ru/RmzbE7zh0B35Mm
// twitter http://opensharecount.com
?>