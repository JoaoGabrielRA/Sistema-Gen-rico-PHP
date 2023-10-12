<?php

session_start();
unset($_SESSION['usuario']);
unset($_SESSION['nivel_acesso']);
session_destroy();
header('Location: login.php');