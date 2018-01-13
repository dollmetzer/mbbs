<?php include PATH_APP.'modules/core/views/frontend/_mail/head.php' ?>

Your new password at <?php echo $this->config['title']; ?>

You requested a new password. It is:

<?php echo $content['newpwd']; ?>


We recommend, to login immediately and set your own new password.

Yours <?php echo $this->config['title']; ?> Team

<?php include PATH_APP.'modules/core/views/frontend/_mail/foot.php' ?>
