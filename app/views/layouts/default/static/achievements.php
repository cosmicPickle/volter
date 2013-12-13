<?php 
    echo VolterHelpers::generateAjaxLoader(
            'achievements/all',
            $activeUser,
            array("limit" => $achvPerLoad, "load_more" => 1)
         );
?>

