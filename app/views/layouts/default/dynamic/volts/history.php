<div class="volts">
    <?php foreach($volts as $volt)
    {
    ?>
        <div class="volt">
            <?= $users[$volt->from_uid]; ?> has volted for <?= $users[$volt->to_uid]; ?> in category <?= $volt->category->name; ?>
        </div>
    <?php
    }
    ?>
    
</div>
