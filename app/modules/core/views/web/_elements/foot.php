
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

<script>
    $( window ).ready(function() {
		
        // switch navigation on and off
	$('#navicon').click(function() {
            $('#main-nav').toggle('slow');
            $('#navicon').fadeOut('slow');
            $('#navicon-close').fadeIn('slow');
	});
        // switch navigation on and off
	$('#navicon-close').click(function() {
            $('#main-nav').toggle('slow');			
            $('#navicon').fadeIn('slow');
            $('#navicon-close').fadeOut('slow');
        });
			
	// switch subnavigation on and off
	$('.hasSubnav').click(function() {
            $(this).find('ul').toggle('slow');
	});
			
    });
</script>

        </div>
    </body>
</html>