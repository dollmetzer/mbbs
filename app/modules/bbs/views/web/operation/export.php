<?php include PATH_APP . '/modules/core/views/web/_elements/head.php'; ?>

<p><?php $this->lang('txt_export_intro'); ?></p>

<p id="selector" style="display:block;"><select id="hostSelector" onchange="createExportFile();">
    <option value="0"><?php $this->lang('txt_select_host'); ?></option>
<?php 
for($i=1; $i<sizeof($content['list']); $i++) {
    echo '    <option value="'.$content['list'][$i]['id'].'">';
    echo $content['list'][$i]['name'];
    if($content['list'][$i]['lastexport'] == '0000-00-00 00:00:00') {
        echo $this->lang('txt_never_exported');
    } else {
        echo $this->lang('txt_last_export');
        echo $this->toDateTimeShort($content['list'][$i]['lastexport']);
    }
    echo "</option>\n";
}
?>    
</select></p>

<p id="dlmessage" style="display:none;"><strong><?php $this->lang('msg_download_started'); ?></strong></p>

<script type="text/javascript">
function createExportFile() {
    url = '<?php $this->buildURL('bbs/operation/exportfile'); ?>/';
    url += document.getElementById('hostSelector').value;
    
    document.getElementById('selector').style.display = 'none';
    document.getElementById('dlmessage').style.display = 'block';
    
    location.href=url;
    
}
</script>

<?php include PATH_APP . '/modules/core/views/web/_elements/foot.php'; ?>