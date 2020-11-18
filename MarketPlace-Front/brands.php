<?php
session_start();

//Inclusion de la connexion à la base
require_once('../connect.php');

//requète
$sql = 'SELECT * FROM `brands`';

//préparation de la requête
$query = $db->prepare($sql);

//exécution de la requête

$query->execute();

//Stockage du résultat dans un tableau associatif 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('../close.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marques</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

</head>
<body>
<nav>
            <div id="mainLogo">
                <img src="img/logo.png" alt="logo de la société Simplon.co">
            </div>
            <ul id="navigationBar">
                <li><a href="../index.php"> Accueil</a></li>
                <li><a href="brands_details.php">Catégories</a></li>
                <li><a href="sellers_details.php">Vendeurs</a></li>
                <li><a href="../index2.php">Connexion</a></li>
            </ul>
        </nav>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <table class="table">
                    <?php
                        if(!empty($_SESSION['erreur'])){
                            echo'<div class ="alert alert-danger" role= "alert">'. $_SESSION['erreur'].'
                            </div>';
                            $_SESSION['erreur']='';
                        }
                    ?>
                    <?php
                        if(!empty($_SESSION['message'])){
                            echo'<div class ="alert alert-success" role= "alert">'. $_SESSION['message'].'
                            </div>';
                            $_SESSION['message']='';
                        }
                    ?>
                    
                    <header>
                        <h2>Liste des Marques</h2>
                    </header>
                    <thead>
                        <th>Nom</th>
                    </thead>
                    <tbody>
                        <?php
                        //Boucle sur la variable result
                            foreach($result as $brands){
                        ?>
                            <tr>
                                <td><a href="brands_details.php?id=<?php echo $brands['brand_id']?>"><?php echo $brands['brand_name'] ?></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
    <footer>
              <a href="">Simplon Market Place</a>
    </footer>
</body>
</html>