
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-messages">
        <?php
        foreach($content['overviewMessages'] as $msg) { ?>
            <li>
                <a href="<?php echo $msg['url'];  ?>">
                    <div>
                        <strong><?php echo $msg['name']; ?></strong>
                        <span class="pull-right text-muted"><em><?php $this->toDatetimeShort($msg['time']); ?></em></span>
                    </div>
                    <div><?php echo $msg['shorttext']; ?></div>
                </a>
            </li>
            <li class="divider"></li>
        <?php } ?>
        <li>
            <a class="text-center" href="<?php $this->buildURL($content['link_to_messages']); ?>">
                <strong>Read All Messages</strong>
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
    </ul>
</li>
