<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# define variables and set to empty values
$input = $input_file = $output_format = $temp_file = "";
$input_err = $outfmt_err = "";
$dir_results = "results/";


# get the field when the search bottom is press
if (isset($_POST['submit'])){
  # Get variables from post method
  $input         = $_POST['FASTA'];
  $input_file    = $_FILES['UploadFile']["name"];
  $output_format = test_input($_POST['output_format']);


  #~~~~~~~~~~~~~~~~~~~~~~~~~Check the required fields~~~~~~~~~~~~~~~~~~~~~~~~~~~
  if (empty($input) AND empty($input_file)) {
    $input_err = "One input option must be provided";
  }elseif (!empty($input) AND empty(!$input_file)) {
    $input_err = "Only ONE input option must be provided";
  }elseif (!empty($input)) {
  #~~~~~~~~~~~~~~~~~~~~~~~~ Get input Data from text box~~~~~~~~~~~~~~~~~~~~~~~
  # Create a temp file
  $temp_file = "temp.fa";
  $temp_fh = fopen($temp_file, "wt");

    # 1. FASTA files
    if (substr($input,0,1) == ">") {
      fwrite($temp_fh, $input);
    }else {
      # 2. UniProt IDs
      // $temp = tmpfile();
      # Obtain UniProt IDs from string => array
      $ids = explode("\r\n", $input);
      # Get files from uniprot
      foreach ($ids as $item) {
        $url = "https://www.uniprot.org/uniprot/".$item.".fasta";
        $file_name = $item.".fasta";
        $sequence = file_get_contents($url);
        # append each sequence to the temp file
        fwrite($temp_fh, $sequence);
      } # foreach
    } # else

  # 3. Get data from uploaded file. Check if it is uploaded correct
}elseif (!empty($input_file)) {
  $temp_file = $_FILES['UploadFile']['tmp_name'];
  }

  #~~~~~~~~~~~~~~~~~~~~~~~~~Run clustal Omega~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  # Delete previous results, if any
  delete_files($dir_results);

  $outfile = $dir_results."clustal_out.".$output_format;
  $cmd = "./clustalo --force -i ".$temp_file." -o ".$outfile." --outfmt ".$output_format;
  // echo "$cmd";
  exec($cmd, $output,$exit_code);

  #echo "Returned with status $exit_code\n";
  if (!empty($input)) {
    fclose($temp_fh);
  }
} # if-isset

#~~~~~~~~~~~~~~~~~~~~~~~ FUNCTIONS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
function test_input($data) {
  # Strip extra space, tab and newline
  $data = trim($data);
  # Remove backslashes from the user input data
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function delete_files($dir_path){
  # get all filenames
  $path = $dir_path."*";
  $files = glob($path);

  if (!empty($files)) {
    # Iterate and delete files
    foreach($files as $file){
      unlink($file);
    }
  }
}

 ?>
