<?php
require ('config.php');
session_start();

$error = '';
$validate = '';

if (isset($_SESSION['username'])) header('Location: index.php');
if (isset($_POST['submit'])){
    $username = stripslashes($_POST['username']);
    $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    if (!empty(trim($username)) && !empty(trim($password))){
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn,$query);
        $rows = mysqli_num_rows($result);
        if ($rows != 0){
            $hash = mysqli_fetch_assoc($result)['password'];
            if (password_verify($password, $hash)&& $_SESSION['code'] == $_POST['Captcha']){
                $_SESSION['username'] = $username;
                header('Location: index.php');
            }
        } else{
            $error = 'Login user gagal';
        }
    } else{
        $error = 'Data tidak boleh kosong';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <title>Login</title>
</head>
<body style="background-color:LightPink">
    <section class="container-fluid mb-12">
        <section class="row justify-content-center">
            <section class="col-6">
                <form class="form-containerfluid mb-4" action="login.php" method="POST">
                    <h4 class="text-center">Sign Up</h4>
                        <?php if ($error != ''){ ?>
                            <div class="alert-danger" role="alert"><?= $error; ?></div>
                        <?php }?>
                    <div class = "form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                    </div>
                    <div class = "form-group">
                        <label for="InputPassword">Password</label>
                        <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Masukkan Password">
                        <?php if ($validate != ''){ ?>
                            <p class="text-danger"><?=$validate;?></p>
                        <?php }?>
                    </div>
                    <div class = "form-group">
                        <label for="Captcha">Captcha</label>
                        <td><img src="captcha.php" alt="gambar" /> </td>
                        <br>
                        <br>
                        <input type="Captcha" class="form-control" id="Captcha" name="Captcha" placeholder="Masukkan kode Captcha">
                                            <?php if ($validate != ''){ ?>
                            <p class="text-danger"><?=$validate;?></p>
                        <?php }?>
                    </div>
                    <button type="submit" name ="submit" class="btn btn-danger">Sign in</button>
                        <div class="form-footer mt-2">
                            <p>Belum Punya Akun? <a href="register.php">Register</a></p>
                        </div>
                </form>
            </section>
        </section>
    </section>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-98i/ X+965Dz00rT7abK41JStQIAqVgRVzpbzo5smXKp4YFRVH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBkOWLaUAdn689aCwoqbBJiSnjAK/18WVCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6Zbwh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTY" crossorigin="anonymous"></script>   
</body>
</html>             