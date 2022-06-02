<?php
 print "Ajout d'un drapeau  ";
?>
<form action="upload_drapeau.php" method="POST" ENCTYPE="multipart/form-data">
 <input type="hidden" name="MAX_FILE_SIZE" value="3072000">
    <p>image : <input type="file" name="photo" accept="image/jpeg, image/png, image/svg"></p>
    <p> <input type="submit" name="nouveau" value="envoyer"></p>

    <p><strong>Note : Seule les images au format jpg, png et svg sont acceptées</strong></p>
</form>


<?php
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_FILES['photo']) && $_FILES['photo']['error']==0)
        {
            $autorise=['jpg' => 'image/jpeg','png' => 'image/png', 'image/svg'];     // Type des fichiers autorisés
            $fichiernom=$_FILES['photo']['name'];
            $fichiertype=$_FILES['photo']['type'];
            $fichiertaille=$_FILES['photo']['size'];
            $fichiernomtemp=$_FILES['photo']['tmp_name'];
            $controletailleimage=getimagesize($fichiernomtemp);

            if($controletailleimage!==false)
            {
                echo '<br>Nom fichier : '.$fichiernom;
                echo '<br>Type fichier : '.$fichiertype;
                echo '<br>Taille fichier : '.$fichiertaille;
                echo '<br>Nom fichier temporaire : '.$fichiernomtemp;

                $extension=pathinfo($fichiernom, PATHINFO_EXTENSION);
                echo '<br>extension='.$extension;
                if(!array_key_exists($extension,$autorise))
                    die('<br>Le Fichier DOIT ETRE au format jpg ou png ou svg.');

                if($fichiertaille>3072000)
                    die('<br>Le fichier ne DOIT PAS dépasser 3 Mo');

                if(in_array($fichiertype,$autorise))
                {
                    if(file_exists("upload/".$fichiernom))
                    {
                        die('<br>Un fichier avec le même nom existe déjà !!');
                    }
                    else
                    {
                        /*
                         Vous devez CREER UN REPERTOIRE upload dans le dossier où vous
                         executez ce script PHP, le fichier va être déplacé à cet endroit
                         Répertoire avec des droits d'écriture bien entendu 
                        */
                        if(move_uploaded_file($fichiernomtemp,'./drapeau/'.$fichiernom))
                            echo '<br>Fichier stocké dans le dossier upload';
                        else
                            Die('Erreur de déplacement du fichier !?');
                    }
                }
                else
                {
                    echo 'Erreur de type de fichier !?';
                }
            }
            else
            {
                Die('Le fichier n\'est pas une image !?');
            }
        }
        else
        {
            die('Erreur lors du telechargement du fichier!');
        }
    }

