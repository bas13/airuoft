<?php

// Set back link
echo anchor('','Back') . "<br />";

// Check if flights table is set, if so generate table and set it otherwise don't
if(isset($flights) && $flights != null) {
    echo $flights->generate(); 
}
?>
