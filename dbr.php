<?php
// create absolute file path
function file_build_path(...$segments) {
    return join(DIRECTORY_SEPARATOR, $segments);
}

$file = basename($_FILES["readBarcode"]["name"]);
echo "<p>$file</p>";

if ($file != NULL && $file != "") {
  // get current working directory
  $root = getcwd();
  // tmp dir for receiving uploaded barcode images
  $tmpDir = "uploads/";
  if (!file_exists($tmpDir)) {
    mkdir($tmpDir);
  }

  $target_file = $tmpDir . basename($_FILES["readBarcode"]["name"]);
  $isSuccessful = true;
  $fileType = pathinfo($target_file,PATHINFO_EXTENSION);

  if (!$isSuccessful) {
      echo "Fail to read barcode";
  } else {
      if (move_uploaded_file($_FILES["readBarcode"]["tmp_name"], $target_file)) {
        // dynamsoft barcode reader
        $path = file_build_path($root, $target_file);

        /*
         * Description:
         * array DecodeBarcodeFile( string $filename , bool $isNativeOutput [, bool $isLogOn ] )
         *
         * Return Values:
         * If barcode detected, $array[0] is an array.
         */
        $resultArray = DecodeBarcodeFile($path, false);

        if (is_array($resultArray[0])) {
        	$resultCount = count($resultArray);
        	echo "Total count: $resultCount\n";
        	for($i = 0; $i < $resultCount ; $i++) {
        		$result = $resultArray[$i];
                	echo "<p>Barcode format: $result[0], value: $result[1]</p>";
        	}
        }
        else {
          echo "<p>$resultArray[0]</p>";
        }

        // delete the uploaded barcode image
        unlink($path);
      } else {
          echo "Fail to read barcode.";
      }
  }
}

?>
