<?php
$content['nav_main'] = 'adminuser';
include PATH_APP.'modules/core/views/backend/_elements/head.php';
?>

    <div class="row">
        <div class="col-lg-12">
            <?php include(PATH_APP . 'modules/core/views/backend/_elements/form.php'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"><?php include(PATH_APP . 'modules/users/views/backend/adminuser/_usergroups.php'); ?></div>
    </div>
    <p>&nbsp;</p>

<?php include PATH_APP.'modules/core/views/backend/_elements/foot.php'; ?>