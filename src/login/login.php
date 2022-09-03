<?php
###############################################################
#      FICHIER DE CONNEXION POUR ASSISTANT ET AUTRES USERS    #
###############################################################
require "../assets/database.php";
//Connexion à la bd
$bdd=seconnecterDb();
$success=false;
$bloque=false;
//Connexion Assistant
if(isset($_POST['loginmail']) AND isset($_POST['loginpass']))
{
    if(isset($_POST['choixConnexion']) AND $_POST['choixConnexion']=="A")
   {
    $req=$bdd->query('SELECT * FROM assistant');
    while($donnee=$req->fetch())
    {
        
        if($_POST['loginmail']==$donnee['email'] AND sha1($_POST['loginpass'])==$donnee['mot_pass'])
        {
            if($donnee['etat']==1)
            {
            session_start();
            $_SESSION['id_assistant']=$donnee['id_assistant'];
            header('Location:../dashboard/recensementAssistant.php');
            $success=true;
            }
            else
            {
                $bloque=true;
                $success=true;
                header('Location:../login/index.php?etat='.$bloque);
            }
        }
       
       
        

  
    
    }
   if($success==false)
    {
        header('Location:../login/index.php?code='.$success);
    }}else
    {
        //Connexion autres users
        $req=$bdd->query('SELECT * FROM users');
        while($donnee=$req->fetch())
        {
            
            if($_POST['loginmail']==$donnee['email'] AND sha1($_POST['loginpass'])==$donnee['mot_pass'])
            {
                if($donnee['edit']==1)
                {
                session_start();
                $_SESSION['id']=$donnee['id_user'];
                header('Location:../dashboard/index.php');
                $success=true;
                }
                else
                {
                    $bloque=true;
                    $success=true;
                    header('Location:../login/index.php?etat='.$bloque);
                }
            }
           
           
            
    
      
        
        }
       if($success==false)
        {
            header('Location:../login/index.php?code='.$success);
        }
    }
    
}

?>