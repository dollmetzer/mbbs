<?php

include PATH_APP . '/modules/core/views/frontend/_elements/head.php';


// B o a r d   d e s c r i p t i o n
if(!empty($content['board']['description'])) {
    echo '  <p>'.$content['board']['description']."</p>";
}


// B r e a d c r u m b
echo '<p class="breadcrumb">';
echo '<i class="fa fa-book fa-fw"></i>&nbsp;<a href="';
$this->buildURL('bbs/board/list/0');
echo '">';
$this->lang('link_mainboard');
echo '</a>';
foreach($content['path'] as $step) {
    echo '&nbsp;/&nbsp;<a href="'.$this->buildURL('bbs/board/list/'.$step['id'], false).'">';
    echo $step['name'];
    echo "</a>";
}
echo "</p>\n";


// If Content for the board is true, allow new entry
if(!empty($content['board']['content'])) {
    echo '<p><a href="';
    $this->buildURL('bbs/board/new/'.$content['id']);
    echo '" class="btn"><i class="fa fa-pencil"></i> ';
    $this->lang('btn_new_article');
    echo "</a></p>\n";
}


// A d m i n i s t r a t o r   B u t t o n
if(in_array('administrator', $this->session->groups) && empty($content['board']['content'])) {
    echo '<p><a href="';
    echo $this->buildURL('bbs/adminboard/add/'.$content['id']);
    echo '" class="btn btn-default btn-xs">';
    echo '<i class="fa fa-plus"></i> ';
    $this->lang('link_board_add');
    echo "</a></p>\n";
}


// L i s t   o f   s u b - b o a r d s
include '_boardlist.php';


// L i s t   o f   m e s s a g e s
include '_messagelist.php';

echo "\n<br />\n";


include PATH_APP . '/modules/core/views/frontend/_elements/foot.php';
?>