<?php
if(!empty($content['table']->urlPage)) {

    $firstEntry = $content['table']->page - $content['table']->paginationWidth;
    if($firstEntry < 0) {
        $firstEntry = 0;
    }
    $lastEntry = $firstEntry + ($content['table']->paginationWidth * 2);
    if($lastEntry > $content['table']->maxPage) {
        $lastEntry = $content['table']->maxPage;
    }
    ?>
    <div style="text-align: center;">
        <nav>
            <ul class="pagination">
                <?php
                // left arrow box
                if($content['table']->page > 0) {
                    echo '<li><a href="';
                    echo $this->buildUrl($content['table']->urlPage.'/'.($content['table']->page-1));
                    echo '" aria-label="Previous">';
                } else {
                    echo '<li class="disabled"><a href="#" aria-label="Previous">';
                }
                echo '<span aria-hidden="true">&laquo;</span></a></li>';
                echo "\n";

                // number boxes
                for($i=$firstEntry; $i<$lastEntry ; $i++) {
                    if($i == $content['table']->page) {
                        echo '<li class="active"><a href="';
                    } else {
                        echo '<li><a href="';
                    }
                    echo $this->buildUrl($content['table']->urlPage.'/'.$i);
                    echo '">';
                    echo ($i+1);
                    echo "</a></li>\n";
                }

                // right arrow box
                if($content['table']->page < ($content['table']->maxPage -1)) {
                    echo '<li><a href="';
                    echo $this->buildUrl($content['table']->urlPage.'/'.($content['table']->page+1));
                    echo '" aria-label="Next">';
                } else {
                    echo '<li class="disabled"><a href="#" aria-label="Next">';
                }
                echo '<span aria-hidden="true">&raquo;</span></a></li>';
                echo "\n";
                ?>
            </ul>
        </nav>
    </div>
<?php } ?>