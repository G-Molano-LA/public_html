<?php
# define variables and set to empty values
$input = $input_file = $output_format = "";
$input_err = $outfmt_err = "";

# Create a temp file
$temp_file = "temp.fa";
$temp_fh = fopen($temp_file, "a");

# get the field when the search bottom is press
if (isset($_POST['submit'])){
  # Get variables from post method
  $input         = test_input($_POST['FASTA']);
  $input_file    = test_input($_POST['upload_file']);
  $output_format = test_input($_POST['output_format']);


  #~~~~~~~~~~~~~~~~~~~~~~~~~Check the required fields~~~~~~~~~~~~~~~~~~~~~~~~~~~
  if (empty($input) AND empty($input_file)) {
    $input_err = "One input option must be provided";
  }elseif (!empty($input) AND empty(!$input_file)) {
    $input_err = "Only ONE input option must be provided";
  }elseif (!empty($input)) {
  #~~~~~~~~~~~~~~~~~~~~~~~~ Get input Data from text box~~~~~~~~~~~~~~~~~~~~~~~

    # 1. FASTA files
    if (str_starts_with($input, ">")) {
      # fasta file as input
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

    # redirect to another page
    header('location:clustal_results.php');
    exit();

  } # elseif
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


 ?>
