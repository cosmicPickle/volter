<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo asset('css/layouts/default.css') ?>">
    </head>
    <body>
        <div id="profile-wrap">
            <div id="profile-sidebar">
                <div id="fb-ident">
                    <div id="fb-ident-pic">
                        <img src="<?php echo FacebookUtils::getPictureUrl('large', $activeUser); ?>">
                    </div>
                    <div id="fb-ident-name">
                        <?php echo FacebookUtils::user($activeUser)->name; ?>
                    </div>
                </div>
                <ul id="profile-nav">
                    <li><a href="<?php echo URL::to('profile/'.$activeUser); ?>"> Profile </a></li>
                    <li><a href="<?php echo URL::to('volts/'.$activeUser); ?>"> Volts </a></li>
                    <li><a href="<?php echo URL::to('achievements/'.$activeUser); ?>"> Achievements </a></li>
                    <li><a href="<?php echo URL::to('history/'.$activeUser); ?>"> History </a></li>
                </ul>
            </div>
            <div id="profile-content">
                <?php
                    echo isset($content) ? $content : NULL;
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <script type="text/javascript" src="<?php echo asset('js/jquery.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('js/volter-ajax-loaders.js'); ?>"></script>
    </body>
</html>
