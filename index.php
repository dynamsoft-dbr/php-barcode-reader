<!DOCTYPE html>
<html>
<head>
  <title>Dynamsoft PHP Barcode Reader</title>
  <script src="jquery-1.11.3.min.js"></script>
  <script src="tiff.min.js"></script>
</head>
<body>
<H1>Dynamsoft PHP Barcode Reader</H1>
<form action="dbr.php" method="post" enctype="multipart/form-data">
    Select barcode image:
    <input type="file" name="readBarcode" id="readBarcode" accept="image/*"><br>
    <input type="submit" value="Read Barcode" name="submit">
</form>
<div id="tiff"></div>
<div id='image'></div>
<script>
      function reset() {
        $("#image").empty();
        $("#tiff").empty();
      }

			var input = document.querySelector('input[type=file]');
			input.onchange = function() {
        reset();
				var file = input.files[0];
				var fileReader = new FileReader();
        // get file extension
        var extension = file.name.split('.').pop().toLowerCase();
        var isTiff = false;

        if (extension == "tif" || extension == "tiff") {
          isTiff = true;
        }

				fileReader.onload = function(e) {
          if (isTiff) {
            console.debug("Parsing TIFF image...");
            //initialize with 100MB for large files
            Tiff.initialize({
              TOTAL_MEMORY: 100000000
            });
            var tiff = new Tiff({
              buffer: e.target.result
            });
            var tiffCanvas = tiff.toCanvas();
            $(tiffCanvas).css({
              "max-width": "800px",
              "width": "100%",
              "height": "auto",
              "display": "block",
              "padding-top": "10px"
            }).addClass("TiffPreview");
            $("#tiff").append(tiffCanvas);
          }
          else {
            var dataURL = e.target.result, img = new Image();
            img.src = dataURL;
            $("#image").append(img);
          }
				}

        if (isTiff) {
            fileReader.readAsArrayBuffer(file);
        }
        else
				    fileReader.readAsDataURL(file);
			}
</script>

</body>
</html>
