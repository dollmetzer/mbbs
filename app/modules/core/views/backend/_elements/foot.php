        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <footer>[
        <?php
        if(DEBUG_SESSION === true) {
            echo "<pre>\n";
            print_r($_SESSION);
            echo "</pre>\n\n";
        }

        if(DEBUG_CONTENT === true) {
            echo "<pre>\n";
            print_r($content);
            echo "</pre>\n\n";
        }
        ?>
    </footer>


    <!-- BEGIN Modal confirm delete -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php $this->lang('txt_core_deleteconfirm'); ?></h4>
                </div>
                <div class="modal-body"><?php $this->lang('msg_core_deleteconfirm'); ?></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php $this->lang('link_core_cancel'); ?></button>
                    <a class="btn btn-danger btn-ok"><?php $this->lang('link_core_delete'); ?></a>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
    <!-- END Modal confirm delete -->

<?php if( !empty($_SESSION['flasherror']) || !empty($_SESSION['flashmessage'])) {
    if(!empty($_SESSION['flasherror'])) {
        $modalClass = "modal-content alert alert-danger";
        $modalBodyExtension = '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ';
        $modalHeader = $this->lang('msg_core_flasherror', false);
        $modalMessage = $_SESSION['flasherror'];
    } else {
        $modalClass = "modal-content";
        $modalBodyExtension = '';
        $modalHeader = $this->lang('msg_core_flashnotice', false);
        $modalMessage = $_SESSION['flashmessage'];
    }
    ?>
    <!-- BEGIN Modal Error/Notification -->
    <div class="modal fade" id="flash" tabindex="-1" role="dialog" aria-labelledby="Error" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="<?php echo $modalClass; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php $modalHeader ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo $modalBodyExtension.$modalMessage; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><?php $this->lang('link_core_close'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#flash').modal({show:true})
    </script>
    <!-- END Modal Error/Notification -->
<?php } ?>


    <!-- Metis Menu Plugin JavaScript -->
    <script src="/backend/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/backend/dist/js/sb-admin-2.js"></script>

    <?php
    $js = $this->getJS();
    if(!empty($js)) {
        echo "<!-- Additional JS Files -->\n";
        for($i=0; $i<sizeof($js); $i++) {
            echo '    <script src="';
            echo $js[$i];
            echo '"></script>';
            echo "\n";
        }
    }
    ?>

</body>

</html>