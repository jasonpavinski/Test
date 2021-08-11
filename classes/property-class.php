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

    public function renderImages(){
        if ( $this->datavars['photoCount'] > 1 ) { $photoMode = 'dualPhotoMode';  } else { $photoMode = 'singlePhotoMode'; }
        if ( is_array($this->images) ) {
            foreach ( $this->images as $image ) {
                echo '<div class="' . $photoMode . ' property_a_image" style="background-image:url(\'' . $image . '\');"></div>';
            }
        }
    }

    public function outputRooms() {
        $roomSVGS = array(
            array( 'num' => $this->datavars['beds'], 'room' => file_get_contents(__DIR__ . '/../assets/svgs/icon-bed.svg')),
            array( 'num' => $this->datavars['reception'], 'room' => file_get_contents(__DIR__ . '/../assets/svgs/icon-rooms.svg')),
            array( 'num' => $this->datavars['baths'], 'room' => file_get_contents(__DIR__ . '/../assets/svgs/icon-bath.svg')),
        );

        echo '<div class="__details_room_icons">';
        if ( is_array($roomSVGS) ) {
            foreach ( $roomSVGS as $room ) {
                echo '<span>' . $room['room'] . ' <span>' . $room['num'] . '</span></span>';
            }
        }
        echo '</div>';
    }

    public function renderDetails(){
        echo '<span class="__p_price">' . $this->datavars['price'] . '</span>';
        echo '<h2>' . $this->datavars['name'] . '</h2>';
        $this->outputRooms();
        echo '<p>' . $this->datavars['description'] . '</p>';
        echo '<button class="btn property_go"><a href="' . $this->datavars['permalink'] . '">LEARN MORE</a></button>';
    }

    public function renderProperty(){
        echo '<div class="single_property" data-aos="fade-up" data-aos-duration="1500"><div class="property_images">';
        $this->renderImages();
        echo '</div><div class="property_details">';
        $this->renderDetails();
        echo '</div></div>';
    }




}