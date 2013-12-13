<?php 
    echo VolterHelpers::generateAjaxLoader(
            'volts/scores',
            $activeUser,
            array("limit" => $voltsPerLoad, "load_more" => 1)
         );
?>