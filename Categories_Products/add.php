<?php
session_start();

if($_POST){
    if(isset($_POST['category_id']) && !empty($_POST['category_id'])
    && isset($_POST['product_id']) && !empty($_POST['product_id'])){
        //Inclusion de la connexion à la base
        require_once('../connect.php');
        //supprimer les balises de l'URL envoyé
        $categoryID = strip_tags($_POST['category_id']);
        $productID = strip_tags($_POST['product_id']);


        $sql = 'INSERT INTO `categories_products`(`product_id`,`category_id`) VALUES(:product_id, :category_id)';


        $query = $db->prepare($sql);

        $query->bindValue(':category_id',$categoryID,PDO::PARAM_INT);
        $query->bindValue(':product_id',$productID,PDO::PARAM_INT);


        $query->execute();
        $_SESSION['message'] = "Liason Ajouté";
        require_once('../close.php');


        // header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Liaison</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo'<div class ="alert alert-danger" role= "alert">'. $_SESSION['erreur'].'
                        </div>';
                        $_SESSION['erreur']='';
                    }
                ?>
                <h1>Ajouter une Liaison</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="category_id">ID de la categorie</label>
                        <input type="text" name="category_id" id="category_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="product_id">ID du produit</label>
                        <input type="text" name="product_id" id="product_id" class="form-control">
                    </div>

                    <button class="btn btn-primary">Valider</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>