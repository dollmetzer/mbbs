<?php include PATH_APP.'modules/core/views/frontend/_mail/head.php' ?>

Ihr neues Passwort bei <?php echo $this->config['title']; ?>

Sie haben ein neues Passwort angefordert. Es lautet:

<?php echo $content['newpwd']; ?>


Wir empfehlen Ihnen, sich gleich anzumelden und sich ein eigenes, neues Passwort zu geben.

Ihr <?php echo $this->config['title']; ?> Team

<?php include PATH_APP.'modules/core/views/frontend/_mail/foot.php' ?>
