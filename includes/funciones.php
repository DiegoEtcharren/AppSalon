<?php

function debbug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Funcion que inicia sesion en caso de que no este iniciada:
function isSession() : void {
    if(!isset($_SESSION)) {
        session_start();
    }
}

// Compara si los valores son iguales: 
function esUltimo(string $actual, string $proximo) : bool {
    if ($actual !== $proximo){
        return true;
    }
    return false;
} 

// Funcion que revisa si el usuario esta iniciado: 
function isAuth() : void {
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}