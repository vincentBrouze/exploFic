<?php
require('vues.php');

if (isset($_GET['dir'])) {
  $rep = $_GET['dir'];
}  else {
  $rep = getcwd();
}

$tri = 'nom';
if (isset($_GET['tri'])) {
  $tri = $_GET['tri'];
}
$ordre='asc';
if (isset($_GET['ordre'])) {
  $ordre = $_GET['ordre'];
}

?>
<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
    <title>Explorateur de fichiers</title>
  </head>
  <body>
  <header>
  <h1>Explorateur de Fichiers</h1>
</header>
   <main class="container">

  <section class="row">
  <!-- Explorateur -->
  <aside id="art-hier" class="col-sm-4">
  <article>
  <h2>Explorer les répertoires</h2>
<?php
  echo '<ul id="hier" >';
  print_hierarchie($rep);
  echo '</ul>';
echo '</article></aside>';
  echo "<article id='lst' class='col-sm-8'><h2>$rep</h2>";
  print_ls($rep, $tri, $ordre);
  echo "</article>";
?>
</section>
</main>

<script src='jquery-3.3.1.min.js'></script>
<script src='controle.js'></script>
</body>

</html>