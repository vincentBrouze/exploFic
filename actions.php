<?php
require('vues.php');
function update_hierarchie($dir) {
  print_hierarchie($dir);
}

function update_lst($dir, $tri, $ordre) {
  print_ls($dir, $tri, $ordre);
}

function update_page($dir, $tri, $ordre) {
  
}

$dir='/';
if (isset($_GET['dir'])) {
  $dir = $_GET['dir'];
}

$tri='nom';
if (isset($_GET['tri'])) {
  $tri = $_GET['tri'];
}

$ordre='asc';
if (isset($_GET['ordre'])) {
  $ordre = $_GET['ordre'];
}

if (isset($_GET['hier'])) {
  if ($_GET['hier'] == 'exp')
    update_hierarchie($dir);
  if ($_GET['hier'] == 'ret')
    update_hierarchie(dirname($dir));
}

if (isset($_GET['lst'])) {
  update_lst($dir, $tri, $ordre);
}

?>