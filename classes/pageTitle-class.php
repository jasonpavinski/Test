<?php 
/*
*   Object Class for capturing & displaying the page's title
*/

class pageTitle {
    
    // Properties
    public $title;
    
    // Initialisation
    function __construct(string $string){
        $this->title = $string;
    }

    // Methods 
    function render(){
         echo '<div class="wrapper"><div class="cqc flex_wrap"><div class="page_title"><h1>' . $this->title . '</h1></div><div></section>'; 
    }

}