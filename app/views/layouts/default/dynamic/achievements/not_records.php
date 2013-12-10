<div class="achievments">
    <?php
        foreach($achievements as $a)
        {
    ?>
             <div class="achievement">
                    <div class="achievement-category">
                        <?= $a->cat_name; ?>
                    </div>
                    <div class="achievement-name">
                        <h3><?= $a->name; ?></h3>
                        <h4>Level: <?= $a->level; ?>, <?= $a->title; ?></h4>
                    </div>
                    <div class="achievement-desc"> 
                        <?= $a->description; ?>
                    </div>
                </div>   
<?php
        }
?>
</div>