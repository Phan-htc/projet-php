<?php
require_once 'access.php';

try {
    //créer la table pays si il n'existe pas
    $cnx->exec('DROP TABLE pays');
    $cnx->exec("CREATE TABLE IF NOT EXISTS pays (id BIGINT PRIMARY KEY, 
                                                nom VARCHAR(100), 
                                                iso VARCHAR(10),
                                                image LONGBLOB )");
    if ($file = fopen("pays.csv", "r")) {
        while ($line = fgets($file)) {
            $tab = explode(",", trim($line));
            $flag = 'drapeau/'.$tab[2].'.svg';      // nom du fichier du drapeau avec son extension
            if(file_exists($flag)) {                // si le fichier existe
                $img = file_get_contents($flag);    // on insère dans la colonne image le fichier
            } else {
                $img ='';                           // on laisse une chaine vide
            }
            
            $int = sprintf("INSERT INTO pays ( id , nom, iso, image )VALUES (%d,%s,%s,%s)",
                           $tab[0], 
                           $cnx->quote($tab[1]), 
                           $cnx->quote($tab[2]), 
                           $cnx->quote($img));
            $cnx->exec($int);
        }
        fclose($file);
    }
} catch (exception $myexep) {
    echo "erreur:", $myexep->getMessage();
}