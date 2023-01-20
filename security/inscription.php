<?php require_once '../inc/header.inc.php';

if (!empty($_POST)) {
    $error = false;
    $req =   executeRequete('SELECT * FROM user where email=:email', array(
        ':email'=>$_POST['email']
    ));
    if($req->rowCount()!== 0){
        $_SESSION['messages']['danger'][] = 'Un compte existe déjà à cette adresse mail';
        header('location:./inscription.php');
        exit();
    }
    $user = $req->fetch(PDO::FETCH_ASSOC);
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = '';
        if (empty($_POST['email'])) {
            $email.= 'le champ est obligatoire';
            $error = true;
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email.= 'L\'adresse mail est invalide';
            $error = true;
        }
    } // fin condition controle du surface email
    if (empty($_POST['password'])|| !password_strength_check($_POST['password'])) {
      $password = 'le mot de passe est obligatoire et doit comporter au min 4 caractéres 
      max 15 caractéres, 1 minuscule, 1 majuscule, 1 chiffre et 1 caractéres spécial ';
      $error = true;
    } // fin condition controle du surface password
    if (empty($_POST['confirmPassword'])|| $_POST['password'] !== $_POST['confirmPassword']) {
      $confirmPassword = 'la confarmation de mot de passe est obligatoire';
      $error = true;
    } // fin condition controle du surface Confirmpassword
    if (empty($_POST['username']) || strlen($_POST['username']<2) || strlen($_POST['username']<10)) {
      $username = 'le champ est obligatoire, min 2 caractéres et max 10 caractéres ';
      $error = true;
    } // fin condition controle du surface username
    if(!$error){
       $mdp = password_hash($_POST['password'], PASSWORD_BCRYPT);
       $s = executeRequete('INSERT  INTO user(email, password, username, role) values (:email, :password, :username, :role)', array(
        ':email'=>$_POST['email'],
        ':password'=>$mdp,
        ':username'=>$_POST['username'],
        ':role'=>'ROLE_USER',
       ));
       if(!$s){
        $_SESSION['messages']['danger'][] = 'Un probléme est survenue';
        header('location:./inscription.php');
        exit();
       }else{
        $_SESSION['messages']['success'][] = 'Vous êtes inscrits';
        header('location:./connexion.php');
        exit();
       }// message succes
    }//requete insert 
} // requete insert formulaire d'inscription
?>
<form method="post" action="">
    <section class="vh-100 " >
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Inscription</h2>
                                <label for="inputEmail">Email</label>
                                <input type="text" value="" name="email" id="inputEmail"
                                       class="form-control" autocomplete="email">
                                <span class="text-primary"><?=$email ?? '';?></span><br>
                                <label for="inputPassword" class="mt-3">Mot de passe</label>
                                <input type="password" name="password" id="inputPassword" class="form-control"
                                       autocomplete="current-password">
                                <span class="text-primary"><?=$password ?? '';?></span> <br>
                                <label for="inputPassword" class="mt-3">Confirmation de mot de passe</label>
                                <input type="password" name="confirmPassword" id="inputPassword" class="form-control"
                                       autocomplete="current-password">
                                <span class="text-primary"><?=$confirmPassword ?? '';?></span> <br>
                                <label for="inputPassword" class="mt-3">Pseudo</label>
                                <input type="text" name="username" id="inputPassword" class="form-control"
                                       autocomplete="current-password">
                                <span class="text-primary"><?=$username ?? '';?></span> <br>
                                <button class="btn mb-2 mt-3 mb-md-0 btn-outline-secondary btn-block" type="submit">
                                    Valider
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</form>
<?php require_once '../inc/footer.inc.php';?>


