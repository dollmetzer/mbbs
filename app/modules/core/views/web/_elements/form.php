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
?> method="post" role="form">
<?php
    $hasRequired = false;
    // all hidden fields on top
    foreach ($content['form']['fields'] as $name => $field) {
        if($field['type'] == 'hidden') {
            echo '<input type="hidden" name="'.$name.'" value="'.$field['value']."\" />\n";
        }
    }
    $first = '';
    foreach ($content['form']['fields'] as $name => $field) {

        if($field['type'] != 'hidden') {

            if(empty($first)) {
                $first = $name;
            }
            
            if (!empty($field['error'])) {
                echo "<div class='form-group has-error'>\n";
                echo '<label>&nbsp;</label>';
                echo '<span class="help-block">' . $field['error'] . "</span>";
                echo "</div>";
                echo "<div class='form-group has-error'>\n";
            } else {
                echo "<div class='form-group'>\n";
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
                    echo '<input type="text" class="form-control" name="';
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
                    echo '<input type="password" class="form-control"  name="';
                    echo $name . '" ';
                    if (!empty($field['maxlength'])) {
                        echo 'maxlength="' . $field['maxlength'] . '" ';
                    }
                    echo 'value="" />';
                    break;

                case 'range':
                    echo '<input type="range" class="form-control"  name="';
                    echo $name . '" ';
                    echo 'value="' . $field['value'] . '" style="width:auto;" />';
                    break;

                case 'date':
                    echo '<input type="date" class="form-control"  name="';
                    echo $name . '" ';
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'email':
                    echo '<input type="email" class="form-control"  name="';
                    echo $name . '" ';
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'url':
                    echo '<input type="url" class="form-control"  name="';
                    echo $name . '" ';
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'number':
                    echo '<input type="number" class="form-control"  name="';
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
                    echo '<input type="color" class="form-control"  name="';
                    echo $name . '" ';
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'select':
                    echo '<select class="form-control" name="' . $name;
                    if (!empty($field['readonly'])) {
                        echo '" readonly="readonly" onchange="this.selectedIndex = '.$field['value'].';';
                    }
                    echo '" style="width:auto;">';
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
                        echo '<input type="radio" name="' . $name . '" value="' . $oVal;
                        if ($oVal == $field['value']) {
                            echo '" checked="checked';
                        }
                        echo '" />&nbsp;';
                        echo $oName . '&nbsp;&nbsp;&nbsp;';
                    }
                    break;

                case 'textarea':
                    echo '<textarea class="form-control" name="' . $name;
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
                    echo '<input type="datetime" class="form-control" name="';
                    echo $name . '" ';
                    if (!empty($field['readonly'])) {
                        echo 'readonly="readonly" ';
                    }
                    echo 'value="' . $field['value'] . '" />';
                    break;

                case 'submit':
                    echo '<button type="submit" class="btn btn-primary">';
                    echo $this->lang('form_submit_' . $field['value']) . '</button>';
                    break;

                case 'static':
                    echo '<p class="form-control-static">' . $field['value'] . "</p>\n";
                    break;

                case 'divider':
                    echo '<hr />';
                    break;

                case 'hidden':
                    // skip. We had hidden fields already on the top
                    break;

                default:
                    echo '<p class="form-control-static">' . $this->lang('form_error_type', false) . "</p>\n";
            }
            echo "</div>\n";
        }
    }
    
    if ($hasRequired === true) {
        echo "<div class='form-group'><p>" . $this->lang('form_has_required', false) . "</p></div>\n";
    }
?>
</form>

<?php if(!empty($content['form']['name'])) { ?>
<script type="text/javascript">
    document.forms.<?php echo $content['form']['name'] . '.' . $first ?>.focus();
</script>
<?php } ?>

