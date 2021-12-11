<!DOCTYPE html>
<html>
	<head>
		<title>Lineac-Documents <?=dirname($_SERVER['PHP_SELF'])?></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<h1>Dossier courant : <?=dirname($_SERVER['PHP_SELF'])?></h1>
	
	<!-- Uploads -->
	<?php
		/* L'utilisateur a cliqué sur "Enregistrer sur le serveur" */
		if(isset($_POST["submitUploadFile"])){
			$uploadOk=1;
			$scriptFileName=$_SERVER['SCRIPT_FILENAME'];
			$uri   = rtrim(dirname($_SERVER['SCRIPT_FILENAME']), '/\\');
						
			
			if(isset($_FILES) && isset($_FILES["fileToUpload"])){
				$fichierCible=$uri.'/'.$_FILES["fileToUpload"]["name"];
				if (file_exists($fichierCible)) {
   	 			echo "Le fichier ".$_FILES["fileToUpload"]["name"]." existe déjà";
	    			$uploadOk = 0;
    			}	
				if($uploadOk==1){	
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fichierCible)) {
        				echo "<p>Le fichier ". basename( $_FILES["fileToUpload"]["name"]). " a été enregistré sur le serveur.</p>";
    				} 
    				else {
        				echo "<p>Erreur. Le fichier n'a pas pu être enregistré</p>";
    				}
    			}
    		}
    	}
	?>		
			
	<form  method="post" enctype="multipart/form-data">
    <h2>Envoyer un fichier sur le serveur :</h2>
    <input type="file" name="fileToUpload" id="fileToUpload" value="Enregistrer sur le serveur">
    <input type="submit" value="Enregistrer sur le serveur" name="submitUploadFile">
	</form>
	
	<!---------------------------------------------------------------------------------------------->
	
	
	<!-- Créer un dossier -->
	
	<?php
	
	
	/* L'utilisateur a cliqué sur "Nouveau Dossier" */
	
	
		if(isset($_POST["submitNouveauDossier"])){
			if(mkdir($_POST["nouveauDossier"])){
				echo "<p>Le dossier ".$_POST["nouveauDossier"]." a été créé</p>";
			}
			else{
				echo "<p>Erreur : Echec de la création du dossier ".$_POST["nouveauDossier"]."</p>";
			}
		}
	?>
	
	
	<form  method="post" enctype="multipart/form-data">
    <h2>Créer un dossier :</h2>
    <input type="text" name="nouveauDossier" id="nouveauDossier">
    <input type="submit" value="Créer un dossier" name="submitNouveauDossier">
	</form>
	
	<!---------------------------------------------------------------------------------------------->
	
	
	
	
	<!-- Download -->
	
			<?php
		
		/* L'utilisateur a cliqué sur "supprimer un fichier" */
		
		if(isset($_POST["nomFichierAEffacer"])){
			if(isset($_POST["confirmationFichierAEffacer"])){
				if(unlink($_POST["nomFichierAEffacer"])){
					echo "<p>Le fichier ".$_POST["nomFichierAEffacer"]." a été supprimé.</p>";
				}
				else{
					echo "<p>Erreur: Le fichier ".$_POST["nomFichierAEffacer"]." n'a pas pu être supprimé.</p>";
				}
			}
			elseif(!isset($_POST["abandonFichierAEffacer"])){
				?>
				<h2>Confirmer la suppression de <?=$_POST["nomFichierAEffacer"]?> ?</h2>
				<form method="post" enctype="multipart/form-data">
					<input type="submit" name="confirmationFichierAEffacer" value="Confirmer">
					<input type="submit" name="abandonFichierAEffacer" value="Ne pas supprimer">
					<input type="hidden" name="nomFichierAEffacer" value="<?=$_POST["nomFichierAEffacer"]?>">
				</form>
				<?php
			}
		}
		
		?>

	
	<h2>Télécharger</h2>
		<?php
			$forceCopieFicNav=true; 
			$liste=scandir(".");
			$dossiers=array();
			$fichiers=array();
			$ficnav=basename(__FILE__);
			$fichiersExclus=array($ficnav,".htaccess",".htpasswd");
			
			foreach ($liste as $element){
				
				/* dossier */
				
				if (is_dir($element)){
					$dossiers[]=$element;
					if (($element !="..")&&($element!=".")){
						
						/* si le dossier ne contient pas le crawler, on l'y copie */ 
						
						if (!is_file($element."/".$ficnav)||($forceCopieFicNav)){
							//echo "<p>Copie de ".$ficnav." vers ".$element."/".$ficnav."</p>";
							copy("./".$ficnav,$element."/".$ficnav);
						}
					}
				}
				else{
					if (!in_array($element,$fichiersExclus)){
						/* on exclu les fichiers de $fichiersExclus (ficnav, htaccess...) */
						$fichiers[]=$element;
					}
				}
			}
		?>
		<h2>Dossiers</h2>
		<ul>
			<?php
				foreach ($dossiers as $dossier):
			?>
					<li><a href="<?=htmlentities($dossier).'/'.$ficnav?>"><?=($dossier==".."?"Remonter au niveau supérieur":$dossier)?></a></li>
			<?php
				endforeach;
			?>
		</ul>
			
		
		
		<!-- Liste des fichiers -->
		
		<h2>Fichiers</h2>
		<table>
			<tbody>
				<?php
					foreach ($fichiers as $fichier):
				?>
				<tr>
					<form method="post" enctype="multipart/form-data">
						<input type="hidden" name="nomFichierAEffacer" value="<?=$fichier?>">
						<td>
							<a href="<?=$fichier?>" download><?=$fichier?></a>
						</td>
						<td>
							<input type="submit" name="supprimerFichier"  value="Supprimer">
						</td>
					</form>
				</tr>
					
				<?php
					endforeach;
				?>
			</tbody>
		</table>

	</body>
</html>