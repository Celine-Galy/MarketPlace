<?php
include('config.inc.php');
include('connexion.inc.php');
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style/main.css">
        <title>Simplon Market Place</title>
    </head>
    <body>
        <nav>
            <div id="mainLogo">
                <img src="img/logo.png" alt="logo de la société Simplon.co">
            </div>
            <ul id="navigationBar">
                <li><a href=""> Accueil</a></li>
                <li><a href="MarketPlace-Front/brands_details.php">Catégories</a></li>
                <li><a href="MarketPlace-Front/sellers_details.php">Vendeurs</a></li>
                <li><a href="index2.php">Connexion</a></li>
            </ul>
        </nav>
        <header>
            <video autoplay="" muted="" loop="" class="myVideo">
                <source src="img/video.mp4" type="video/mp4">
            </video>
        </header>
        <section class="allProduct">
        <?php
                $maRequete = 'SELECT * FROM products 
                INNER JOIN products_sellers ON products_sellers.product_id = products.product_id
                INNER JOIN categories_products ON categories_products.product_id = products.product_id
                INNER JOIN categories ON categories.category_id = categories_products.category_id';


                if ($result = $mysqli->query($maRequete)) :
                    while ($objproduct = $result->fetch_object()) :
                ?>
                        <div class="card">
                            <img src="img/bilbo.jpg" alt="bilbo" style="width:100%">
                            <h3><?php echo $objproduct->product_name; ?></h3>
                            <p class="price"><?php echo $objproduct->product_priceHT; ?>€</p>
                            <p><?php echo $objproduct->product_longDescription; ?></p>
                            <p><button>ajouter au panier</button></p>
                        </div>
                        <?php
                    endwhile;

                    $result->close();
                else :
        ?>
    
      
        
          <?php
                endif;

?>
    </section>
  <footer>
              <a href="">Simplon Market Place</a>
    </footer>
    </body>
    
   
</html>