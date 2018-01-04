
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php $this->buildURL(''); ?>"><?php echo $this->config['title']; ?></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">

        <!-- message info dropbox -->
        <?php if(!empty($content['overviewMessages'])) include PATH_APP.'modules/core/views/backend/_elements/navigation/messages.php'; ?>

        <!-- task info dropbox -->
        <?php if(!empty($content['overviewTasks'])) include PATH_APP.'modules/core/views/backend/_elements/navigation/tasks.php'; ?>

        <!-- alerts dropbox -->
        <?php if(!empty($content['overviewAlerts'])) include PATH_APP.'modules/core/views/backend/_elements/navigation/alerts.php'; ?>

        <!-- user dropdown -->
        <?php include PATH_APP.'modules/core/views/backend/_elements/navigation/user.php'; ?>

    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <?php
                        if(!empty($content['searchurl'])) {
                            $searchUrl = $content['searchurl'];
                            $searchDisabled = false;
                        } else {
                            $searchUrl = '';
                            $searchDisabled = true;
                        }
                        if(!empty($content['searchtext'])) {
                                $placeholder = $content['searchtext'];
                            } else {
                                $placeholder = 'Search...';
                            }
                        ?>
                        <form action="<?php echo $searchUrl; ?>" method="post">
                        <input type="text" class="form-control" name="searchterm" placeholder="<?php echo $placeholder; ?>" <?php if($searchDisabled === true) echo 'disabled="disabled"' ?>>
                        </form>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="<?php $this->buildURL('core/admin'); ?>" <?php if($content['nav_main'] == 'admin') echo 'class="active"'; ?>><i class="fa fa-dashboard fa-fw"></i> <?php $this->lang('nav_admin_dashboard'); ?></a>
                </li>
                <li>
                    <a href="<?php $this->buildURL('core/adminmodule'); ?>" <?php if($content['nav_main'] == 'adminmodule') echo 'class="active"'; ?>><i class="fa fa-cubes fa-fw"></i> <?php $this->lang('nav_admin_module'); ?></a>
                </li>
                <?php
                if(method_exists($this, 'getNavigation')) {
                    $navigation = $this->getNavigation('backend');
                    foreach($navigation as $topitem=>$topnav) {
                        if(!empty($topnav['group'])) {
                            if(!$this->userInGroup($topnav['group'])) continue;
                        }
                        echo '<li>';
                        echo '<a href="';
                        echo $this->buildURL($topnav['url'], false);
                        if($content['nav_main'] == $topitem) {
                            echo '" class="active';
                        }
                        echo '">';
                        echo '<i class="fa fa-fw '.$topnav['icon'].'"></i> ';
                        echo $this->lang('nav_'.$topitem, false);
                        if(!empty($topnav['subnav'])) {
                            echo '<span class="fa arrow"></span></a>';
                            echo '<ul class="nav nav-second-level">';
                            foreach($topnav['subnav'] as $subitem=>$subnav) {
                                echo '<li><a href="';
                                echo $this->buildURL($subnav['url'], false);
                                echo '">';
                                echo $this->lang('nav_'.$subitem, false);
                                echo '</a></li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '</a>';
                        }
                        echo "</li>\n";
                    }
                }
                ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>