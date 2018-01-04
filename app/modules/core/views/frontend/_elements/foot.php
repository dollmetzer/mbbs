</div>

<footer><p>&copy;&nbsp;2017 Dirk Ollmetzer&nbsp;[
    <?php
    for($i=0; $i<sizeof($this->config['languages']); $i++) {
        if($i > 0) echo '|&nbsp;';
        if($this->config['languages'][$i] == $this->session->user_language) {
            echo '<strong>'.$this->config['languages'][$i].'</strong>&nbsp;';
        } else {
            echo '<a href="'.$this->buildURL('core/language/switchto/'.$this->config['languages'][$i], false).'">'.$this->config['languages'][$i].'</a>&nbsp;';
        }
    }
    ?>]</p>

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

<?php
$js = $this->getJS();
if(!empty($js)) {
    echo "<!-- Additional JS Files -->\n";
    for($i=0; $i<sizeof($js); $i++) {
        echo '    <script src="';
        echo $this->buildMediaURL($js[$i], false);
        echo '"></script>';
        echo "\n";
    }
}
?>

</body>
</html>