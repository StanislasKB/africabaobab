<?php

function seconnecterDb()
{
    $bdd=new PDO('mysql:host=mysql_db;dbname=africabaobab','root','root');
    return $bdd;
}