<?php 
require_once '../classes/filter-results-class.php';
require_once '../classes/property-class.php';
require_once '../classes/filter-update-before-class.php';
$relativeJSONPath = '../data/properties.json';
// Filter the POST data that we recieve from our AJAX call
filterResults::trimData($_POST, $relativeJSONPath);

