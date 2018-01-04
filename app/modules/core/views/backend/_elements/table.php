<?php
$columns = $content['table']->getColumns();
$rows = $content['table']->getRows();

if($content['table']->maxPage > 1) {
    include(PATH_APP . 'modules/core/views/backend/_elements/pagination.php');
}
?>
<div class="panel panel-default">
    <?php
    if(!empty($content['table']->title)) {
        echo '    <div class="panel-heading">';
        echo $content['table']->title;
        echo "</div>\n";
    }
    if(!empty($content['table']->description)) {
        echo '    <div class="panel-body"><p>';
        echo $content['table']->description;
        echo "</p></div>\n";
    }
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <?php
            foreach ($columns as $key => $attr) {
                switch ($attr['type']) {
                    case 'hidden':
                        break;
                    default:
                        if(!empty($attr['width'])) {
                            echo '<th style="width: '.$attr['width'].'">';
                        } else {
                            echo '<th>';
                        }

                        if( ($attr['sortable'] === true) && !empty($content['table']->urlSort)) {
                            if($content['table']->sortDirection == 'asc') {
                                $sortDir = 'desc';
                            } else {
                                $sortDir = 'asc';
                            }
                            echo '<a href="';
                            $this->buildUrl($content['table']->urlSort.'/'.$key.'/'.$sortDir);
                            echo '">';
                            echo $this->lang('table_col_'.$key);
                            if($content['table']->sortColumn == $key) {
                                if($content['table']->sortDirection == 'asc') {
                                    echo '&nbsp;<span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>';
                                } elseif($content['table']->sortDirection == 'desc') {
                                    echo '&nbsp;<span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>';
                                }
                            }
                            echo '</a>';
                        } else {
                            echo $this->lang('table_col_'.$key);
                        }


                        echo "</th>\n";
                        break;
                }
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($rows as $row) {
            echo "<tr>\n";
            foreach ($columns as $key => $attr) {
                switch ($attr['type']) {
                    case 'hidden':
                        break;

                    case 'active':
                        echo '<td>';
                        if(!empty($row[$key])) {
                            echo '<span class="glyphicon glyphicon-ok" aria-hidden="true" title="'.$this->lang('icon_core_active', false).'"></span>';
                        } else {
                            echo '<span class="glyphicon glyphicon-remove" aria-hidden="true" title="'.$this->lang('icon_core_blocked', false).'"></span>';
                        }
                        echo "</td>\n";
                        break;

                    case 'switch':
                        echo '<td>';
                        echo '<input type="checkbox"';
                        if(!empty($row[$key])) {
                            echo ' checked="checked"';
                        }
                        echo ' onclick="switchState('.$row['id'].');"';
                        if(empty($content['table']->urlSwitch)) {
                            echo ' disabled="disabled"';
                        }
                        echo ' />';
                        echo "</td>\n";
                        break;

                    case 'details':
                        if(empty($content['table']->urlDetails)) {
                            echo '<td><a href="#" class="btn disabled" ';
                        } else {
                            echo '<td><a href="';
                            $this->buildUrl($content['table']->urlDetails.'/'.$row['id']);
                            echo '" class="btn btn-default" ';
                        }
                        echo 'title="'.$this->lang('icon_core_details', false);
                        echo '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>';
                        echo "\n";
                        break;

                    case'edit':
                        if(empty($content['table']->urlEdit)) {
                            echo '<td><a href="#" class="btn disabled" ';
                        } else {
                            echo '<td><a href="';
                            $this->buildUrl($content['table']->urlEdit.'/'.$row['id']);
                            echo '" class="btn btn-default" ';
                        }
                        echo 'title="'.$this->lang('icon_core_edit', false);
                        echo '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>';
                        echo "\n";
                        break;

                    case'delete':
                        if(empty($content['table']->urlDelete)) {
                            echo '<td><a href="#" class="btn disabled" ';
                        } else {
                            echo '<td><a data-toggle="modal" data-target="#confirm-delete" data-href="';
                            $this->buildUrl($content['table']->urlDelete.'/'.$row['id']);
                            echo '" class="btn btn-default" ';
                        }
                        echo 'title="'.$this->lang('icon_core_delete', false);
                        echo '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>';
                        echo "\n";
                        break;

                    case 'date':
                        echo '<td>';
                        $this->toDate($row[$key]);
                        //echo $row[$key];
                        echo "</td>\n";
                        break;

                    case 'datetime':
                        echo '<td>';
                        $this->toDatetime($row[$key]);
                        //echo $row[$key];
                        echo "</td>\n";
                        break;

                    case 'datetime_short':
                        echo '<td>';
                        $this->toDatetimeShort($row[$key]);
                        //echo $row[$key];
                        echo "</td>\n";
                        break;

                    default:
                        echo '<td>';
                        echo $row[$key];
                        echo "</td>\n";
                        break;
                }
            }
            echo "</tr>\n";
        }
        ?>
        </tbody>
    </table>

    <?php if(!empty($content['table']->urlNew)) {
        echo '<div class="panel-footer" style="text-align:right;"><a href="';
        $this->buildUrl($content['table']->urlNew);
        echo '" title="'.$this->lang('icon_core_new', false);
        echo '" class="btn btn-default"';
        echo ' ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
        echo "</div>\n";
    } ?>

</div>
<?php
if($content['table']->maxPage > 1) {
    include(PATH_APP . 'modules/core/views/backend/_elements/pagination.php');
}
?>

<script type="text/javascript">
    function switchState(id) {
        page = <?php echo $content['table']->page; ?>;
        url = '<?php $this->buildUrl($content['table']->urlSwitch); ?>/' + id + '/' + page;
        window.location.href = url;
    }
</script>
