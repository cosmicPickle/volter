<?php 
    echo VolterHelpers::generateAjaxLoader(
            'achievements/records',
            $activeUser,
            array("limit" => $achvPerLoadReduced, "load_more" => 1)
         );
    
    echo VolterHelpers::generateAjaxLoader(
            'volts/scores',
            $activeUser,
            array(
                
                "limit" => $voltsPerLoad, 
                "order_by" => "volts_score",
                "order_dir" => "desc",
                "load_more" => 1
            )
         );
?>