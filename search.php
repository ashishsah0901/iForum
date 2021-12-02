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

    <div class="container my-3 flex-grow-1">
        <h3>Search results for <?php echo $_GET['query'] ?></h3>
        <?php
    $query = $_GET['query'];
        $search_sql = "SELECT * FROM `threads` WHERE MATCH (`thread_title`, `thread_desc`) AGAINST ('$query') LIMIT 10";
        $result = mysqli_query($connection, $search_sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $id = $row['thread_id'];
            echo '
                <div class="container">
                    <h5 class="my-0"><a href="thread.php?id='.$id.'" class="text-dark text-decoration-none">'.$title.'</a></h5>
                    <p>'.$desc.'</p>
                </div>
            ';
        }
        if($noResult) {
                echo '
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">Nothing matches</p>
                            <p class="lead">Try something else.</p>
                        </div>
                    </div>
                ';
            }
    ?>

    </div>

    <?php include 'partials/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>