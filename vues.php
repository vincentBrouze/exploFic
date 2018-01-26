<?php
error_reporting(E_ERROR | E_PARSE);

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

/* */
function print_lev($current, $path, $i) {
  $dir = scandir($current);

  foreach ($dir as $idx => $nom) {
    if ($i >= count($path)) {
      if (is_dir($current.'/'.$nom) && $nom != '.' && $nom != '..' ) {
	if ($current !='/') 
	  echo "<li><a href='#' data-path='$current/$nom' class='expand-dir'>+</a> <a href='index.php?dir=$current/$nom'>$nom</a></li>";
	else echo "<li><a href='#' data-path='/$nom' class='expand-dir'>+</a> <a href='index.php?dir=/$nom'>$nom</a></li>";
      }
    } else if ($nom == $path[$i]) {
      //echo "<li><strong>-$nom</strong></li>";
      if ($i  < count($path)) {
	echo "<li><strong><a href='#' data-path='$current/$nom' class='ret-dir'>-</a> $nom</strong></li>";
	echo "<ul>";
	if ($current !='/') print_lev($current.'/'.$nom, $path, $i+1); 
	else print_lev('/'.$nom, $path, $i+1); 
	echo "</ul>";
      } else {
	echo "<li><strong>$nom</strong></li>";
	
      }
    } else if (is_dir($current.'/'.$nom) && $nom != '.' && $nom != '..' ) {
      if ($current !='/') 
	echo "<li><a href='#' data-path='$current/$nom' class='expand-dir'>+</a> <a class='update-lst' data-path='$current/$nom' href='index.php?dir=$current/$nom'>$nom</a></li>";
      else echo "<li><a href='#' data-path='/$nom' class='expand-dir'>+</a> <a class='update-lst'  data-path='$current/$nom' href='index.php?dir=/$nom'>$nom</a></li>";
    }
  }
}

/* */
function print_hierarchie($rep) {
  /* Impression de la hierarchie des repertoires */
  $sousReps = explode('/', $rep);
  
  print_lev('/', $sousReps, 1);
}

/* Retourne la bonne fonction de comparaison entre 
   deux fichiers, en fonction du critere et de l'ordre
*/
function comp_fic($tri, $ordre) {
  if (($tri == 'nom' || $tri == 'type') && $ordre == 'asc') {
    return function($a, $b) use($tri) {
      return strcmp($a[$tri], $b[$tri]);
    };  
  } else if (($tri == 'nom' || $tri == 'type') && $ordre == 'desc') {
    return function($a, $b) use($tri) {
      return strcmp($b[$tri], $a[$tri]);
    };
  } else if (($tri == 'taille' || $tri == 'date') && $ordre == 'desc') {
    return function($a, $b) use($tri) {
      return $b[$tri] - $a[$tri];
    };    
  }
  else if (($tri == 'taille' || $tri == 'date') && $ordre == 'asc') {
    return function($a, $b) use($tri) {
      return $a[$tri] - $b[$tri];
    };    
  }
}

function build_tab($rep, $dir, $tri, $ordre) {
  $lst = array();
  $i = 0;

  /* Parcourt le répertoire pour 
     construire un tableau
  */
  foreach ($dir as $idx => $nom) {
    $nomComp = $rep.'/'.$nom;
    $infos = stat($nomComp);
    $type = mime_content_type($nomComp);

    $lst[$i]['nom'] = $nom;
    $lst[$i]['type'] =  mime_content_type($nomComp);
    $lst[$i]['taille'] = $infos["size"];
    $lst[$i]['date'] = $infos["mtime"];
    $i++;
  }
  /* Trie le tableau en fonction des critères donnés */
  usort($lst, comp_fic($tri, $ordre));
  return $lst;
}


/* Imprime la liste des fichiers du répertoire */
function print_ls($rep, $tri = 'nom', $ordre = 'asc') {
  $lst = build_tab($rep, scandir($rep), 'date', 'desc');
  
  /*print_r($lst);*/


  if ($dir = scandir($rep)) {
    $lst = build_tab($rep, scandir($rep), $tri, $ordre);
    
    echo "<table class='table'>";
    echo "<thead><tr><th><a class='sort-lst' data-path='$rep' data-tri='nom' href='index.php?dir=$rep&tri=nom'>Nom</a></th><th><a class='sort-lst' data-path='$rep' data-tri='taille' href='index.php?dir=$rep&tri=taille'>Taille</a></th><th><a class='sort-lst' data-path='$rep' data-tri='type' href='index.php?dir=$rep&tri=type'>Type</a></th><th><a class='sort-lst' data-path='$rep' data-tri='date' href='index.php?dir=$rep&tri=date'>Dernière modification</th></tr></thead>";
     foreach ($lst as $idx => $elem) {
       $nom = $elem['nom'];
       $type = $elem['type'];
       $date = gmdate("d/m/Y H:i:s", $elem["date"]);
       $taille = human_filesize($elem['taille']);

       $nomComp = $rep.'/'.$nom;
       if ($nom != '.' && $nom != '..') {
	 echo "<tr>";
	 if ($type == "directory") {
	   if ($rep != '/') 
	     echo "<td><a class='update-lst' data-path='$rep/$nom' href='#'index.php?dir=$rep/$nom'>$nom</a></td>";
	   else echo "<td><a class='update-lst' data-path='/$nom' href='index.php?dir=/$nom'>$nom</a></td>";
	 }
	 else echo "<td>$nom</td>";
	 echo "<td>".$taille."</td><td>".$type."</td><td>". $date."</td></tr>";
       }
     }
     echo "</table>";
  } else {
    echo "Erreur d'ouverture du répertoire $rep.";
  }
}
?>