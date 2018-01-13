<?php
$content['nav_main'] = 'adminmodule';
include PATH_APP.'modules/core/views/backend/_elements/head.php'; ?>

<p><strong><?php $this->lang('txt_cache_delete'); ?></strong></p>
<a href="<?php $this->buildURL('core/adminmodule/deletecache'); ?>" class="btn btn-warning"><?php $this->lang('link_cache_delete'); ?></a>


<h2><?php $this->lang('title_modulelist'); ?></h2>
<div class="panel panel-default">
    <form name="" action="" method="">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>&nbsp;</th>
                <th><?php $this->lang('table_col_name'); ?></th>
                <th><?php $this->lang('table_col_desc'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($content['modules'] as $module=>$config) {
                echo "    <tr>\n";
                echo "        <td>";
                if($config['active']) {
                    echo '<a href="'.$this->buildURL('core/adminmodule/deactivate/'.$module, false).'" title="'.$this->lang('txt_core_deactivate', false).'">';
                    echo '<i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i>';
                    echo '</a>';
                } else {
                    echo '<a href="'.$this->buildURL('core/adminmodule/activate/'.$module, false).'" title="'.$this->lang('txt_core_activate', false).'">';
                    echo '<i class="fa fa-toggle-off fa-2x" aria-hidden="true"></i>';
                    echo '</a>';
                }
                echo "</td>\n";
                echo "        <td>$module</td>\n";
                echo "        <td>";
                $this->lang('txt_module_'.$module.'_description');
                echo "        </td>\n    </tr>\n";
            }
            ?>
            </tbody>
        </table>
    </form>
</div>
<hr />
<pre><?php print_r($content); ?></pre>


<?php include PATH_APP.'modules/core/views/backend/_elements/foot.php'; ?>

