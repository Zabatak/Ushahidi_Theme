<?php blocks::open("reports"); ?>
<h5 class="right">احدث التقارير</h5>
<?php if ($total_items == 0): ?>
    <?php echo Kohana::lang('ui_main.no_reports'); ?>
<?php endif ?>
<?
foreach ($incidents as $incident) {
    $incident_id = $incident->id;
    $incident_title = text::limit_chars($incident->incident_title, 40, '...', True);
    $incident_date = $incident->incident_date;
    $incident_date = date('M j Y', strtotime($incident->incident_date));
    $incident_location = $incident->location->location_name;
    $comment_count = $incident->comment->count();
    $incident_verified = $incident->incident_verified;
    $incident_description = $incident->incident_description;
    $incident_description = text::limit_chars(strip_tags($incident_description), 60, "...", true);
    ?>
    <div class="rb_report">

        <div class="r_details">
            <h3>
                <a class="r_title" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                    <?php echo $incident_title; ?>
                </a>
                <a href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>#discussion" class="r_comments">
                    <?php echo $comment_count; ?></a> 
                <?php //echo $incident_verified; ?>
            </h3>
            <p class="r_date r-3 bottom-cap"><?php echo $incident_date; ?></p>
            <div class="r_description"> <?php echo $incident_description; ?>  </div>
            <!--
            <td><a href="<?php echo url::site() . 'reports/view/' . $incident_id; ?>"> <?php echo $incident_title ?></a></td>
            <td><?php echo $incident_location ?></td>
            <td><?php echo $incident_date; ?></td>
            -->

        </div>
    </div>
        <?php
    }
    ?>


    <a class="btn_submit" href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>
    <div style="clear:both;"></div>
    <?php blocks::close(); ?>