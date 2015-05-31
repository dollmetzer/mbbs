<?php 
if ($content['pagination_maxpages'] > 1) {
    
    if($content['pagination_page'] > 0) {
        echo '<p class="pagination"><a href="'.sprintf($content['pagination_link'], 1);
        echo '" class="btn-small"><i class="fa fa-fast-backward"></i></a>&nbsp;';
        echo '<a href="'.sprintf($content['pagination_link'], $content['pagination_page']);
        echo'" class="btn-small"><i class="fa fa-backward"></i></a>&nbsp;';
    } else {
        echo '<p class="pagination"><a href="#" class="btn-small btn-inactive"><i class="fa fa-fast-backward"></i></a>&nbsp;';
        echo '<a href="#" class="btn-small btn-inactive"><i class="fa fa-backward"></i></a>&nbsp;';
    }
    
    echo sprintf($this->lang('txt_pagination_page', false), ($content['pagination_page']+1), $content['pagination_maxpages']);

    if($content['pagination_maxpages'] > ($content['pagination_page']+1)) {
        echo '&nbsp;<a href="';
        echo sprintf($content['pagination_link'], ($content['pagination_page']+2) );
        echo '" class="btn-small"><i class="fa fa-forward"></i></a>';
        echo '&nbsp;<a href="';
        echo sprintf($content['pagination_link'], ($content['pagination_maxpages']) );
        echo'" class="btn-small"><i class="fa fa-fast-forward"></i></a></p>';
    } else {
        echo '&nbsp;<a href="#" class="btn-small btn-inactive"><i class="fa fa-forward"></i></a>';
        echo '&nbsp;<a href="#" class="btn-small btn-inactive"><i class="fa fa-fast-forward"></i></a></p>';
        
    }

    
}
?>
