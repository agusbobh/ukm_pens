<?php
if (!empty($dataagenda)) {
  foreach($dataagenda as $row ) {
?>
<i class="fa fa-envelope bg-black"></i>
<div class="timeline-item">
    <span class="time"><i class="fa fa-clock-o"></i><?php echo $row->AGENDA_TIME ?>  s/d  <?php echo $row->AGENDA_TIMETO ?></span>
    <h3 class="timeline-header text-navy"><?php echo $row->AGENDA_TITLE ?></h3>
    <div class="timeline-body">
      <?php
          echo $row->AGENDA_TEXT
      ?>
    </div>
    <!-- <div class='timeline-footer'>
        <a class="btn btn-primary btn-xs">Share</a>
        <a class="btn btn-danger btn-xs">Read More</a>
    </div> -->
</div>
<?php } } ?>
