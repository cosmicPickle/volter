<div class="achievments">
    <?php
        foreach($user->achievements as $a)
        {
    ?>
             <div class="achievement owned">
                    <div class="achievement-category">
                        <?= $a->category->name; ?>
                    </div>
                    <div class="achievement-name">
                        <h3><?= $a->name; ?></h3>
                        <h4>Level: <?= $a->level; ?>, <?= $a->title; ?></h4>
                    </div>
                    <div class="achievement-desc"> 
                        <?= $a->description; ?>
                    </div>
                    <div class="record">
                        Achieved: <?= $a->updated_at; ?>
                    </div>
                </div>   
<?php
        }
?>
</div>