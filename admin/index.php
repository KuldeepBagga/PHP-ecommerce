<?php
    require '../lib/config.php';
    $error="";
    if(isset($_POST['login']))
    {
        $email=$mysqli->real_escape_string($_POST['email']);
        $password=$mysqli->real_escape_string($_POST['password']);
        $userData=$mysqli->query("select * from user where email='$email' and active=1");     
        
        if($userData->num_rows>0)
        {
            $data=$userData->fetch_assoc();
            if($data['password'] and $data['email'])
            {
                if(password_verify($password,$data['password']))
                {
                        $_SESSION['user']['data']=[
                                "email"=>$data['email'],
                                "name" =>$data['name'],
                                "id"=>$data['id']
                            ];

                        setcookie("userid",$_SESSION['user']['data']['email']);
                        
                        header("location:dashboard.php");
                }
                else
                {
                    $error="<div class='alert alert-danger'>Email or password is not matched</div>";
                }
            }
        }
        else
        {
            $error="<div class='alert alert-danger'>Email or password is not matched</div>";
        }
    }
    if(!empty($_SESSION['user'])){
        header('location:dashboard.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container">

        <div class="card mt-5" style="width: 25rem; margin:auto;">
            <div class="card-header">Login</div>
            <div class="card-body">
                <?php echo $error;?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="text" class="form-control" placeholder="Email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>