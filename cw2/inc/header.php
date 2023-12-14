<!DOCTYPE html>
<html>

<head>
    <!-- <title>CW-2</title> -->
    <?php if (findTitle($_SERVER['PHP_SELF']) == "Index") : ?>
        <title><?php echo "Cousework 2"; ?></title>
    <?php else : ?>
        <title><?php echo findTitle($_SERVER['PHP_SELF']); ?></title>
    <?php endif; ?>

    <!-- <link rel="stylesheet" href="https://unpkg.com/mvp.css"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://www.w3schools.cn/lib/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="https://www.w3schools.cn/lib/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script> -->

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- <link rel="stylesheet" href="../css/mvp.css"> -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="/car.ico">

    <!-- <script src="js/script.js"></script> -->

</head>

<body>

    <!-- sidenav bar -->
    <div class="sidenav">
        <div class="closebtn" onclick="closeNav()"><a href="javascript:void(0)">×</a></div>
        <div class="search" onkeyup="searchMenu()"><input type="text" id="mySearch" placeholder="Search" title="Type in a category"></div>
        <ul id="myMenu">
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <!-- <li><a href="search_people.php"><i class="fa fa-fw fa-user"></i> People</a></li> -->
            <li><a href="search_people.php">People</a></li>

            <!-- <div class="dropdown">
                <button class="dropbtn">Dropdown
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div> -->

            <li><a href="search_vehicle.php">Vehicle</a></li>
            <li><a href="add_vehicle.php">AddVehicle</a></li>
            <li><a href="report.php">Report</a></li>

            <!-- 
            <div class="dropdown">
                <li><a class="dropbtn">Dropdown
                        <i class="fa fa-caret-down"></i>
                </li>
                <div class="dropdown-content">
                    <li><a href="#">Link 1</a></li>
                    <li><a href="#">Link 2</a></li>
                </div>
            </div> -->

            <?php
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'Administrator') {
            ?>
                <li><a href="fine.php">Fine</a></li>
                <li><a href="search_audit.php">Audit</a></li>
                <li><a href="add_police.php">Add Police User</a></li>
            <?php } else {
            } ?>

            <?php if (isset($_SESSION['username'])) { ?>
                <a href="logout.php" class="split">Logout</a>
            <?php } else { ?>
                <a href="login.php" class="split">Login</a>
            <?php } ?>
        </ul>
    </div>

    <main>
        <button class="openbtn" onclick="toggleNav()">☰</button>

        <!-- <h1>Coursework 2</h1> -->
        <?php if (findTitle($_SERVER['PHP_SELF']) == "Index") : ?>
            <h1><?php echo "Cousework 2"; ?></h1>
        <?php else : ?>
            <h1><?php echo findTitle($_SERVER['PHP_SELF']); ?></h1>
        <?php endif; ?>

        <?php if (isset($_SESSION['username'])) { ?>
            <p>Username: <strong> <?php echo "" . $_SESSION['username'] . "" ?></strong>. You can now operate. <a href='logout.php'>Logout</a></p>
        <?php } else { ?>
            <p>Please login first. <a href='login.php'>Login</a></p>
        <?php } ?>

        <?php require_once "inc/config.php"; ?>
        <hr>