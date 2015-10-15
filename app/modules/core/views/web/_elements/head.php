<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php 
            echo $this->app->config['core']['title'] ;
            if(!empty($content['title'])) echo ' - '.$content['title']; 
        ?></title>
        
        <link rel="icon" href="<?php $this->buildMediaURL('/img/favicon.ico'); ?>">
        <link rel="stylesheet" href="<?php $this->buildMediaURL('/css/font-awesome.css'); ?>">
        <!--link href="<?php $this->buildMediaURL('/css/mbbs.css'); ?>" rel="stylesheet"-->

        <style>
            
body {
    margin: 0;
    padding: 0;
    border: 0;
    font-family: sans-serif;
    background-color:#cccccc;
    color:#000000;
}
h1 {
    margin:0 0 0.6em 0;
    border:0;
    padding:0;
    color:#ff3300;
    font-size:1.8em;
    font-weight:bold;
}
h2 {
    margin:0 0 0.3em 0;
    border:0;
    padding:0;
    color:#ff3300;
    font-size:1.4em;
    font-weight:bold;
}
h3 {
    margin:0 0 0.1em 0;
    border:0;
    padding:0;
    color:#ff3300;
    font-size:1.1em;
    font-weight:bold;
}
p {
    margin:0 0 1em 0;
    border:0;
    padding:0;
}
p a {
    color:#cc0000;
    text-decoration: none;
}
p.pagination {
    margin:0.5em 0;
    text-align: center;
    width:100%;
}
.btn {
    margin:0 0 0.5em 0;
    border:1px solid #444444;
    border-radius:0.5em;
    padding:0.5em 1em;
    color: #444444;
    text-decoration:none;
    text-shadow: -1px -1px 0 rgba(0,0,0,0.3);
    background-image: -webkit-linear-gradient(top, #E6E6E6, #CCCCCC);
    background-image: -moz-linear-gradient(top, #E6E6E6, #CCCCCC);
    background-image: -ms-linear-gradient(top, #E6E6E6, #CCCCCC);
    background-image: -o-linear-gradient(top, #E6E6E6, #CCCCCC);
    font-size:1em;
    line-height:2em;
    white-space:nowrap;
}
.btn-small {
    margin:0 0 0.5em 0;
    border:1px solid #444444;
    border-radius:0.5em;
    padding:0 0.5em;
    color: #444444;
    text-decoration:none;
    text-shadow: -1px -1px 0 rgba(0,0,0,0.3);
    background-image: -webkit-linear-gradient(top, #E6E6E6, #CCCCCC);
    background-image: -moz-linear-gradient(top, #E6E6E6, #CCCCCC);
    background-image: -ms-linear-gradient(top, #E6E6E6, #CCCCCC);
    background-image: -o-linear-gradient(top, #E6E6E6, #CCCCCC);
    font-size:1em;
    line-height:1.5em;
    white-space:nowrap;
}
.btn-ok {
    color:#00cc00;
}
.btn-cancel {
    color:#cc0000;
}
.btn-inactive {
    color:#999999;
}

/**   H E A D E R   **/

header {
    position:relative;
    margin:0;
    padding:1em;
    border:0;
    background-color:#444444;
    color:#cccccc;
}
header h1 {
    margin:0.1em 0 0 1.2em;
    color:#ff9933;
    font-size:1.8em;
}
#navicon {
    position:absolute;
    top:0.5em;
    left:0.5em;
    font-size:2em;
    display:inline;
    cursor:pointer;
}
#navicon-close {
    position:absolute;
    top:0.5em;
    left:0.5em;
    font-size:2em;
    display:none;
    cursor:pointer;    
}
header a {
    color:#cccccc;
}



/**   N A V I G A T I O N   **/

nav {
    position:relative;
    margin:0;
    padding:1em 0 1em 0;
    border:0;
    background-color:#999999;
    color:#444444;
    height:100%;
    display:none;
    transition: display 2s;
    font-size:1.3em;
    line-height:2em;
}
nav ul {
    margin:0;
    border:0;
    padding:0;
    width:100%;
    list-style-type:none;		
}
nav li {
    margin:0;
    padding:0;
    border:0px;
}
nav li.hasSubnav {
    margin:0 0 0 0.6em;
    color:#cc0000;
    cursor:pointer;
}
nav li.active {
    font-weight:bold;
}
nav li ul {
    display:none;
    background-color:#888888;
}
nav li li {
    margin-left:1em;
    font-weight: normal;
}
nav a {
    margin:0.6em;
    color:#cc0000;
    text-decoration: none;
}
nav li span {
    margin:0 0 0 0.6em;
}

/**   A L E R T B O X   **/

div.alert {
    margin:0 0 1em 0;
    padding:1em;
    border-radius:0.5em;
}
div.alert-danger {
    border:1px solid #cc0000;
    background-color: #eedddd;
    color:#cc0000;
}
div.alert-info {
    border: 1px solid #000099;
    background-color: #ddddee;
    color:#000099;
}
        
        
div.content {
    margin:0;
    border:0;
    padding:1em;
}

/**   T A B L E   **/
table {
    margin:0;
    padding:0;
    border:0;
    width:100%;
    border-collapse: collapse;
}
th {
    text-align: left;
    background:#999999;
}
td {
    vertical-align: top;
}
td.divider {
    margin:0;
    border:0;
    border-bottom: 1px solid #444444;
    padding:0;
}

table.maillist {
    border-top: 1px solid #444444;
}
table.maillist th {
    border-bottom: 1px solid #444444;
    padding:0.5em 0;
}
table.maillist td {
    border-bottom: 1px solid #444444;
    padding:0.5em 0;
    cursor:pointer;
}

table.striped tr:nth-of-type(odd) {
    margin:0;
    background-color:#dddddd;
} 
table.striped tr:nth-of-type(even) {
    margin:0;
    background-color:#cccccc;
} 


/**   F O R M S   **/

#inputform {
    margin:0 0 0.5em;;
    border-top:1px solid #444444;
    border-bottom:1px solid #444444;
    padding:0.5em 0 0.5em 0;
}
p.error {
    color: #cc0000;
}
p.error label {
    color: #cc0000;
}
@media only screen and (max-width: 400px) { 
    label {
        margin:0;
        border:0;
        padding:0;
        display: block;
        font-weight:bold;
    }
    input[type=text],
    input[type=password],
    select,
    textarea {
        margin:0;
        border:1px solid #444444;
        border-radius:0.3em;
        padding:0.3em;
        width:90%;
        display:block;
        font-size:1em;
        background:#ffffff;
        color:#444444;
    }
    p.static {
        margin:0;
        border:0;
        padding:0;
        width:90%;
        float:left;
    }
    img#show-picture {
        width:90%;
    }
}

@media only screen and (min-width: 401px) { 
    label {
        margin:0;
        border:0;
        padding:0;
        width:33%;
        display: block;
        float: left;
    }
    input[type=text],
    input[type=password],
    select,
    textarea {
        margin:0;
        border:1px solid #444444;
        border-radius:0.3em;
        padding:0.3em;
        width:60%;
        display:block;
        font-size:1em;
        background:#ffffff;
        color:#444444;
    }
    p.static {
        margin:0;
        border:0;
        padding:0;
        width:60%;
        float:left;
    }
    img#show-picture {
        width:60%;
    }
}

input:focus,
select:focus,
textarea:focus {
    background:#ffeecc;
    color:#000000;
}
        </style>
        
        
        <script src="<?php $this->buildMediaURL('/js/jquery-2.1.1.min.js'); ?>"></script>
        <script src="<?php $this->buildMediaURL('/js/mbbs.js'); ?>"></script>
        
    </head>

    <body>

        <header>
            <a id="navicon"><i class="fa fa-bars"></i></a>
            <a id="navicon-close"><i class="fa fa-close"></i></a>
            <h1><?php echo $this->app->config['core']['title']; ?></h1>
	</header>
 
        
        <nav id="main-nav">
            <ul>
                <?php 
                $userId = $this->app->session->user_id; 
                if(empty($userId)) { ?>

                <li<?php if($content['nav_main'] == 'login') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('account/login') ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_login') ?></a></li>
                <?php if($this->app->config['core']['register']['selfregister'] === true) { ?>
                <li<?php if($content['nav_main'] == 'register') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('account/register') ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_register') ?></a></li>
                <?php } ?>
                <li<?php if($content['nav_main'] == 'imprint') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('imprint'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_imprint') ?></a></li>
                <li><span>(<?php $this->lang('nav_not_loggedin'); ?>)</span></li>

                <?php } else { ?>

                <li<?php if($content['nav_main'] == 'wall') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('bbs/wall'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_wall') ?></a></li>
                <li class="hasSubnav<?php if($content['nav_main'] == 'mail') { echo ' active'; } ?>">
                    <i class="fa fa-chevron-right"></i> <?php $this->lang('nav_mail') ?> 
                    <?php if(!empty($content['newMails'])) { echo ' ('.$content['newMails'].')'; } ?>
                    <ul>
                        <li><a href="<?php $this->buildURL('bbs/mail/in'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_mail_inbox') ?></a></li>
                        <li><a href="<?php $this->buildURL('bbs/mail/out'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_mail_outbox') ?></a></li>
                    </ul>                            

                </li>
                <li<?php if($content['nav_main'] == 'board') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('bbs/board'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_board') ?></a></li>
                <?php if(in_array('operator', $this->app->session->groups)) { ?>
                <li class="hasSubnav<?php if($content['nav_main'] == 'operation') { echo ' active'; } ?>">
                    <i class="fa fa-chevron-right"></i> <?php $this->lang('nav_operation') ?>
                    <ul>
                        <li><a href="<?php $this->buildURL('bbs/operation/hosts'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_operation_hosts') ?></a></li>
                        <li><a href="<?php $this->buildURL('bbs/operation/export'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_operation_export') ?></a></li>
                        <li><a href="<?php $this->buildURL('bbs/operation/import'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_operation_import') ?></a></li>
                    </ul> 

                </li>
                <?php } ?>
                <?php if(in_array('administrator', $this->app->session->groups)) { ?>
                <li class="hasSubnav<?php if($content['nav_main'] == 'admin') { echo ' active'; } ?>">
                    <i class="fa fa-chevron-right"></i> <?php $this->lang('nav_admin') ?>
                    <ul>
                        <li><a href="<?php $this->buildURL('core/adminuser'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_admin_user') ?></a></li>
                        <li><a href="<?php $this->buildURL('core/admingroup'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_admin_group') ?></a></li>
                    </ul>
                </li>
                <li<?php if($content['nav_main'] == 'statistics') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('core/adminstats'); ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_admin_stats'); ?></a></li>
                <?php } ?>
                <li<?php if($content['nav_main'] == 'settings') { echo ' class="active"'; } ?>><a href="<?php $this->buildURL('account/settings') ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_settings') ?></a></li>
                <li><a href="<?php $this->buildURL('account/logout') ?>"><i class="fa fa-chevron-right"></i> <?php $this->lang('nav_logout') ?></a></li>
                <li><span>(<?php echo sprintf($this->lang('nav_loggedin', false), $this->app->session->user_handle); ?>)</span></li>
                <?php } ?>                        
            </ul>
        </nav>
        
        
        <div class="content">
        
<?php
if(!empty($_SESSION['flasherror'])) {
    echo '<div class="alert alert-danger onclick="closeAlert()">';
    echo '<p><strong>'.$this->lang('msg_flash_error', false).'</strong></p>';
    echo '<p>'.$_SESSION['flasherror'].'<p>';
    echo "</div>\n";

} 
if(!empty($_SESSION['flashmessage'])) {
    echo '<div class="alert alert-info onclick="closeAlert()">';
    echo '<p><strong>'.$this->lang('msg_flash_notice', false).'</strong></p>';
    echo '<p>'.$_SESSION['flashmessage'].'<p>';
    echo "</div>\n";
} 
?>

<?php if(!empty($content['title'])) echo '<h1>'.$content['title'].'</h1>'; ?>
