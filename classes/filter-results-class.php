<?php 

class filterResults {

    // In a real use case, we would have an alternative function that would call on an API, in this instance, we'll link back to the provided JSON data.
    public static $initJsonLocation = '././data/properties.json';

    public static function initialise(){

        // Format into an assoc array for further pruning - please note I will do this programically.
        $dataJSON = file_get_contents(self::$initJsonLocation);
        $dataArray = json_decode($dataJSON, true);
        $dataCollection = $dataArray['Collection'];

        // Remove any 'Lettings' from the assoc array
        foreach( $dataCollection as $k => $singleProperty ) {
            $roleTypeArray = $singleProperty['RoleType'];
            if ( $roleTypeArray['DisplayName'] == 'Letting' ) {
                unset($dataCollection[$k]);
            }
            // Lots of records in the database with important fields, remove any with incomplete descriptions
            if ( !isset($singleProperty['Descriptions']) ) {
                unset($dataCollection[$k]);
            }
        }

        // Result Container
        echo '<div class="results_container flex_wrap" id="result">';

        // Collection Output
        if ( is_array($dataCollection) ) {
            foreach ( $dataCollection as $singleProperty ) {
                $property = new property($singleProperty);
                print_r($property);
            }
        }

        // Close Container
        echo '</div>';

    } 



}