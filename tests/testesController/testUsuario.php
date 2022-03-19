<?php
include_once("../../controller/includes.php");

$usuario = new Usuario();
$email = 'henriquecostadonascimento@gg.com';
$senha = '123456';

$usuario->logar($email, $senha);




