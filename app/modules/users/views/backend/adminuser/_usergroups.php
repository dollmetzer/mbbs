<h2><?php $this->lang('title_users_usergroups'); ?></h2>

<ul class="list-group">
    <?php
    foreach($content['userGroups'] as $userGroup) {
        echo '<li class="list-group-item">';
        echo '<a data-toggle="modal" data-target="#confirm-delete" data-href="';
        echo $this->buildUrl('users/adminuser/resigngroup/'.$content['user']['id'].'/'.$userGroup['id']);
        echo '" class="btn btn-default" title="';
        echo $this->lang('icon_group_resign', false);
        echo '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>&nbsp;';
        echo $userGroup['name'].' ('.$userGroup['description'].')';
        echo "</li>\n";
    }
    ?>
</ul>

<form class="form-horizontal">
    <div class="form-group">
        <div class="col-sm-8">
            <select name="" class="form-control" onchange="assignGroup(this);">
                <option value=""><?php $this->lang('txt_select_addgroup'); ?></option>
                <?php foreach($content['groups'] as $group) {
                    echo '<option value="'.$group['id'].'">'.$group['name'].'</option>';
                } ?>
            </select>
        </div>
    </div>
</form>

<script>
    function assignGroup(element) {
        url="<?php $this->buildUrl('users/adminuser/assigngroup/'.$content['user']['id']); ?>/" + element.value;
        window.location.href = url;
    }
</script>
