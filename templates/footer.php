<?php 
    $footerLogos = array(
        array( 'image' => '/../assets/images/logo-onthemarket.png', 'url' => '#', 'alt' => 'On The Market Logo'),
        array( 'image' => '/../assets/images/logo-zoopla.png', 'url' => '#', 'alt' => 'Zoopla Logo'),
        array( 'image' => '/../assets/images/logo-rightmove.png', 'url' => '#', 'alt' => 'Rightmove Logo'),
    );

    echo '<section class="wrapper footer_logos"><div class="cqc flex_wrap">';
    foreach ( $footerLogos as $footerLogo ) {
        echo '<div class="footer_logo"><a target="_blank" href="' . $footerLogo['url'] . '"><img src="' . $footerLogo['image'] . '" alt="' . $footerLogo['alt'] . '"/></a></div>';
    }
    echo '</div></section>';

    echo '<div class="wrapper footer"></div>';

?>

</body>
</html>