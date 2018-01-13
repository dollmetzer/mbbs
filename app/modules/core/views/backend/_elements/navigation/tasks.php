
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-tasks">
        <?php foreach($content['overviewTasks'] as $task) {
            $progress = (int)$task['progress'];
            if($progress < 0) $progress = 0;
            if($progress > 100) $progress = 100;

            if(!in_array($task['type'], array('success','warning','danger'))) {
                $task['type'] = 'info';
            }
            $progressBarType = 'progress-bar-'.$task['type'];
            ?>
            <li>
                <a href="<?php echo $task['url']; ?>">
                    <div>
                        <p>
                            <strong><?php echo $task['name']; ?></strong>
                            <span class="pull-right text-muted"><?php echo $progress; ?>% Complete</span>
                        </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar <?php echo $progressBarType ?>" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress; ?>%">
                                <span class="sr-only"><?php echo $progress.'% Complete ('.$task['type'].')'; ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
        <?php } ?>
        <li>
            <a class="text-center" href="<?php echo $content['link_to_tasks']; ?>">
                <strong>See All Tasks</strong>
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
    </ul>
</li>
