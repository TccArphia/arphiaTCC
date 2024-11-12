  <?php
   include 'db.php';

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $username = $_POST['username'];
       $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

       $sql = "INSERT INTO users ('$username', '$password') VALUES ('$username', '$password')";

       if ($conn->query($sql) === TRUE) {
           echo "Cadastro realizado com sucesso!";
       } else {
           echo "Erro: " . $sql . "<br>" . $conn->error;
       }

       $conn->close();
   }

   
   ?>