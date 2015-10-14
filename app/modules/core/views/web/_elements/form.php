<?php
/**
 * Standard form template
 * 
 * The standard form template should be used with zzaplib Form Class.
 * The rendering uses the array structure, returned by the Form::getViewdata() method.
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @package tvcommerce
 * @subpackage core
 */
?>
<form <?php
if(!empty($content['form']['action'])) {
    echo 'action="'.$content['form']['action'].'" ';
} else {
    echo 'action="" ';
}
if (!empty($content['form']['name'])) {
    echo ' name="' . $content['form']['name'] . '" ';
}
?> enctype="multipart/form-data" method="post" role="form">
<?php
    $hasRequired = false;
    // all hidden fields on top
    foreach ($content['form']['fields'] as $name => $field) {
        if($field['type'] == 'hidden') {
            echo '<input id="formfield_'.$name.'" type="hidden" name="'.$name.'" value="'.$field['value']."\" />\n";
        }
    }
    $focus = '';
    foreach ($content['form']['fields'] as $name => $field) {

        if($field['type'] != 'hidden') {

            if(empty($focus)) {
                $focus = $name;
            }
            if(!empty($field['focus'])) {
                $focus = $name;
            }
            
            if (!empty($field['error'])) {
                echo "<p class='error' id='formblock_".$name."'>\n";
                echo '<label>&nbsp;</label>';
                echo '<span class="help-block">' . $field['error'] . "</span>";
                echo "<br />";
            } else {
                echo "<p id='formblock_".$name."'>\n";
            }

            if ($field['type'] != 'divider') {
                echo "    <label for='$name'>" . $this->lang('form_label_' . $name, false);
                if (!empty($field['required'])) {
                    echo '&nbsp;<sup>*</sup>';
                    $hasRequired = true;
                }
                echo "</label>\n    ";
            }

            switch ($field['type']) {
                case 'text':
                case 'integer':
                    echo '<input id="formfield_'.$name.'" type="text" name="';
                    echo $name . '" ';
                    if (!empty($field['readonly'])) {
                        echo 'readonly="readonly" ';
                    }
                    if (!empty($field['maxlength'])) {
                        echo 'maxlength="' . $field['maxlength'] . '" ';
                    }
                    if (!empty($field['placeholder'])) {
                        echo 'placeholder="' . $field['placeholder'] . '" ';
                    }
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'password':
                    echo '<input id="formfield_'.$name.'" type="password" name="';
                    echo $name . '" ';
                    if (!empty($field['maxlength'])) {
                        echo 'maxlength="' . $field['maxlength'] . '" ';
                    }
                    echo 'value="" />';
                    break;

                case 'range':
                    echo '<input id="formfield_'.$name.'" type="range" name="';
                    echo $name . '" ';
                    echo 'value="' . $field['value'] . '" style="width:auto;" />';
                    break;

                case 'date':
                    echo '<input id="formfield_'.$name.'" type="date" name="';
                    echo $name . '" ';
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'email':
                    echo '<input id="formfield_'.$name.'" type="email" name="';
                    echo $name . '" ';
                    if (!empty($field['readonly'])) {
                        echo 'readonly="readonly" ';
                    }
                    if(!empty($field['placeholder'])) {
                        echo 'placeholder="'.$field['placeholder'].'" ';
                    }
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'url':
                    echo '<input id="formfield_'.$name.'" type="url" name="';
                    echo $name . '" ';
                    if(!empty($field['placeholder'])) {
                        echo 'placeholder="'.$field['placeholder'].'" ';
                    }
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'number':
                    echo '<input id="formfield_'.$name.'" type="number" name="';
                    echo $name . '" ';
                    if (!empty($field['min'])) {
                        echo 'min="' . $field['min'] . '" ';
                    }
                    if (!empty($field['max'])) {
                        echo 'max="' . $field['max'] . '" ';
                    }
                    if (!empty($field['step'])) {
                        echo 'step="' . $field['step'] . '" ';
                    }
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'color':
                    echo '<input id="formfield_'.$name.'" type="color" name="';
                    echo $name . '" ';
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'select':
                    echo '<select id="formfield_'.$name.'" name="' . $name;
                    if (!empty($field['readonly'])) {
                        echo '" readonly="readonly" onchange="this.selectedIndex = '.$field['value'].';';
                    }
                    echo '">';
                    echo '<option value="">' . $this->lang('form_option_select', false) . '</option>';
                    foreach ($field['options'] as $oVal => $oName) {
                        echo '<option value="' . $oVal;
                        if ($oVal == $field['value']) {
                            echo '" selected="selected';
                        }
                        echo '">' . $oName . '</option>';
                    }
                    echo '</select>';
                    break;

                case 'radio':
                    foreach ($field['options'] as $oVal => $oName) {
                        echo '<input id="formfield_'.$name.'" type="radio" name="' . $name . '" value="' . $oVal;
                        if ($oVal == $field['value']) {
                            echo '" checked="checked';
                        }
                        echo '" />&nbsp;';
                        echo $oName . '&nbsp;&nbsp;&nbsp;';
                    }
                    break;
                    
                case 'checkbox':
                    echo '<input id="formfield_'.$name.'" type="checkbox" name="' . $name;
                    if(!empty($field['value'])) {
                        echo '" checked="checked';
                    }
                    echo '" />&nbsp;';
                    break;

                case 'textarea':
                    echo '<textarea id="formfield_'.$name.'" name="' . $name;
                    if (!empty($field['rows'])) {
                        echo '" rows="' . $field['rows'];
                    }
                    echo '">';
                    if (!empty($field['value'])) {
                        echo $field['value'];
                    }
                    echo "</textarea>\n";
                    break;

                case 'datetime-local':
                    echo '<input id="formfield_'.$name.'" type="datetime" name="';
                    echo $name . '" ';
                    if (!empty($field['readonly'])) {
                        echo 'readonly="readonly" ';
                    }
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'submit':
                    echo '<input id="formfield_'.$name.'" type="submit" name="'.$name;
                    echo '" value="'.$this->lang('form_submit_' . $field['value'], false).'" />';
                    break;
                
                case 'button':
                    echo '<button id="formfield_'.$name.'" name="'.$name;
                    if(!empty($field['class'])) {
                        echo '" class="'.$field['class'];
                    }
                    echo '" value="'.$field['value'];
                    echo '" >';
                    echo $field['text'];
                    echo '</button>';
                    break;

                case 'static':
                    echo '<p>' . $field['value'] . "</p>\n";
                    break;

                case 'divider':
                    echo '<hr />';
                    break;

                case 'hidden':
                    // skip. We had hidden fields already on the top
                    break;
                
                case 'file':
                    echo '<input id="formfield_'.$name.'" type="file" name="'.$name;
                    if(!empty($field['accept'])) {
                        echo '" accept="'.$field['accept'];
                    }
                    echo '" />';
                    break;

                default:
                    echo '<p>' . $this->lang('form_error_type', false) . "</p>\n";
            }
            echo "</p>\n";
        }
    }
    
    if ($hasRequired === true) {
        echo "<p>" . $this->lang('form_has_required', false) . "</p>\n";
    }
?>
</form>

<?php if(!empty($content['form']['name'])) { ?>
<script type="text/javascript">
    document.forms.<?php echo $content['form']['name'] . '.' . $focus ?>.focus();
</script>
<?php } ?>

