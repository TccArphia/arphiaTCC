   <?php
   $servername = "localhost";
   $username = "root"; // Substitua pelo seu usuário do MySQL
   $password = "";     // Substitua pela sua senha do MySQL
   $dbname = "aluno";

   // Cria conexão
   $conn = new mysqli($servername, $username, $password, $dbname);

   // Verifica a conexão
   if ($conn->connect_error) {
       die("Conexão falhou: " . $conn->connect_error);
   }
   ?>