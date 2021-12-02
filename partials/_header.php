<?php
    session_start();
    echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/forum">iForum</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/forum">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Top Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    $get_sql = "SELECT * FROM `category` LIMIT 3";
                    $result = mysqli_query($connection, $get_sql);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<li><a class="dropdown-item" href="threadslist.php?id='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
                    }
                    echo '</ul>
                </li>
            </ul>
            <div class="mx-2 d-flex">
                <form class="d-flex" method="get" action="search.php">
                    <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>';

                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                    echo '<p class="text-light fs-6 my-auto mx-2">Welcome '.$_SESSION['userName'].'</p><form method="post" action="_auth.php"><input name="logout" type="submit" value="Logout" class="btn btn-outline-success mx-2"></input></form>';
                } else {
                    echo '<button type="button" class="btn btn-outline-success mx-2" data-bs-toggle="modal"
                    data-bs-target="#loginModal">Login</button>
                    <button type="button" class="btn btn-outline-success mr-2" data-bs-toggle="modal"
                    data-bs-target="#signupModal">Sign up</button>';
                }
            echo '</div>
        </div>
    </div>
</nav>';
    include 'partials/_loginModal.php';
    include 'partials/_signupModal.php';
?>