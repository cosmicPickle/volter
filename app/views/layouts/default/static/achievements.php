<div class="volter-ajax-loader" 
     data-ref="<?php echo url('achievements/all'); ?>" 
     data-cont='{"fb_uid":"<?php echo $activeUser; ?>",
                 "limit":"<?php echo $achvPerLine*$achvLinesPerLoad; ?>",
                 "load_more":"1"}'>
</div>
