<?php

/*
*   Static Object for the navigational bar, in this instance to render the logo with apache URL href.
*/

class navigation {

    public static $brandingPath = '././assets/images/logo.png';
    public static $homeURL = 'http://localhost:8001';

    public static function render() {
        echo '<section class="wrapper"><div class="cqc flex_wrap"><div class="logo"><a href="' . self::$homeURL . '"><img src="' . self::$brandingPath . '" alt="iglu Estates & Lettings"/></a></div></div></section>';
    }

    public static function applyBackground(){
        echo '<div data-aos="fade-down" data-aos-duration="1500" class="background_gradient"></div>';
    }



}

