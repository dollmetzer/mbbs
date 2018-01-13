<?php include PATH_APP.'modules/core/views/frontend/_mail/head.php' ?>

Thank you for registering at <?php echo $this->config['title']; ?>!

You created a new account with the user handle <?php echo $content['handle']; ?>.
To activate your account, please enter the following confirmationcode in the web form:

<?php echo $content['confirmcode']; ?>


In case you've already closed the registration window, you can also click on the following activation link:

<?php $this->buildUrl('users/account/confirm/'.$content['confirmcode']); ?>


If you didn't registered at <?php echo $this->config['title']; ?>, please ignore this mail.
The account with your mail address will not be activated.


Yours <?php echo $this->config['title']; ?> Team

<?php include PATH_APP.'modules/core/views/frontend/_mail/foot.php' ?>
