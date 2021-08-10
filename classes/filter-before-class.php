<?php 

class filterBefore {

    public static $filterOrder = array(
        array('name' => 'NEWEST', 'id'=> 'order-newest', ),
        array('name' => 'PRICE ASC', 'id'=> 'order-price-asc', ),
        array('name' => 'PRICE DESC', 'id'=> 'order-price-desc', ),
    );

    public static function render(){
        echo '<section class="wrapper"><div class="cqc"><div class="filter_results_container"><div class="results_before flex_wrap">';
        echo '<div class="__bf_left"><span><span class="__bf_num"></span> Properties for sale</span></div>';
        echo '<div class="__bf_right"><span>ORDER BY</span><select id="filter_order_select">';
        if ( is_array(self::$filterOrder) ){
            foreach ( self::$filterOrder as $option ) {
                echo '<option value="' . $option['id'] . '">' . $option['name'] . '</option>';
            }
        }
        echo '</select></div></div>';
    } 
}