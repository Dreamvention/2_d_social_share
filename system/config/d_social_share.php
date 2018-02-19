<?php
$_['d_social_share'] = array(
    "status" => "1",
    "buttons" => array(),
    "design" => array(
        'size' => 'medium',
        'shadow' => 'outer_shadow',//set class
        'border_radius'=>'no',
        'border_radius_set' => array(
            'yes' => 'border-radius:2px',//set css value
            'no' => 'border-radius:0',
            'round' => 'border-radius:100%;',
            'custom' => ''
        ),
        'width'=>'45px',//uses when brdradius set
        'sizes' => array(
            'medium' => array(
                'padding' => '5px 10px',
                'font-size'=>'25px'
            ),
            'small' => array(
                'padding' => '8px',
                'font-size'=>'10px'
            ),
            'nano' => array(
                'padding' => '5px',
                'font-size'=>'5px'
            )
        ),
        'text_sizes' => array(
            'large' => 'text_large',
            'huge' => 'text_huge',
            'medium' => 'text_medium',
            'small' => 'text_small',
            'nano' => 'text_nano'
        ),
        'type'=>'floating',
        'count_position'=>'right'
    ),
    "count_share" => array(
        'enable' => false
    ),
    'popup' => 'popup',
    'popup_size' => array(
        'width' => '200px',
        'height' => '300px'
    ),
);
?>