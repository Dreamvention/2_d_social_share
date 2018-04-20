<?php
$_['d_social_share'] = array(
    "status"     => "1",
    'custom_url' => 'google.com',// may be
    "buttons"    => array(),
    "design"     => array(
        'size'             => 'medium',
        'sizes'            => array(
            'extra_small' => array(
                'padding'   => '.4rem',
                'font-size' => '1.1em'
            ),
            'small'       => array(
                'padding'   => '.7rem',
                'font-size' => '1.2em'
            ),
            'medium'      => array(
                'padding'   => '1rem',
                'font-size' => '1.8rem'
            ),
            'large'       => array(
                'padding'   => '1.2rem',
                'font-size' => '2rem'
            ),
            'huge'        => array(
                'padding'   => '1.5rem',
                'font-size' => '2.5rem'
            ),
//            'custom' => array()
        ),
        'placement'        => 'fixed',
        'placements'       => array('module', 'fixed', 'product'),
        'fixed'            => 'right',
        'fixed_placement'  => array('bottom', 'left', 'right'),
        'rounded'          => true,
        'style'            => 'flat',
        'styles'           => array(
            'flat'    => array(),
            'classic' => array(),
            'minimal' => array(),
            'plain'   => array(),
//            'custom' => array(
//                'jssocials-shares' => '',
//                'jssocials-share' => '',
//                'jssocials-share-count-box' => '',
//                'jssocials-share-no-count' => ''
//            ),
        ),
        'animation'        => 'pulse',
        'animation_type'   => 'hover',
        'animations_types' => array(
            'hover',
            'click',
            'none',
        ),
        'animations'       => array(
            'none',
            'slideInUp',
            'pulse',
            'tada',
            'jello',
            'fadeIn',
            'fadeInUp',
            'bounce',
            'bounceIn',
            'zoomIn',
            'zoomInDown',
            'zoomInUp'
        ),
    ),
    'config'     => array(
        'text_to_share' => array(1 => "Text to share"),
        'showLabel'     => false,
        'showCount'     => true,
        'shareIn'       => 'popup',
        'breakpoints'   => array(
            'smallScreenWidth' => 640,
            'largeScreenWidth' => 1024
        ),
        'shareIns'      => array('blank', 'popup', 'self'),
        'popup_size'    => array(
            'width'  => '200px',
            'height' => '300px'
        ),
    ),

);
// admin http://joxi.ru/RmzbE7zh0B35Mm
// twitter http://opensharecount.com
?>