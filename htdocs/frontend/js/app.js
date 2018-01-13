$.when($.ready).then(function () {

    // Document is ready.
    console.log('Document is ready')

    // open an close navigation
    $("#navicon").click(function(){
        console.log('Open Navigation')
        $("#navicon").css('display','none');
        $("#navicon-close").css('display','inline');
        $("#mainnavi").slideDown();
    });

    $("#navicon-close").click(function(){
        console.log('Close Navigation')
        $("#navicon").css('display','inline');
        $("#navicon-close").css('display','none');
        $("#mainnavi").slideUp();
    });

    // close alert boxes
    $("#alertbox").click(function(){
        $("#alertbox").slideUp();
    });

});