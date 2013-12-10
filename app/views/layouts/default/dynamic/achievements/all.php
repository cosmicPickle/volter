<div class="achievments">
    <?php
        foreach($achievements as $cat)
            foreach($cat->achievements as $a)
            {
                $a->users = $a->users->toArray();
    ?>
                <div class="achievement<?= (!empty($a->users) ? ' owned' : '') ?>">
                    <div class="achievement-category">
                        <?= $cat->name; ?>
                    </div>
                    <div class="achievement-name">
                        <h3><?= $a->name; ?></h3>
                        <h4>Level: <?= $a->level; ?>, <?= $a->title; ?></h4>
                    </div>
                    <div class="achievement-desc"> 
                        <?= $a->description; ?>
                    </div>
                    <?php if(!empty($a->users))
                    {
                    ?>
                        <div class="record"><?= $a->updated_at; ?></div>
                    <?php
                    }
                    ?>
                </div> 
            <?php
            }
            ?>
</div>