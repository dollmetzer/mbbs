<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>mBBS<?php if(!empty($content['title'])) echo ' - '.$content['title']; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php $this->buildMediaURL('/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="<?php $this->buildMediaURL('/css/bootstrap-theme.min.css'); ?>" rel="stylesheet">
        <link href="<?php $this->buildMediaURL('/css/web.css'); ?>" rel="stylesheet">

        <script src="<?php $this->buildMediaURL('/js/jquery-2.1.1.min.js'); ?>"></script>
        <script src="<?php $this->buildMediaURL('/js/bootstrap.min.js'); ?>"></script>
        
    </head>

    <body role="document">

        <!-- Fixed navbar -->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php $this->buildURL(''); ?>">mBBS</a>
                </div>
                
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <?php 
                        $userId = $this->app->session->user_id; 
                        if(empty($userId)) { ?>
                        
                        <li<?php if($content['nav_main'] == 'imprint') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('imprint'); ?>"><?php $this->lang('nav_imprint') ?></a></li>
                        <li<?php if($content['nav_main'] == 'login') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('account/login') ?>"><?php $this->lang('nav_login') ?></a></li>
                        <?php if($this->app->config['register']['selfregister'] === true) { ?>
                        <li<?php if($content['nav_main'] == 'register') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('account/register') ?>"><?php $this->lang('nav_register') ?></a></li>
                        <?php } ?>
                        <li class="user">(<?php $this->lang('nav_not_loggedin'); ?>)</li>
                        
                        <?php } else { ?>
                        
                        <li<?php if($content['nav_main'] == 'wall') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('bbs/wall'); ?>"><?php $this->lang('nav_wall') ?></a></li>
                        <li class="dropdown<?php if($content['nav_main'] == 'mail') { echo ' active'; } ?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php $this->lang('nav_mail') ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php $this->buildURL('bbs/mail/in'); ?>"><?php $this->lang('nav_mail_inbox') ?></a></li>
                                <li><a href="<?php $this->buildURL('bbs/mail/out'); ?>"><?php $this->lang('nav_mail_outbox') ?></a></li>
                            </ul>                            
                        </li>
                        <li<?php if($content['nav_main'] == 'board') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('bbs/board'); ?>"><?php $this->lang('nav_board') ?></a></li>
                        <?php if(in_array('operator', $this->app->session->groups)) { ?>
                        <li class="dropdown<?php if($content['nav_main'] == 'operation') { echo ' active'; } ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php $this->lang('nav_operation') ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php $this->buildURL('bbs/operation/hosts'); ?>"><?php $this->lang('nav_operation_hosts') ?></a></li>
                                <li><a href="<?php $this->buildURL('bbs/operation/export'); ?>"><?php $this->lang('nav_operation_export') ?></a></li>
                                <li><a href="<?php $this->buildURL('bbs/operation/import'); ?>"><?php $this->lang('nav_operation_import') ?></a></li>
                            </ul> 
                        </li>
                        <?php } ?>
                        <?php if(in_array('administrator', $this->app->session->groups)) { ?>
                        <li class="dropdown<?php if($content['nav_main'] == 'admin') { echo ' active'; } ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php $this->lang('nav_admin') ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php $this->buildURL('core/adminuser'); ?>"><?php $this->lang('nav_admin_user') ?></a></li>
                                <li><a href="<?php $this->buildURL('core/admingroup'); ?>"><?php $this->lang('nav_admin_group') ?></a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li<?php if($content['nav_main'] == 'settings') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('account/settings') ?>"><?php $this->lang('nav_settings') ?></a></li>
                        <li><a href="<?php $this->buildURL('account/logout') ?>"><?php $this->lang('nav_logout') ?></a></li>
                        <li class="user">(<?php echo sprintf($this->lang('nav_loggedin', false), $this->app->session->user_handle); ?>)</li>
                        
                        <?php } ?>
                    </ul>
                </div><!--/.nav-collapse -->
                
            </div>
        </div>

        <div class="container theme-showcase" role="main" style="padding-top:60px;">

<?php
if(!empty($content['title'])) {
//    echo '<div class="page-header">';
    echo '<h1>'.$content['title'].'</h1>';
//    echo "</div>\n";
}
if(!empty($_SESSION['flasherror'])) {
    echo '<div class="alert alert-danger" role="alert" onclick="closeAlert()">';
    echo '<p><strong>'.$this->lang('msg_flash_error', false).'</strong></p>'.$_SESSION['flasherror'].'<p>';
    echo "</div>\n";

} 
if(!empty($_SESSION['flashmessage'])) {
    echo '<div class="alert alert-info" role="alert" onclick="closeAlert()">';
    echo '<p><strong>'.$this->lang('msg_flash_notice', false).'</strong></p>'.$_SESSION['flashmessage'].'<p>';
    echo "</div>\n";
} 
?>

<script>
    function closeAlert() {
        $(".alert").slideUp();
    }
    setTimeout(function() {
        $(".alert").slideUp();
    },3000);
</script>