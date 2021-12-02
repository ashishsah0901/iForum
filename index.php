<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>iForum - Welcome to online forum</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/image1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/image2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/image3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <?php
        if(isset($_GET['error'])) {
            echo '<p class="text-center text-danger">'.$_GET['error'].'</p>';
        }
    ?>
    <div class="container my-3 flex-grow-1">
        <h2 class='text-center'>iForum - Categories</h2>
        <div class="row">
            <?php
                $get_sql = "SELECT * FROM `category` ORDER BY `timestamp` DESC";
                $result = mysqli_query($connection, $get_sql);
                while($row = mysqli_fetch_assoc($result)) {
                    $category_name = $row['category_name'];
                    $category_description = $row['category_description'];
                    $category_id = $row['category_id'];
                    echo '
                        <div class="col-md-4">
                            <div class="card my-2" style="width: 18rem;">
                                <img src="images/'.$category_name.'.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">'.$category_name.'</h5>
                                    <p class="card-text">'.substr($category_description, 0, 110).'...</p>
                                    <a href="threadslist.php?id='.$category_id.'" class="btn btn-success">View threads</a>
                                </div>
                            </div>
                        </div>
                    ';
                }
            ?>

        </div>
    </div>
    <?php include 'partials/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>