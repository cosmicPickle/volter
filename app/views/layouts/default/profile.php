<div class="volter-ajax-loader" 
     data-ref="<?php echo url('achievements/records'); ?>" 
     data-cont='{"fb_uid":"<?php echo $activeUser; ?>",
                 "limit":"<?php echo $achvPerLineReduced; ?>"}'>
</div>
<div class="volter-ajax-loader" 
     data-ref="<?php echo url('volts/scores'); ?>" 
     data-cont='{"fb_uid":"<?php echo $activeUser; ?>",
                 "limit":"<?php echo $voltsPerLine*$voltsLinesPerLoad; ?>"}'>
</div>