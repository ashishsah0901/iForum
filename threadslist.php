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

    <?php
        $id = $_GET['id'];
        $get_sql = "SELECT * FROM `category` WHERE `category_id`=$id";
        $result = mysqli_query($connection, $get_sql);
        while($row = mysqli_fetch_assoc($result)) {
            $categoryName = $row['category_name'];
            $categoryDesription = $row['category_description'];
        }
    ?>

    <?php
        $success = false;
        $error = false;
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $thread_title = $_POST['title'];
            $thread_desc = $_POST['desc'];
            $user_id = $_SESSION['userId'];
            $thread_title = str_replace('<', '&lt;', $thread_title);
            $thread_title = str_replace('>', '&gt;', $thread_title);
            $thread_desc = str_replace('<', '&lt;', $thread_desc);
            $thread_desc = str_replace('>', '&gt;', $thread_desc);
            $insert_sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES ('$thread_title', '$thread_desc', '$id', '$user_id')";
            $result = mysqli_query($connection, $insert_sql);
            if($result) {
                $success = true;
            } else {
                $error = true;
            }
        }
    ?>

    <div class="container my-3">
        <div class="jumbotron p-4 rounded" style="background-color: #E9ECEF;">
            <h1 class="display-4">Welcome to <?php echo $categoryName ?> forum!</h1>
            <p class="lead"><?php echo $categoryDesription ?></p>
            <hr class="my-4">
            <p class='fs-6'>No Spam / Advertising / Self-promote in the forums. Do not post copyright-infringing
                material. Do not
                post “offensive” posts, links or images. Do not cross post questions. Do not PM users asking for help.
                Remain respectful of other members at all times.</p>
            <p class="lead">
                <a class="btn btn-success" href="#" role="button">Add Thread</a>
            </p>
        </div>
    </div>

    <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                echo '<div class="container">';
                        if($success) {
                            echo '<p class="text-success">Successfully added a new thread</p>';
                        }
                        if($error) {
                            echo '<p class="text-danger">Some error occured</p>';
                        }
                    echo '<h2>Ask a question</h2>
                    <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                        <div class="mb-3">
                            <label for="exampleInputProblem1" class="form-label">Problem statement</label>
                            <input name="title" type="text" class="form-control" id="exampleInputProblem1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputDesc1" class="form-label">Explain your problem</label>
                            <textarea name="desc" class="form-control" aria-label="With textarea" rows="5"
                                id="exampleInputDesc1"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                    </div>';
    } else {
    echo '
    <div class="container">
        <p class="lead">Please login to start a new thread</p>
    </div>
    ';
    }
    ?>

    <div class="container flex-grow-1">
        <h1 class='py-2'>Browse questions</h1>
        <?php
            $id = $_GET['id'];
            $get_sql = "SELECT * FROM `threads` WHERE `thread_cat_id`=$id ORDER BY `timestamp` DESC";
            $result = mysqli_query($connection, $get_sql);
            $noResults = true;
            while($row = mysqli_fetch_assoc($result)) {
                $noResults = false;
                $id = $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $time = $row['timestamp'];
                $thread_user_id = $row['thread_user_id'];
                $select_sql = "SELECT `user_name` FROM `users` WHERE `user_id`=$thread_user_id";
                $res = mysqli_query($connection, $select_sql);
                $user_name = mysqli_fetch_assoc($res)['user_name'];
                echo '
                    <div class="media my-3 d-flex align-items-center">
                        <img src="images/person.jpg" width="50px" style="border-radius: 50%;" alt="Generic placeholder image">
                        <div class="media-body mx-3">
                            <a class="text-dark text-decoration-none" href="thread.php?id='.$id.'">
                                <h5 class="mt-0 mb-0">'.$title.'</h5>
                                <b>By '.$user_name.'</b><span class="fs-6 fw-light"> at '.$time.'</span><br/>'.$desc.'
                            </a>
                        </div>
                    </div>
                ';
            }
            if($noResults) {
                echo '
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">No Threads</p>
                            <p class="lead">Be the first person to create a thread.</p>
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