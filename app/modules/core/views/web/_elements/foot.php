
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
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php $this->buildMediaURL('/js/jquery-2.1.1.min.js'); ?>"></script>
        <script src="<?php $this->buildMediaURL('/js/bootstrap.min.js'); ?>"></script>
    </body>
</html>