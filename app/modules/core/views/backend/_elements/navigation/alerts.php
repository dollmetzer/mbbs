
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-alerts">
        <?php foreach($content['overviewAlerts'] as $alert) { ?>
            <li>
                <a href="<?php echo $alert['url']; ?>">
                    <div>
                        <i class="fa <?php echo $alert['icon']; ?> fa-fw"></i> <?php echo $alert['name']; ?>
                        <span class="pull-right text-muted small"><?php $this->toDatetimeShort($alert['time']); ?></span>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
        <?php } ?>
        <li>
            <a class="text-center" href="<?php echo $content['link_to_alerts']; ?>">
                <strong>See All Alerts</strong>
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
    </ul>
</li>
