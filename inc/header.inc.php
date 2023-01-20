<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaKam</title>
      <!-- bootswatch -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.3/quartz/bootstrap.min.css" integrity="sha512-3qm29Ouc1OmoMoeJlbg5vEOYakc9MqIWAgDVuB/TJeuqFGftnZyE9S+AP+3TGeYIkPYt6CWz5JdiKkvcZ2qHPg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <!-- bootsrap CDN -->
  <!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<style>
  .hover-zoom:hover{
    transform: 0.3s;
    background-color:rgba(255, 217, 0, 0.42);
  }
  ion-icon{
    position: relative;
    top: 5px;
  }
 
  .star_input{
  /*  visibility: hidden; */
  position: relative;
  left: 34px;
  cursor: pointer;
  opacity: 0;
  width: 15px;
  height: 15px;
  top: 3px;
  }
  
</style>
<body>
  <?php require_once 'init.inc.php' ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid" bis_skin_checked="1">
    <a class="navbar-brand" href="<?=BASE;?>">BIJOUTERIE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01" bis_skin_checked="1">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="<?=BASE;?>">Accueil
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <?php if (admin()): ?>
        <li class="nav-item dropdown"> 
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Admin</a>
          <div class="dropdown-menu" bis_skin_checked="1">
            <a class="dropdown-item" href="<?=BASE.'back/formulaireProduit.php';?>">Ajouter produit</a>
            <a class="dropdown-item" href="<?=  BASE. 'back/gestionProduit.php' ; ?>">Gestion produits</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div class="dropdown-divider" bis_skin_checked="1"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </li>
        <?php endif; ?>
      </ul>
    <!--<form class="d-flex">
        <input class="form-control me-sm-2" type="search" placeholder="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form> -->
      <?php if(!connect()): ?>
      <a href="<?= BASE. 'security/inscription.php' ; ?>" class="btn btn-secondary me-2">Inscription</a>
      <a href="<?= BASE.'security/connexion.php' ; ?>" class="btn btn-info me-2">Connexion</a>
      <?php else:  ?>
         <a href='<?= BASE.'?action=deco' ; ?>' class="btn btn-info me-2">Déconnexion</a>
      <?php endif ?>
    </div>
  </div>
</nav>
<div class="container p-4">
<?php
 if(isset($_SESSION['messages'])&& !empty($_SESSION['messages'])):
  foreach($_SESSION['messages'] as $type=> $msgs):
    foreach($msgs as $key=>$message):
?>
 <div class="alert alert-dismissible alert-<?=$type ; ?>" bis_skin_checked="1">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <?= $message ; ?>
</div>
<?php 
 unset($_SESSION['messages'][$type][$key]);
 endforeach;
 endforeach;
 endif;
?>