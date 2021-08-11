<?php

/*
* We like nice, quietly formatted indexes
*/

// Includes
include('includes/autoloader.php');

// Initialisation
include('templates/head.php');
navigation::render();
navigation::applyBackground();
include('templates/view.php');
include('templates/footer.php');

?>
<script>
  AOS.init();
</script>


