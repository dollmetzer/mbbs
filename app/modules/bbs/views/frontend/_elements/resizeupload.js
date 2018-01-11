/**
 * How to use:
 * - the empty image must have the id="show-picture"
 * - the image must be included in a paragraph with id="itemphoto" and style="display:none;"
 * - the upload form element must have id="formfield_picture"
 */

if (window.File && window.FileReader && window.FileList && window.Blob) {
    document.getElementById('formfield_picture').onchange = function () {
        var files = document.getElementById('formfield_picture').files;
        for (var i = 0; i < files.length; i++) {
            resizeAndUpload(files[i]);
        }
    };
} else {
    document.getElementById('formfield_picture').style.display = 'none';
    alert('The File APIs are not fully supported in this browser.');
}

function resizeAndUpload(file) {

    var reader = new FileReader();
    reader.onloadend = function () {

        var tempImg = new Image();
        tempImg.src = reader.result;
        tempImg.onload = function () {

            var MAX_WIDTH = <?php echo $this->config['media']['pictures']['maxwidth']; ?> ;
            var MAX_HEIGHT = <?php echo $this->config['media']['pictures']['maxheight']; ?> ;
            var tempW = tempImg.width;
            var tempH = tempImg.height;
            if (tempW > tempH) {
                if (tempW > MAX_WIDTH) {
                    tempH *= MAX_WIDTH / tempW;
                    tempW = MAX_WIDTH;
                }
            } else {
                if (tempH > MAX_HEIGHT) {
                    tempW *= MAX_HEIGHT / tempH;
                    tempH = MAX_HEIGHT;
                }
            }

            var canvas = document.createElement('canvas');
            canvas.width = tempW;
            canvas.height = tempH;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(this, 0, 0, tempW, tempH);
            var dataURL = canvas.toDataURL("image/jpeg");

            $('#formfield_picture').attr('value', '');
            $('#formfield_picture').val('');

            //show in preview
            var showPicture = document.querySelector("#show-picture");
            showPicture.src = dataURL;
            $('#itemphoto').slideDown();
            $('#formblock_picture').slideUp();
            $('#formfield_image').val(dataURL);
        }
    }
    reader.readAsDataURL(file);
}