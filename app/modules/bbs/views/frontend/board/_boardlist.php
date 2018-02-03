<?php if(!empty($content['themes'])) { ?>
    <table class="maillist striped">
        <?php foreach($content['themes'] as $theme) { ?>
            <tr onclick="showboard(<?php echo $theme['id']; ?>);" class="entry">
                <td>
                    <strong><?php echo $theme['name']; ?></strong><br /><?php echo $theme['description']; ?></a>
                    <?php
                    /**
                    if(in_array('administrator', $this->session->groups)) { ?>
                        <br /><a href="<?php $this->buildURL('bbs/adminboard/edit/'.$theme['id']); ?>" class="btn btn-small"><i class="fa fa-pencil"></i> <?php $this->lang('link_core_edit'); ?></a>
                        <a href="<?php $this->buildURL('bbs/adminboard/delete/'.$theme['id']); ?>" class="btn btn-small"><i class="fa fa-trash-o"></i> <?php $this->lang('link_core_delete'); ?></a>
                    <?php }
                    */
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br />
    <script>
        function showboard(id) {
            url = '<?php $this->buildURL('bbs/board/list/') ?>' + id;
            location.href = url;
        }
    </script>
<?php } ?>