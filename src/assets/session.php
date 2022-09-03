<?php
function init_session($id)
{
    session_start();
    $_SESSION['id']=$id;
}