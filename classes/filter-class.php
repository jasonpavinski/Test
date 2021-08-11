<?php

/*
*   Filter Object to handle the HTML form, which will be controlled with AJAX
*/

class ajaxFilter {
    public static $radius = array(
        array( 'name' => '1 Mile', 'value' => 1 ),
        array( 'name' => '5 Miles', 'value' => 5 ),
        array( 'name' => '10 Miles', 'value' => 10 ),
        array( 'name' => '20 Miles', 'value' => 20 ),
        array( 'name' => '50 Miles', 'value' => 50 ),
        array( 'name' => '100 Miles', 'value' => 100 ),
    );

    public static $bedrooms = array(
        array( 'name' => 'No Minimum', 'value' => 0 ),
        array( 'name' => '1 Bedroom', 'value' => 1 ),
        array( 'name' => '2 Bedrooms', 'value' => 2 ),
        array( 'name' => '3 Bedrooms', 'value' => 3 ),
        array( 'name' => '4 Bedrooms', 'value' => 4 ),
        array( 'name' => '5 Bedrooms', 'value' => 5 ),
    );

    public static $price = array(
        array( 'name' => 'No Maximum', 'value' => 0 ),
        array( 'name' => '£50,000', 'value' => 50000 ),
        array( 'name' => '£100,000', 'value' => 100000 ),
        array( 'name' => '£150,000', 'value' => 150000 ),
        array( 'name' => '£200,000', 'value' => 200000 ),
        array( 'name' => '£250,000', 'value' => 250000 ),
        array( 'name' => '£500,000', 'value' => 500000 ),
        array( 'name' => '£800,000', 'value' => 800000 ),
        array( 'name' => '£1,000,000', 'value' => 1000000 ),
        array( 'name' => '£1,500,000', 'value' => 1500000 ),
        array( 'name' => '£2,000,000', 'value' => 2000000 ),
    );

    public static $defaultSelect = 'class="defaultSelected"';

    public static $searchIcon = '././assets/svgs/icon-search.svg';

    public static function renderForm() {
        // Container HTML setup
        echo '<section class="wrapper"><div class="cqc"><div class="ajax_form">';

        // Form Start
        echo '<form id="__ajax_filter" method="POST" name="propFilter" action="/includes/ajax-filter.php">';

        // Search Input
        echo '<div class="__a_form_i __a_form_search_text"> <input type="text" name="search_input" class="search_input_text autosubmit" placeholder="SEARCH AGAIN"/><span class="search_icon"> ' . file_get_contents(self::$searchIcon) . '</span></div>';

        // Location Input
        echo '<div class="__a_form_i __a_form_wrap"><span>POSTCODE OR TOWN</span><input class="autosubmit text__" type="text" name="location" placeholder="e.g LS1 2ED"></div>';

        // Radius Input
        echo '<div class="__a_form_i __a_form_wrap"><span>SEARCH RADIUS</span><select class="autosubmit select__" name="radius">';
        if ( is_array(self::$radius) ) {
            foreach (self::$radius as $k => $option) {
                if ( $k == 0 ) { $class = self::$defaultSelect; } else { $class = NULL; }
                echo '<option ' . $class . ' value="' . $option['value'] . '"><span>' . $option['name'] . '</span></option>';
            }
        }
        echo '</select></div>';

        // Minimum Bedrooms
        echo '<div class="__a_form_i __a_form_wrap"><span>MIN. BEDROOMS</span><select class="autosubmit select__" name="bedrooms">';
        if ( is_array(self::$bedrooms) ) {
            foreach (self::$bedrooms as $k => $option) {
                if ( $k == 0 ) { $class = self::$defaultSelect; } else { $class = NULL; }
                echo '<option ' . $class . ' value="' . $option['value'] . '"><span>' . $option['name'] . '</span></option>';
            }
        } 
        echo '</select></div>';

        // Max Price
        echo '<div class="__a_form_i __a_form_wrap"><span>MAX. PRICE</span><select class="autosubmit select__" name="price">';
        if ( is_array(self::$price) ) {
            foreach (self::$price as $k => $option) {
                if ( $k == 0 ) { $class = self::$defaultSelect; } else { $class = NULL; }
                echo '<option ' . $class . ' value="' . $option['value'] . '"><span>' . $option['name'] . '</span></option>';
            }
        } 
        echo '</select></div>';

        // Hidden Order Input
        echo '<input type="checkbox" name="order_hidden" class="filter_order" id="order-newest" checked value="newest">';
        echo '<input type="checkbox" name="order_hidden" class="filter_order" id="order-price-asc" value="priceASC">';
        echo '<input type="checkbox" name="order_hidden" class="filter_order" id="order-price-desc" value="priceDESC">';

        // Container End
        echo '</form></div></div></div>';
    }
}