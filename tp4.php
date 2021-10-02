<?php

   $connect = mysqli_connect ("localhost", "root","","test");
   session_start();
   if (isset($_GET["monForm"]))

{
   if(!empty($_GET["username"])  || !empty($_GET["password"])) {
    $pw =$_GET["password"];
    $username=mysqli_real_escape_string($connect,$_GET["username"]); 
    $password=mysqli_real_escape_string($connect,$_GET["password"]); 
    $password=password_hash($password,PASSWORD_DEFAULT);
    
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$pw')";
    $sql="SELECT * FROM users  WHERE Username='$username' and password='$pw'   ";
    $result = mysqli_query($connect, $sql);
    $count = mysqli_num_rows($result);

    if(mysqli_query($connect,$query  )  ) {
        if($count > 0 ) {
            echo "<h3><br><br>utilisateur $username  existe deja dans la base de données</h3><br>";
    }    
   } 
  }
 }    
    ?>
 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Salim ">
        <title>Accueil</title>
    </head>
    <body>   
       <?php      
                    $code = "";
                    $messageCode = "";
                    $valideCode = false;
                          if(isset($_GET["password"]))
                        {
                            $code = $_GET["password"];
                            $regExpCode = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/"; 
                            $resultat = preg_match($regExpCode, $code);
                            $username=mysqli_real_escape_string($connect,$_GET["username"]); 
                            $password=mysqli_real_escape_string($connect,$_GET["password"]);                
                            $password=password_hash($password,PASSWORD_DEFAULT);
                            $pw =$_GET["password"];                           
                         
                           if(strlen($_GET["password"])<8)
                            {
                               $messageCode = " <span style='color:red;'> Un mot de passe doit contenir au minimum 8 caractères </span>";
                              
                            }
                            else if(  ($pw == 123456789) OR ($pw=="motdepasse"))
                            {
                               $messageCode = " <span style='color:red;'>Ce mot de passe est dans une liste de mots de passe bannis. </span>";
                            }
                           else if($resultat === 0)
                            {
                               $messageCode = " <span style='color:red;'>Le mot de passe doit contenir au moins huit caractères, au moins une lettre majuscule, une lettre minuscule et un chiffre EX: Abcdef123</span>";
                            }                          
                                                        
                            else
                            {
                                $valideCode = true;
                            }
                           
                           
                        }
                    ?>   
                     <?php
      
                if(isset($_GET["monForm"]) )
                {
                    if($valideCode ) 
                      if(!$count ) {                       
                      {
                        if(isset($_GET["username"]))
                            echo "Le nom d’utilisateur est  :<strong> " .$username. " </strong> <br>";
                        if(isset($_GET["password"]))
                        echo "Le password :  <strong> " . $password. "</strong>     <br><br>";
                    }
        }
    }
    ?>                
           
                        <form method="GET">
                        <br><br>
                             Entrez un nom d’utilisateur :
                             <input type="text" name="username"/><br><br>
                             Entrez un mot de passe :
                              <input type="text" name="password" value="<?= $code ?>" /><?= $messageCode ?><br><br>
                             <input type="submit" value="Envoyer"name="monForm"/>
                        </form>                      

    </body>
</html>