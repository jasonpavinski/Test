<?php 
// I would usually take this variable from the server's or CMS' global vars, in this instance, we'll just pass it to the title's object

// Generate required objects
$pageTitleString = 'Search Results';
$pageTitle = new pageTitle($pageTitleString);

// render the page
echo '<div class="body_inner">';
$pageTitle->render();
ajaxFilter::renderForm();
filterBefore::render();
filterResults::initialise();



echo '</div>';
