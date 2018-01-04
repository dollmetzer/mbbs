<div class="checkbox">
    <label>
<?php

    echo '<input id="formfield_'.$name.'" type="checkbox" name="' . $name;
    if(!empty($field['value'])) {
        echo '" checked="checked';
    }
    if (!empty($field['readonly'])) {
        echo '" readonly="readonly';
    }

    echo '" />&nbsp;';
    if(!empty($field['description'])) {
        echo $field['description'];
    }

?>
    </label>
</div>

