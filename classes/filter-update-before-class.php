<?php

class updateCount{
    public static function doTheThing(int $int){
        $jQuery = '<script>$(document).ready(function () { $(\'.__bf_num\').html(' . $int . ');});</script>';
        echo $jQuery;
    }
}