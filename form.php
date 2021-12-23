<?php
      session_start();
      $host = "localhost";
      $username ="root";
      $password = "";
      $database = "users";
      $message  = "";
      try{
        $connection = new PDO("mysql:host=$host; dbname=$database",$username,$password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(isset($_POST["login"]))
        {
          if(empty($_POST["username"])  || empty($_POST["password"]))
          {
            $message = '<label>Tout les champs sont requis</label>';
          }
          else
          {
              $query = "SELECT * FROM users WHERE username = :username AND password = :password";
              $statement = $connection->prepare($query);
              $statement->execute(
                    array(
                        'username'=>$_POST["username"],
                        'password'=> $_POST["password"]
                            )
                            );
              $count = $statement->rowCount();
                if($count > 0){
                     $_SESSION["username"] = $_POST["username"];
                       header("location:login_success.php");
                                }
                                else
                                {
                                    $message = '<label>Login ou password incorrect</label>';
                                    }
          }
        }
      }
        catch(PDOException $error)
        {
          $message =$error->getMessage();
        }
    ?>
     <!DOCTYPE html>
     <html>
          <head>
               <title> CONNEXION</title>
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
          </head>
          <body>
               <br />
                <h3 align="center"> Login </h3><br />
                <h3 align="center" style="color: green;" >FORMULAIRE DE CONNEXION</h3>
               <div class="container" style="width:500px; height: 240px; border: 2px solid red; margin-top: 3px;">

                     <?php
                         if(isset($message))
                         {
                          echo '<label class="text-danger">'.$message.'</label>';
                         }
                     ?>
                    <form method="post">
                         <label>Username</label>
                         <input type="text" name="username" class="form-control" />
                         <br />
                         <label>Password</label>
                         <input type="password" name="password" class="form-control" />
                         <br />
                         <input type="submit" name="login" class="btn btn-primary btn-block" value="Login" />
                         </form>
                    </div>
               <br />
          </body>
          </html>


