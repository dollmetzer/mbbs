
<?php 
if(DEBUG_SESSION) {
    echo '<div><pre>';
    print_r($_SESSION);
    echo "</pre></div>";
}
if(DEBUG_CONTENT) {
    echo '<div><pre>';
    print_r($content);
    echo "</pre></div>";    
}
?>

        </div>
    </body>
</html>