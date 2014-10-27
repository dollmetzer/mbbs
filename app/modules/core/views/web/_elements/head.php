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
                        <li<?php if($content['nav_main'] == 'about') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('about'); ?>"><?php $this->lang('nav_about') ?></a></li>
                        <li<?php if($content['nav_main'] == 'privacy') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('privacy'); ?>"><?php $this->lang('nav_privacy') ?></a></li>
                        <li<?php if($content['nav_main'] == 'imprint') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('imprint'); ?>"><?php $this->lang('nav_imprint') ?></a></li>
                        <li<?php if($content['nav_main'] == 'login') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('account/login') ?>"><?php $this->lang('nav_login') ?></a></li>
                        <li class="user">(<?php $this->lang('nav_not_loggedin'); ?>)</li>
                        <?php } else { ?>
                        <li<?php if($content['nav_main'] == 'wall') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('/bbs/wall'); ?>"><?php $this->lang('nav_wall') ?></a></li>
                        <li class="dropdown<?php if($content['nav_main'] == 'mail') { echo ' active'; } ?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php $this->lang('nav_mail') ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php $this->buildURL('/bbs/mail/in'); ?>"><?php $this->lang('nav_mail_inbox') ?></a></li>
                                <li><a href="<?php $this->buildURL('/bbs/mail/out'); ?>"><?php $this->lang('nav_mail_outbox') ?></a></li>
                            </ul>                            
                        </li>
                        <li<?php if($content['nav_main'] == 'board') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('/bbs/board'); ?>"><?php $this->lang('nav_board') ?></a></li>
                        
                        <?php if(in_array('admin', $this->app->session->groups)) { ?>
                        <li class="dropdown<?php if($content['nav_main'] == 'admin') { echo ' active'; } ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php $this->lang('nav_admin') ?> <span class="caret"></span></a>
                        </li>
                        <?php } ?>
                        
                        <li><a href="<?php $this->buildURL('account/settings') ?>"><?php $this->lang('nav_settings') ?></a></li>
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
    echo '<p><strong>Fehler!</strong></p>'.$_SESSION['flasherror'].'<p>';
    echo "</div>\n";

} 
if(!empty($_SESSION['flashmessage'])) {
    echo '<div class="alert alert-info" role="alert" onclick="closeAlert()">';
    echo '<p><strong>Hinweis!</strong></p>'.$_SESSION['flashmessage'].'<p>';
    echo "</div>\n";
} 
?>

<script>
    function closeAlert() {
        $(".alert").slideUp();
    }
</script>