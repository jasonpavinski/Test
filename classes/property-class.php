<?php

class property{

    // Property Variables
    public $datavars = array(
        'name' => '',
        'price' => '',
        'beds' => '',
        'reception' => '',
        'baths' => '',
        'description' => '',
        'permalink' => '',
        'photoCount' => '',
        'uploaded' => '',
    );

    public $images = array();

    // Construct Object
    public function __construct(array $array){
        // Set Name
        $addressArray = $array['Address'];
        $this->datavars['name'] = $addressArray['Locality'] . ' ' . $addressArray['Town'];
        
        // Set Price
        $priceArray = $array['Price'];
        $this->datavars['price'] = '£' . number_format($priceArray['PriceValue']);

        // Set Beds, Reception & Baths
        $roomCountArray = $array['RoomCountsDescription'];
        $this->datavars['beds'] = $roomCountArray['Bedrooms'];
        $this->datavars['reception'] = $roomCountArray['Receptions'];
        $this->datavars['baths'] = $roomCountArray['Bathrooms'];

        // Set Short Description
        $descParentArray = $array['Descriptions'];
        /// Descriptions not consistent at all within the JSON array, filter to find the correct summary and apply it to the object properties
        foreach ( $descParentArray as $needle ) {
            if ( $needle['Name'] == 'Summary' ) {
                $this->datavars['description'] = $needle['Text'];
            }
        }

        // Psudo Permalink Setting
        $this->datavars['permalink'] = '#';

        // Photo URLs
        $stopKey = 2;
        $imagesArray = $array['Images'];
        if ( is_array( $imagesArray ) ) {
            foreach ( $imagesArray as $k => $image ) {
                if ( $stopKey > $k ) {
                    $this->images[] = $image['Url'];
                }
            }
        }
        // Some properties only have one photo, this will change the container depending on whether more than one photo is present.
        $this->datavars['photoCount'] = count($this->images);
        
        // Uploaded Date
        $this->datavars['uploaded'] = $array['DateInstructed'];

    }




}