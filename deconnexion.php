<?php
    
    session_start();
    // deconnexion
    unset($_SESSION["users"]);
    header("Location: signin.php");
    ?>