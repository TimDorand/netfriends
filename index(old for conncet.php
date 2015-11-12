<?php
include('config.php');

if(empty($_SESSION['name'])) {

    header('Location:login.php');

}else{
    echo '<br/> You are connected as '.$_SESSION["name"];
}



include('index.php');

