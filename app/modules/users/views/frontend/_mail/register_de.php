<?php include PATH_APP . 'modules/core/views/frontend/_mail/head.php' ?>

Vielen Dank für Ihre Registrierung bei <?php echo $this->config['title']; ?>!

Sie ein neues Konto mit der Nutzerkennung <?php echo $content['handle']; ?> angelegt.
Zur Aktivierung Ihres Kontos, geben Sie bitte den folgenden Bestätigungcode im Webformular ein:

<?php echo $content['confirmcode']; ?>


Falls Sie das Registrierungsfenster bereits geschlossen haben, können Sie auch einfach auf den
folgenden Aktivierungslink klicken:

<?php $this->buildUrl('users/account/confirm/' . $content['confirmcode']); ?>


Sollten Sie sich nicht bei <?php echo $this->config['title']; ?> registriert haben,
ignorieren Sie bitte diese Mail. Das Konto mit Ihrer Mailadresse wird dann nicht aktiviert.


Ihr <?php echo $this->config['title']; ?> Team

<?php include PATH_APP.'modules/core/views/frontend/_mail/foot.php' ?>
