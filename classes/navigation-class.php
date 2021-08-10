<?php

/*
*   Static Object for the navigational bar, in this instance to render the logo with apache URL href.
*/

class navigation {

    // Static Properties
    public static $brandingPath = '././assets/svgs/logo.svg';
    public static $homeURL = 'http://localhost:8001';

    // Static Methods
    public static function render() {
        echo '<section class="wrapper"><div class="cqc flex_wrap"><div class="logo"><a href="' . self::$homeURL . '">' . file_get_contents(self::$brandingPath) . '</a></div></div></section>';
    }

}

