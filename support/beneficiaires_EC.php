<div id="beneficiaires" class="item_EC">
    <h1 style="font-variant: small-caps;">vos bénéficiaires</h1>
    <p style="font-size: 15px">Vous trouverez ci-dessous la liste de vos bénéficiaires. Vous pouvez ajouter un bénéficiaire avec le formulaire ci-dessous, et supprimer les bénéficiaires déjà enregistrés.</p>
    <hr>
    <table><tr>
    <table class="onglet_Beneficiaire" style="background-color: #E80969"><tr><td style="color: white; padding-left:10px; padding-right:5px;"><h3 style="font-weight: normal; font-variant: small-caps;">ajouter un beneficiaire</h3></td><td><button type="submit" class="bouton_Beneficiaire" style="background-color: #E80969" onclick="toggle_div(this,'ajout_beneficiaire');"><img src="images/angle-arrow-down.png" style="width:25px"></button></td></tr></table>
            
    <div id='ajout_beneficiaire' style="display:none;">
    <p style="font-size: 15px">Merci de compléter les informations ci-dessous pour ajouter un bénéficiaire.</p>
    <form class="formulaire" method="post" action="creation_Beneficiaire.php">
        <div class="ajout_Beneficiaire">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><label for="libelle_Beneficiaire">libellé du bénéficiaire</label> :</td>
                    <td><input type="text" name="libelle_Beneficiaire" id="libelle_Beneficiaire" size="30" minlength="2" maxlength="30" placeholder="Entrez le libellé du bénéficiaire" required /></td>
                </tr>
                <tr>   
                    <td><label for="iban">iban</label> :</td>
                    <td><input type="text" name="iban" id="iban" size="27" minlength="27" maxlength="27" placeholder="Entrez l'IBAN du bénéficiaire" required /></td>   
                </tr>
            </table>
        </div>
        <div class="bouton_Form">
                <button type="submit" class="bouton_Ouvrir"> <img src="images/add-plus-button.png" style="width:25px; margin-right:20px;"> Ajouter</button>
        </div>
    </form>
    </p>
    </div>
    </tr>
    <br>
    <hr>
    <br>
    <tr><table class="onglet_Beneficiaire"><tr><td style="color: white; padding-left:10px; padding-right:5px;"><h3 style="font-weight: normal; font-variant: small-caps;">vos bénéficiares enregistrés</h3></td><td><button type="submit" class="bouton_Beneficiaire" onclick="toggle_div(this,'liste_Beneficiaire');"><img src="images/angle-arrow-down.png" style="width:25px"></button></td></tr></table>
            
    <div id='liste_Beneficiaire' style="display:none;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?php 
        $i = 1;
        ?><tr><th style="width:15%">n°</th><th style="width:35%">libellé du bénéficiaire</th><th style="width:20%">statut</th><th style="width:20%"></th><th style="width:10%"></th></th>
        <?php while($beneficiaire = $beneficiaires->fetch_row()) {
            if ($beneficiaire[4]==1) {
                ?> <tr><td style="width:15%"><?php echo($i) ?></td><td style="width:35%"><?php echo($beneficiaire[3]) ?></td><td style="width:20%">Actif</td>
                <td style="width:20%"><form method="post" action="virement.php">
                    <button name="id_Beneficiaire" type="submit" class="bouton_Virement" value="<?php echo ($beneficiaire[0]) ?>">Faire virement</button><br /><br />
                </form style="height: 40px;"></td>
                <td style="width:10%"><form method="post" action="suppression_Beneficiaire.php">
                    <button name="id_Beneficiaire" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>"><img src="bin.png" style="width:25px; margin-right:20px;"></button><br /><br />
                </form></td></tr>
            <?php } else {
                ?><tr><td style="width:15%"><?php echo($i) ?></td><td style="width:35%"> <?php echo($beneficiaire[3]) ?></td><td style="width:20%">En attente</td><td style="width:20%"></td>
                <td style="width:10%"><form method="post" action="suppression_Beneficiaire.php" style="height: 40px;">
                    <button name="id_Beneficiaire" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>"><img src="images/bin.png" style="width:25px; margin-right:20px;"></button><br /><br />
                </form></td></tr>
            <?php }
            $i = $i + 1;
        }
        ?>
        </table>
    </div>
    </p>
    </tr></table>
</div>
</div>