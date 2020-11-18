<?php 
include('config.inc.php'); 
include('connexion.inc.php');

$product_id = $_GET['product_id'];

if(!empty($product_id)):

    $maRequete = 'DELETE FROM products WHERE product_id = '.$product_id;

    if ($result = $mysqli->query($maRequete)) :
    
        echo "suppression effectuée avec succès";
    header('Location:products.php');
    else :
        echo "erreur lors de l'exécution de la requete";
    endif;
else :
    echo "Attention la suppression n'a pas pu être effectué (identifiant vide)";
endif;

?>
