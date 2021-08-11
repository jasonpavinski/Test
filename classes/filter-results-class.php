<?php 

class filterResults {

    // In a real use case, we would have an alternative function that would call on an API, in this instance, we'll link back to the provided JSON data.
    public static $initJsonLocation = '././data/properties.json';
    public static $googleMapsApi = 'AIzaSyC3qcHAQ5zr2mt_Zux_nLSoryBNo1zpIN4';

    public static function initialise(){

        // Format into an assoc array for further pruning - please note I will do this programically.
        $dataJSON = file_get_contents(self::$initJsonLocation);
        $dataArray = json_decode($dataJSON, true);
        $dataCollection = $dataArray['Collection'];

        // Result Container
        echo '<div class="results_container flex_wrap" id="results">';

        $dataCollection = self::removeBadData($dataCollection);

        // Collection Output
        if ( is_array($dataCollection) ) {
            foreach ( $dataCollection as $singleProperty ) {
                $property = new property($singleProperty);
                $property->renderProperty();
            }
        }

        // Close Container
        echo '</div></div></section>';

        

        // Output number of properties to the top.
        $count = count($dataCollection);
        updateCount::doTheThing($count);
    } 

    // Remove any Lettings or incomplete any properties with incomplete data
    public static function removeBadData(array $array){
        foreach( $array as $k => $singleProperty ) {
            $roleTypeArray = $singleProperty['RoleType'];
            if ( $roleTypeArray['DisplayName'] == 'Letting' ) {
                unset($array[$k]);
            }
            if ( !isset($singleProperty['Descriptions']) ) {
                unset($array[$k]);
            }
        }
        return $array;
    }

    // Removes any none-applicable items from the assoc array based on search input
    public static function filterBySearch(string $string, array $array){
        $sanitised = strip_tags($string);
        foreach ( $array as $k => $singleProperty ){
            $propertyAddress = $singleProperty['Address'];
            if ( !array_search($sanitised, $propertyAddress) ) {
                unset($array[$k]);
            }
        }
        return $array;
    }

    // Removes any none-applicable items from the assoc array based on postcode input
    public static function filterByLocation(string $input, array $array, string $radius){
        // Generate Lat / Lng coordinates from the input string
        $sanitised = strip_tags($input);
        $sanitised = str_replace(' ', '+', $sanitised) . '+' . 'United+Kingdom';
        $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='. $sanitised . '&key=AIzaSyC3qcHAQ5zr2mt_Zux_nLSoryBNo1zpIN4');
        $geocodeOutput = json_decode($geocode);
        if ( isset($geocodeOutput->results[0]) ) {
            $givenData = array(
                'lat' => $geocodeOutput->results[0]->geometry->location->lat,
                'lng' => $geocodeOutput->results[0]->geometry->location->lng,
            );
        } else {
            die();
        }

        foreach ( $array as $k => $singleProperty ){
            // Get the Lat / Lng coords from the looped array
            $propertyAddress = $singleProperty['Address'];
            $propertyLocation = $propertyAddress['Location'];
            $propertyGeocode = array(
                'lat' => $propertyLocation['Latitude'],
                'lng' => $propertyLocation['Longitude'],
            );

            // Working out distance between the two locations.
            $theta = $givenData['lng'] - $propertyGeocode['lng']; 
            $distance = (sin(deg2rad($givenData['lat'])) * sin(deg2rad($propertyGeocode['lat']))) + (cos(deg2rad($givenData['lat'])) * cos(deg2rad($propertyGeocode['lat'])) * cos(deg2rad($theta))); 
            $distance = acos($distance); 
            $distance = rad2deg($distance); 
            $distance = $distance * 60 * 1.1515; 
            $distance = ceil($distance);

            if ( $distance > $radius ) {
                unset($array[$k]);
            }
        }
        return $array;
    }

    // Removes any none-applicable items frpom the assoc array based on number of bedrooms
    public static function filterByBedrooms(string $bedrooms, array $array){
        foreach ( $array as $k => $singleProperty ){
            $roomCounts = $singleProperty['RoomCountsDescription'];
            if ( $roomCounts['Bedrooms'] < $bedrooms ) {
                unset($array[$k]);
            }
        }
        return $array;
    }

    // Removes any none-applicable items frpom the assoc array based on number of bedrooms
    public static function filterByPrice(int $price, array $array){
        foreach ( $array as $k => $singleProperty ){
            $propertyPrice = $singleProperty['Price'];
            $priceValue = $propertyPrice['PriceValue'];
            if ( $price < $priceValue ){
                unset($array[$k]);
            }
  
        }
        return $array;
    }

    // Sorts the property array by user input
    public static function sortProperties(string $sort, array $array){
        switch ($sort) {
            case 'newest' :
                foreach ( $array as &$singleProperty ){
                    $dateAdded = $singleProperty['DateInstructed'];
                    $singleProperty['NumOrder'] = strtotime($dateAdded);
                }
                usort($array, function($a, $b) {
                    return $a['NumOrder'] <=> $b['NumOrder'];
                });
            break;

            case 'priceASC' :
                foreach ( $array as &$singleProperty ) {
                    $priceArray = $singleProperty['Price'];
                    $singleProperty['NumOrder'] = $priceArray['PriceValue'];
                }
                usort($array, function($a, $b) {
                    return $b['NumOrder'] <=> $a['NumOrder'];
                });
            break;

            case 'priceDESC' :
                foreach ( $array as &$singleProperty ) {
                    $priceArray = $singleProperty['Price'];
                    $singleProperty['NumOrder'] = $priceArray['PriceValue'];
                }
                usort($array, function($a, $b) {
                    return $a['NumOrder'] <=> $b['NumOrder'];
                });
            break;
        }
        return $array;
    }

    public static function trimData(array $array, string $string){
        // initialise the full array
        $dataJSON = file_get_contents($string);
        $dataArray = json_decode($dataJSON, true);
        $dataCollection = $dataArray['Collection'];
        $dataCollection = self::removeBadData($dataCollection);

        // If the search field has been filled in, then apply the search filter
        if ( isset($_POST['search_input']) && !empty($_POST['search_input']) ){
            $dataCollection = self::filterBySearch($_POST['search_input'], $dataCollection);
        }

        // If Postcode or town is active, workout distances between submitted location and what is stored for the properties. 
        if ( isset($_POST['location']) && !empty($_POST['location']) ){
            $dataCollection = self::filterByLocation($_POST['location'], $dataCollection, $_POST['radius']);
        }

        // If Minimum bedrooms is active, then filter out any properties with less than the miniumum
        if ( isset($_POST['bedrooms']) && $_POST['bedrooms'] > 0 ){
            $dataCollection = self::filterByBedrooms($_POST['bedrooms'], $dataCollection);
        }

        // If Max Price is active, then filter out any properties that are more than the given number.
        if ( isset($_POST['price']) && $_POST['price'] > 0 ){
            $dataCollection = self::filterByPrice($_POST['price'], $dataCollection);
        }

        // Sorting Options
        $dataCollection = self::sortProperties($_POST['order_hidden'], $dataCollection);

        $count = count($dataCollection);
        updateCount::doTheThing($count);



        // Render Output

        if ( !empty($dataCollection) ) {
            foreach ( $dataCollection as $singleProperty ) {
                $property = new property($singleProperty);
                $property->renderProperty();
            }
        } else {
            echo '<span class="no_properties_found">No properties found using those terms, Try again?</span>';
        }

        

    }

}