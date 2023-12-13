<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Oswald:wght@200;300;400;500;600;700&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        :root {
            --blue: #EF99A3;
            --white: #fff;
            --grey: #f5f5f5;
            --black1: #222;
            --black2: #999;
        }
        
        .wave {
            position: fixed;
            height: 100%;
            left: 0;
            bottom: 0;
            z-index: -1;
        }
        .avtar {
            width: 100px;
        }

        .login-container {
            display: flex;
            align-items: center;
            text-align: center;
        }

        form {
            width: 360px;
        }

        form h2 {
            font-size: 2.9rem;
            text-transform: uppercase;
            margin: 15px 0;
            color: #333;
        }

        .input-div {
            display: grid;
            grid-template-columns: 7% 93%;
            margin: 25px 0;
            padding: 5px 0;
            border-bottom: 2px solid #d9d9d9;
        }

        .input-div.one {
            margin-top: 0;
        }

        .input-div.two {
            margin-bottom: 4px;
        }

        .icon {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .icon i {
            color: #d9d9d9;
            
        }

        .input-div>div {
            position: relative;
            height: 45px;
        }

        .input-div>div h5 {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
            transition: .3s;
        }

        .input {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border: none;
            outline: none;
            background: none;
            padding: 0.5rem 0.7rem;
            font-size: 1.2rem;
            font-family: 'Poppins', sans-serif;
            color: #555;
        }

        .login-container a {
            display: block;

            text-decoration: none !important;
            color: #999 !important;
            font-size: 0.9rem !important;
            transition: .3s;
        }

        @media only screen and (max-width:767px){
            .login-container{
                position: absolute;
                top: 0px;
                bottom: 0;
                left: 0;
                right: 0;
                justify-content: center;
                margin: auto 0;
            }
            .login-container form{
                box-shadow: 0 1rem 5rem rgba(132, 139, 200, 0.18);
                width: 360px;
                padding: 15px;
                border-radius: 10px;
            }
            .login-img{
                opacity: 0.1;
            }
        }
    </style>


</head>

<body>
    <!-- <?php
    if (isset($_SESSION['uname'])) {
        header('location:Pages/dashboard.php');
    }
    ?> -->
    
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="login-img">
                    <img class="img vh-100 w-100" src="images/login-img.png" alt="">
                </div>
            </div>
            <div class="col-md-4">
                <div class="login-container">
                    <form action="login_db.php" method="post" id="login">
                        <img class="avtar" src="images/avtar.png" alt="">
                        <h2>Welcome</h2>
                        <div class="input-div one">
                            <div class="user-icon icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <input class="input" placeholder="Enter UserID" type="text" autocomplete="off" name="empid">
                            </div>
                        </div>
                        <div class="input-div two">
                            <div class="password-icon icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div>
                                <input class="input" type="password" placeholder="Enter Password" name="pwd">
                            </div>
                        </div>
                        <input type="submit" class="btn mt-4 px-5 rounded-pill text-white fw-bold" style="background: #61D2C0;" name="login" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>