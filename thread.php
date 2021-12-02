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
        $get_sql = "SELECT * FROM `threads` WHERE `thread_id`=$id";
        $result = mysqli_query($connection, $get_sql);
        $row = mysqli_fetch_assoc($result);
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        $select_sql = "SELECT `user_name` FROM `users` WHERE `user_id`=$thread_user_id";
        $res = mysqli_query($connection, $select_sql);
        $user_name = mysqli_fetch_assoc($res)['user_name'];
    ?>

    <?php
        $success = false;
        $error = false;
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $comment_text = $_POST['coment'];
            $comment_text = str_replace('<','&lt;', $comment_text);
            $comment_text = str_replace('>','&gt;', $comment_text);
            $user_id = $_SESSION['userId'];
            $insert_sql = "INSERT INTO `comments` (`comment_text`, `thread_id`, `user_id`) VALUES ('$comment_text','$id','$user_id')";
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
            <h1 class="display-4"><?php echo $title ?></h1>
            <p class="lead"><?php echo $desc ?></p>
            <hr class="my-4">
            <p class='fs-6'>No Spam / Advertising / Self-promote in the forums. Do not post copyright-infringing
                material. Do not
                post “offensive” posts, links or images. Do not cross post questions. Do not PM users asking for help.
                Remain respectful of other members at all times.</p>
            <p>Posted by <b><?php echo $user_name ?></b></p>
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
        echo '  
                <h2>Post a suggestion</h2>
                <form action="'.$_SERVER["REQUEST_URI"] .'" method="post">
                    <div class="mb-3">
                        <label for="exampleInputDesc1" class="form-label">Suggest an answer</label>
                        <textarea name="coment" class="form-control" aria-label="With textarea" rows="5"
                            id="exampleInputDesc1"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Post</button>
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
        <h1 class='py-2'>Discussion</h1>
        <?php
            $id = $_GET['id'];
            $get_sql = "SELECT * FROM `comments` WHERE `thread_id`=$id ORDER BY `timestamp` DESC";
            $result = mysqli_query($connection, $get_sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $id = $row['comment_id'];
                $comment = $row['comment_text'];
                $time = $row['timestamp'];
                $user_id = $row['user_id'];
                $select_sql = "SELECT `user_name` FROM `users` WHERE `user_id`=$user_id";
                $res = mysqli_query($connection, $select_sql);
                $user_name = mysqli_fetch_assoc($res)['user_name'];
                echo '
                    <div class="media my-3 d-flex align-items-center">
                        <img src="images/person.jpg" width="50px" style="border-radius: 50%;" alt="Generic placeholder image">
                        <div class="media-body mx-3">
                            <p class="mt-0 mb-0 fs-5">'.$comment.'</p>
                            <b>By '.$user_name.'</b><span class="fs-6 fw-light"> at '.$time.'</span>
                        </div>
                    </div>
                ';
            }
            if($noResult) {
                echo '
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">No Answer</p>
                            <p class="lead">Be the first person to answer this thread.</p>
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