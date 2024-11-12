<?php

$hostname = "localhost.phpmyadmin"; //endereço aonde esta o bd infelizmente n sei nem o arthur vemos dps
$bancodedados = "Arphia";
$usuario = "root"; //usuario
$senha = ""; //senha vazia por padrão, n sei se a a gente ponhou isso 

$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
if ($mysqli->connect_errno) {
    echo "falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}