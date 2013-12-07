<div class="volter-ajax-loader" 
     data-ref="<?php echo url('volts/history'); ?>" 
     data-cont='{"fb_uid":"<?php echo $activeUser; ?>",
                 "limit":"<?php echo $voltsHistoryPerLoad; ?>",
                 "load_more":"1"}'>
</div>
<div class="volter-ajax-loader" 
     data-ref="<?php echo url('achievements/records'); ?>" 
     data-cont='{"fb_uid":"<?php echo $activeUser; ?>",
                 "limit":"<?php echo $achvPerLine; ?>",
                 "load_more":"1"}'>
</div>