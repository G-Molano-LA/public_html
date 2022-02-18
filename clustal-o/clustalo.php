<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" style="width:100%; height:500px;">
  <meta name="description" content="">
  <meta name="author" content="G.Molano, LA">

  <title>Alejandra Gonzalez | Clustal Omega</title>



  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
  <!-- Custom styles for this template -->
  <link href="../css/cover.css" rel="stylesheet">
  <!--social network icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <!-- Favicon file need this: -->
  <link rel="shortcut icon" href="#">

  <style>
  .sequence-format{
    font-family: unset;
  }
  </style>

  <!-- Include php file -->
  <?php
  # Show php errors
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require '../clustal-o/execution.php';
   ?>

 </head>

 <!-- ############################### PAGE STARTS HERE ##################### -->

 <!-- Background color, text centered  -->
<body class="d-flex h-100">

<!-- Cover container -->
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~HEADER ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<header class="p-3 my-md-2 bg-white">
  <div class="container-fluid">
    <p class="masthead-brand text-dark">
      <img src="../images/Piecito.webp" alt="Diplodocus Logo"
          width="40" class="d-inline-block align top"/>
          My Personal Web Page
    </p>
    <nav class="nav nav-masthead justify-content-center float-lg-end">
      <a class="nav-link text-dark" aria-current="page" href="../index.html">Home</a>
      <a class="nav-link text-dark" href="about_me.html">About Me</a>
      <a class="nav-link text-dark" href="curriculum.html">Curriculum</a>
      <a class="nav-link text-dark active" href="projects.html">Projects</a>
    </nav>
  </div>
</header>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~FORM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div class="card clustal-card">
  <h5 class="text-center mb-4">Clustal Omega</h5>
  <form class="form-card"  method="POST" enctype="multipart/form-data" id="ClustalForm">
    <!-- Input Options -->
    <h5 class="font-weight-bold">Input Options
      <!-- Display error message -->
      <span class="error"> * <?php echo $input_err; ?></span>
    </h5>
    <hr></hr>
      <!-- Protein Sequences in FASTA or UniProt IDs-->
      <div class="row justify-content-between text-left">
          <div class="form-group col-sm-6 flex-column d-flex">
            <label class="form-control-label">Enter FASTA sequences or UniProt IDs</label>
            <textarea class="sequence-format" name="FASTA" rows="4" cols="100" style="font-family:monospace;"></textarea>
          </div>
      </div>
      <!--- Upload File -->
      <div class="row justify-content-between text-left">
        <div class="col-sm-6 flex-column d-flex">
          <p class="form-control-label">Or, Upload FASTA File</p>
          <label class="custom-file-label" for="UploadFile">Choose file</label>
          <input type="file" name="UploadFile" class="custom-file-input" id="UploadFile">
        </div>
      </div>

    <!-- Output Options -->
    <h5 class="font-weight-bold">Output Options</h5>
    <hr></hr>
    <div class="form-group">
      <label for="output_format">Select the output format</label>
      <!-- Display error message -->
      <span class="error"> * <?php echo $outfmt_err; ?></span>
      <select multiple class="form-control" id="output_format" name="output_format">
        <option selected>fasta</option>upload_file
        <option>clustal</option>
        <option>msf</option>
        <option>phylip</option>
        <option>selex</option>
        <option>stockholm</option>
        <option>vienna</option>
      </select>
    </div>

    <!-- Submit Button -->
    <div class="row justify-content-between">
        <div class="form-group col-sm-6">
          <button class="btn" name="clear">Clear</button>
          <a href="#ClustalOutput"><button type="submit" class="btn btn-primary"
            name="submit" onClick="redirect_output()">Submit</button></a>
        </div>
    </div>
  </form>
</div> <!-- ./card -->

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~RESULTS~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

<!-- Check if clustal execution was performed correcly -->
<?php
if (isset($exit_code)) {?>
  <div class="card clustal-card sequence-format" id = "ClustalOutput" name="ClustalOutput">
  <?php if ($exit_code != 0) {
    echo "Ups, an error ocurred";
    exit();
  }?>
  <h5 class="text-center mb-4"><?php echo "RESULTS"; ?></h5>
  <!-- CLEAR AND DOWNLOAD RESULT BUTTONS -->
  <div class="row justify-content-between">
      <div class="form-group col-sm-6">
        <a href="<?php echo $outfile; ?>" download = "<?php echo $outfile; ?>"
          class="btn btn-lg font-weight-bold" name = "dw-results" role="button" style="background-color:lightcoral">
          Download Results</a>
          <a href="#ClustalForm"><button class="btn btn-lg font-weight-bold"
            name="new_request" onClick = "redirect_new_request()">New Request</button></a>
      </div>
  <p style="font-family:monospace">
  <?php
    $fh = fopen( $outfile,'r');
    while (($line = fgets($fh)) ) {
      echo nl2br($line);
    }?>
  </p>
</div>

<?php
  # deleting the generated files
  if (file_exists($temp_file)) {
    unlink($temp_file);
    // unlink($outfile);
  }
}
 ?>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~FOOTER~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

<footer class="container py-2 text-dark">
  <hr></hr>
  <!-- Copyright and Terms -->
  <div class="row align-items-center justify-content-between">
    <div class="col text-left font-weight-dark">
        &copy; Copyright G.Molano, LA &REG; All rights reserved.
    </div>
    <div class="col text-right">
      <a href="https://linkedin.com/in/leidy-alejandra-gonzalez-molano-269867218" class="btn btn-social-icon btn-rounded text-dark"><i class="fab fa-linkedin-in"></i></a>
      <a href="https://github.com/G-Molano-LA"class="btn btn-social-icon btn-rounded text-dark"><i class="fab fa-github"></i></a>
      <a class="btn btn-social-icon btn-rounded text-dark"><i class="fab fa-twitter"></i></a>
      <a href="https://www.instagram.com/aleegm_8"class="btn btn-social-icon btn-rounded text-dark"><i class="fab fa-instagram"></i></a>
    </div>
  </div>
</footer>

<!-- ############################### PAGE ENDS HERE ############################################## -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Show file name on upload box -->
<script>
$('#UploadFile').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#UploadFile')[0].files[0].name;
  $(this).siblings(".custom-file-label").addClass("selected").html(file);
});
</script>

 <!-- Redirect to ClustalOutput container -->
 <script>
 function redirect_output(){
   location.href = "#ClustalOutput";
 }
</script>

 <!-- Create a new request -->
<script>
function redirect_new_request(){
  // redirect to form section
  location.href = "#ClustalForm";
  // refresh window and clear post information
  window.location.reload = window.location.href;
  // Delete output content
  document.getElementById('ClustalOutput').innerHTML=''
}
</script>


</body>
</html>
