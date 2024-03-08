<?php

function isLoggedIn(){
    require 'bddConnection.php';

    if ($_SESSION['loggedIn']==false) {
        header('Location: ../connexion/connexion.html');
        exit;
    }else{
        return 1;
    }
}

function isAdmin(){
    
    if ($_SESSION['admin']===false){
        return 0;
    }else{
        return 1;
    }
}