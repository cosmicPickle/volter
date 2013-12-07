<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo asset('css/layouts/default.css') ?>">
    </head>
    <body>
        <?php
            echo $content;
        ?>
        <script type="text/javascript" src="<?php echo asset('js/jquery.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('js/volter-ajax-loaders.js'); ?>"></script>
    </body>
</html>
