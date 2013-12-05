<?php

$params = array("redirect_uri" => route("login"));
echo "<a href='".FacebookUtils::fb()->getLoginUrl($params)."'>Connect with Facebook</a><br />";

