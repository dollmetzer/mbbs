<?php 
// calculate statistics
$total_sessions = 0;
$average_hits = 0;
foreach($content['session_info'] as $info) {
    $total_sessions += $info['number'];
    $average_hits += $info['hits'];
} 
$average_hits = $average_hits / $total_sessions;

include PATH_APP.'/modules/core/views/web/_elements/head.php'; ?>

<p><?php $this->toDate($content['from']); ?> - <?php $this->toDate($content['until']); ?></p>

<h2><?php echo $this->lang('title_sessions'); ?></h2>
<p><?php echo sprintf($this->lang('txt_stats_total_sessions', false), $total_sessions); ?></p>
<p><?php echo sprintf($this->lang('txt_stats_average_hits', false), $average_hits); ?></p>
<table>
    <thead>
        <tr>
            <th style="width:10%;"><?php $this->lang('table_head_number'); ?>&nbsp;</th>
            <th style="width:90%;"><?php $this->lang('table_head_hits'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($content['session_info'] as $info) { ?>
        <tr>
            <td><?php echo $info['number']; ?></td>
            <td><?php echo $info['hits']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<br />&nbsp;

<h2><?php echo $this->lang('title_useragents'); ?></h2>
<table>
    <thead>
        <tr>
            <th style="width:10%;"><?php $this->lang('table_head_number'); ?></th>
            <th style="width:90%;"><?php $this->lang('table_head_useragent'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($content['user_agents'] as $agent) { ?>
        <tr>
            <td><?php echo $agent['sessions']; ?></td>
            <td><?php echo $agent['useragent']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php include PATH_APP.'/modules/core/views/web/_elements/foot.php'; ?>