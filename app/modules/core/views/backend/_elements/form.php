<form <?php
if (!empty($content['form']['action'])) {
    echo 'action="' . $content['form']['action'] . '" ';
} else {
    echo 'action="" ';
}
if (!empty($content['form']['name'])) {
    echo 'name="' . $content['form']['name'] . '" ';
}
echo 'enctype="multipart/form-data" method="post" role="form" data-toggle="validator" >';
echo "\n\n";

$hasRequired = false;

// all hidden fields on top
foreach ($content['form']['fields'] as $name => $field) {
    if ($field['type'] == 'hidden') {
        echo '<input id="formfield_' . $name . '" type="hidden" name="' . $name . '" value="' . $field['value'] . "\" />\n";
    }
}
$focus = '';

foreach ($content['form']['fields'] as $name => $field) {
    if ($field['type'] != 'hidden') {

        if (empty($focus)) {
            $focus = $name;
        }
        if (!empty($field['focus'])) {
            $focus = $name;
        }

        if (!empty($field['error'])) {
            echo "<div class='form-group has-error' id='formblock_$name'>\n";
        } else {
            echo "<div class='form-group' id='formblock_$name'>\n";
        }

        if ($field['type'] != 'divider') {
            if ($field['label'] !== false) {
                echo "    <label for='formfield_$name' class='control-label'>" . $this->lang('form_label_' . $name, false);

                if (!empty($field['help'])) {
                    echo "&nbsp;<i class='glyphicon glyphicon-question-sign' data-toggle='tooltip' data-placement='top' title='";
                    echo $field['help'];
                    echo "'></i>";
                }

                if (!empty($field['required'])) {
                    echo '&nbsp;<sup><i class="glyphicon glyphicon-asterisk"></i></sup>';
                    $hasRequired = true;
                } else {
                    echo '&nbsp;<sup>&nbsp;</sup>';
                }

                echo "</label>\n";
            }
        }


        $element = PATH_APP . 'modules/core/views/backend/_elements/form/' . $field['type'] . '.php';
        include $element;


        if (!empty($field['error'])) {
            echo "<p class='text-danger'><strong>" . $field['error'] . "</strong></p>\n";
        }

        echo "</div>\n\n";
    }
}

if ($hasRequired === true) {
    echo '<div class="form-group">';
    echo '<label control-label">&nbsp;</label>';
    echo '<div>' . $this->lang('form_has_required', false);
    echo "</div></div>\n";
}

?>
</form>

<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    <?php if(!empty($content['form']['name'])) { ?>
    document.forms.<?php echo $content['form']['name'] . '.' . $focus ?>.focus();
    <?php } ?>

</script>