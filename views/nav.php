<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
    <title><?= $navTitle ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" integrity="sha512-VCHVc5miKoln972iJPvkQrUYYq7XpxXzvqNfiul1H4aZDwGBGC0lq373KNleaB2LpnC2a/iNfE5zoRYmB4TRDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <!-- Main container -->
    <nav class="level">
        <!-- Left side -->
        <div class="level-left">
            <?php
            if ($_SERVER["REQUEST_URI"] !== "/") {
            ?>
                <div class="level-item">
                    <p class="subtitle is-3">
                        <a href="http://localhost:1597/">
                            <span class="icon">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                        </a>
                    </p>
                </div>

            <?php
            }
            ?>
            <div class="level-item">
                <p class="title"><?= $navTitle ?></p>
            </div>
        </div>

        <!-- Right side -->
        <div class="level-right">
            <div class="level-item">
                <p class="subtitle is-3">
                    <span class="icon">
                        <i class="fas fa-user-cog"></i>
                    </span>
                </p>
            </div>
            <p class="level-item"><strong>serial #</strong></p>
            <div class="level-item">
                <p class="subtitle is-3">
                    <a href="http://localhost:1597/logout">
                        <span class="icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                    </a>
                </p>
            </div>
        </div>
    </nav>