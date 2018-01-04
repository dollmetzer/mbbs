<?php
echo '<input id="formfield_'.$name.'" type="button" name="'.$name;
if(!empty($field['value'])) {
    echo '" value="'.$this->lang('form_btn_' . $field['value'], false);
} else {
    echo '" value="'.$this->lang('form_btn', false);
}
if (!empty($field['readonly'])) {
    echo '" disabled="disabled';
}
echo '" class="btn btn-primary" />';
?>