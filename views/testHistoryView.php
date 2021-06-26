<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" media="all">
    <title>Historique des tests</title>
</head>

<body>
    <main class="container mt-4">
        <?php
        $navTitle = "HISTORIQUE DE TESTS";
        include("views/nav.php");
        ?>
            <div class="columns is-multiline">
    <? foreach ($datas as $data): ?>

    

           
            <div class="column is-half">
            <a href='http://localhost:1597/tests/<?= $data["id"]?>'>
        <div class="notification has-text-centered <?= $data["has_product_passed_test"] ? 'is-success' : 'is-danger' ?>">
            <p> NOM DU GROUPE DE TESTS :</p>
            <?= $data["name"] ?>
    
        <div class="box">
            <p>RÉFÉRENCE EMPLOYÉ :</p>
            <?= $data["reference_employee"] ?>

            <br>

            <p>NOM DU PRODUIT :</p>
            <?= $data["pname"] ?>
        </div>
        </div>
        </a>
        </div>
       
      
     

    <? endforeach; ?>
    </div>
</body>

</html>