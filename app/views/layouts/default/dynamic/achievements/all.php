<div class="ajax-links">
    All |
    <?php 
        echo VolterHelpers::generateAjaxLink(
                'achievements/records',
                'Earned',
                $activeUser,
                Input::get('ref_id'),
                array_merge(array('limit' => $achvPerLoad),Input::except(array('ref_id', 'fb_uid')))
             );
        
        echo " | ";
        
        echo VolterHelpers::generateAjaxLink(
                'achievements/not_records',
                'Not earned',
                $activeUser,
                Input::get('ref_id'),
                array_merge(array('limit' => $achvPerLoad),Input::except(array('ref_id', 'fb_uid')))
             );
    ?>           
</div>

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