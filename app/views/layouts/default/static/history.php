<?php 
    echo VolterHelpers::generateAjaxLoader(
            'volts/history',
            $activeUser,
            array("limit" => $voltsHistoryPerLoad, "load_more" => 1)
         );
    
    echo VolterHelpers::generateAjaxLoader(
            'achievements/records',
            $activeUser,
            array("limit" => $achvPerLoad, "load_more" => 1)
         );
?>