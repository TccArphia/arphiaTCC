<?php
   include 'db.php';

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $username = $_POST['root'];
       $password = $_POST['zardo'];

       $sql = "SELECT password FROM users WHERE username='$username'";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
           $row = $result->fetch_assoc();
           if (password_verify($password, $row['password'])) {
               echo "Login bem-sucedido!";
           } else {
               echo "Senha incorreta.";
           }
       } else {
           echo "Usuário não encontrado.";
       }

       $conn->close();
   }
   ?>