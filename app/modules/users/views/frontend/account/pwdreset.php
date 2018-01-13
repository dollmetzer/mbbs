<?php
$content['nav_main'] = 'login';
include PATH_APP.'modules/core/views/frontend/_elements/head.php'; ?>

    <p><?php $this->lang('txt_users_pwdreset'); ?></p>

    <div class="row" style="text-align: center;">
        <div class="col-md-1">&nbsp;</div>
        <div class="panel-body col-md-10" style="text-align: left;">

            <?php include PATH_APP . 'modules/core/views/backend/_elements/form.php'; ?>

        </div>
        <div class="col-md-1">&nbsp;</div>
    </div>

<?php include PATH_APP.'modules/core/views/frontend/_elements/foot.php'; ?>