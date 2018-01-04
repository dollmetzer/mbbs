<?php

    echo '<select id="formfield_'.$name.'" name="' . $name;
    if (!empty($field['readonly'])) {
        echo '" readonly="readonly" onchange="this.selectedIndex = '.$field['value'].';';
    }
    if(!empty($field['size'])) {
        echo '" size="'.$field['size'];
    }
    if(!empty($field['multiple'])) {
        echo '" multiple="'.$field['multiple'];
    }
    echo '" class="form-control">';
    echo '<option value="">' . $this->lang('form_option_select', false) . '</option>';
    foreach ($field['options'] as $oVal => $oName) {
        echo '<option value="' . $oVal;
        if ($oVal == $field['value']) {
            echo '" selected="selected';
        }
        echo '">' . $oName . '</option>';
    }
    echo '</select>';

?>