<?php 
// Include Static Objects
include('./classes/navigation-class.php');
include('./classes/filter-class.php');
include('./classes/filter-before-class.php');
include('./classes/filter-results-class.php');
include('./classes/filter-update-before-class.php');

spl_autoload_register(function ($class_name) {
    include './classes/' . $class_name . '-class.php';
});
