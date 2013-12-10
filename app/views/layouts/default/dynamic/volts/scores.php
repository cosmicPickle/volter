<div class="volt-scores">
    <?php
        $score = $scores->find(1);
    ?>
     <div class='score-overall'>
        <div class='score-category'>
            <h3><?= $score->name; ?></h3>
        </div>
        <div class='score'>
            <?php
                if($score->volts_count > 0)
                    echo number_format($score->volts_score/$score->volts_count,2)
                    .' of '
                    .$score->volts_count
                    .' volts.';
                else
                    echo "0.0 of 0 volts.";
            ?>
        </div>
    </div>
    
    <?php 
        foreach($scores as $score)
        {
            if($score->id == 1) continue;
    ?>
    <div class='score'>
        <div class='score-category'>
            <h3><?= $score->name; ?></h3>
        </div>
        <div class='score'>
            <?php
                if($score->volts_count > 0)
                    echo number_format($score->volts_score/$score->volts_count,2)
                    .' of '
                    .$score->volts_count
                    .' volts.';
                else
                    echo "0.0 of 0 volts.";
            ?>
        </div>
    </div>
    <?php
        }
    ?>
</div>
