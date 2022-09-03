<?php

$req2 = $bdd->query('SELECT * FROM users WHERE type_user=0');




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
                                <th>Email</th>
                                <th>Contact</th>
                             
                          
                               <th></th>
                                 <th></th> 

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($donnee = $req2->fetch()) {
                               
                                $statecolor="btn-success";
                                $stateMes="Accordé";
                       
                                if($donnee['edit']==0){$statecolor=" bg-danger"; $stateMes="Bloqué";}else{$statecolor=" bg-success";$stateMes="Débloqué";}
                                echo '
                                        <tr>
                                            <td>' . $donnee['nom'] . '</td>
                                            <td>' . $donnee['prenom'] . '</td>
                                            <td>' . $donnee['email'] . '</td>
                                            <td>' . $donnee['tel'] . '</td>
                                       
                                            
                                           
                                            <td>
                                            <button class="btn  btn-sm'.$statecolor.' " onclick="bloquer('.$donnee['id_user'].')"><span>'.$stateMes.'</span>
                                            </button>
                                            </td> 
                                            <td>
                                            <a id="'.$donnee['id_user'].'" class="btn bg-dark btn-sm mybouton"  data-bs-toggle="modal" data-bs-target="#communeModal"><span class="text-white">Associer</span></a>
                                              
                                            </td>
                                        </tr>';
                            }
                            ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Contact</th>
                                
                        
                               <th></th>
                                <th></th> 
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$req3=$bdd->query('SELECT * FROM campagne');
?>
 <!-- Add commune Modal -->
 <div class="modal fade" id="communeModal" tabindex="-1" aria-labelledby="communeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="communeModalLabel">Formulaire de campagnes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="addAT.php" method="POST">
        <select class="form-control multiselect-container" name="category" id="selectoption">
            <?php
            while($donnee=$req3->fetch())
            {
                echo'
				<option value='.$donnee['id_campagne'].'>'.$donnee['edition_campagne'].'</option>
				';
            }   
                ?>
			</select>
      </div>
      <div class="modal-footer">
        <input type="text" class="d-none secretinput" name="secret">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Valide</button>
      </div>
      </form>
    </div>
  </div>
</div>
    <!-- Add commune Modal -->
    
   