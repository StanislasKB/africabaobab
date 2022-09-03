<?php

    $req2=$bdd->prepare('SELECT * FROM femmes WHERE id_user=?');
    $req2->execute([$_SESSION['id']]);
    
   


?>


<div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <span><i class="bi bi-table me-2"></i></span>Tableau Récapitulatif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Age</th>
                                            <th>Matricule</th>
                                            <th>Activités</th>
                                            <th>Situation</th>
                                            <th>Numéro</th>
                                            <th>Commune</th>
                                            <th>Village</th>
                                            <th>Groupement</th>
                                            <th>Statut</th>
                                            <th>Edition</th>
                                            <th>Collecte</th>
                                            <th>Recensée par</th>
                                            <th></th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($donnee=$req2->fetch())
                                    {   $requete=$bdd->prepare('SELECT nom, prenom FROM assistant WHERE id_assistant=?');
                                        $requete->execute([$donnee['id_assistant']]);
                                        $nom="Agent";
                                        $prenom="";
                                       while( $data=$requete->fetch())
                                       {
                                        $nom=$data['nom'];
                                        $prenom=$data['prenom'];
                                       }
                                         echo '
                                        <tr>
                                            <td>'.$donnee['nom'].'</td>
                                            <td>'.$donnee['prenom'].'</td>
                                            <td>'.$donnee['age'].'</td>
                                            <td>'.$donnee['matricule'].'</td>
                                            <td>'.$donnee['activite'].'</td>
                                            <td>'.$donnee['stmatrimoniale'].'</td>
                                            <td>'.$donnee['telephone'].'</td>
                                            <td>'.$donnee['commune'].'</td>
                                            <td>'.$donnee['village'].'</td>
                                            <td>'.$donnee['nom_regroupement'].'</td>
                                            <td>'.$donnee['statut'].'</td>
                                            <td>'.$donnee['edition_campagne'].'</td>
                                            <td>'.$donnee['capacite'].'</td>
                                            <td>'.$nom.' '.$prenom.'</td>
                                            <td> <img src="../assets/images/femme/'.$donnee['photo'].'" width="80px"></td>
                                            
                                        </tr>';
                                    }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Age</th>
                                            <th>Matricule</th>
                                            <th>Activités</th>
                                            <th>Situation</th>
                                            <th>Numéro</th>
                                            <th>Commune</th>
                                            <th>Village</th>
                                            <th>Groupement</th>
                                            <th>Statut</th>
                                            <th>Edition</th>
                                            <th>Collecte</th>
                                            <th>Recensée par</th>
                                            <th></th>
                                         
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>