<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>liste pays</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    require_once 'access.php';
    /*    //creation BDD
 */
    try {
        $cnx->exec('DROP TABLE pays');

        $cnx->exec("CREATE TABLE IF NOT EXISTS pays (id BIGINT PRIMARY KEY, 
                                                    nom VARCHAR(100), 
                                                    iso VARCHAR(10), 
                                                    image LONGBLOB)");
        if ($file = fopen("pays.csv", "r")) {
            while ($line = fgets($file)) {
                $tab = explode(",", trim($line));
                $flag = 'drapeau/' . $tab[2] . '.svg';      // nom du fichier du drapeau avec son extension
                if (file_exists($flag)) {                // si le fichier existe
                    $img = file_get_contents($flag);    // on insère dans la colonne image le fichier
                } else {
                    $img = '';                           // on laisse une chaine vide
                }
                $int = sprintf(
                    "INSERT INTO pays VALUES (%d,%s,%s,%s)",
                    $tab[0],
                    $cnx->quote($tab[1]),
                    $cnx->quote($tab[2]),
                    $cnx->quote($img)
                );
                $cnx->exec($int);
            }
            fclose($file);
        }
    } catch (exception $myexep) {
        echo "erreur:", $myexep->getMessage();
    }
    /*    //fonction formulaire
 */

    ?>
    <div class="parent">
        <div class="div1">
            <!--choi du pays-->
            <?php $res = $cnx->query("SELECT * FROM pays");
            if (!isset($_POST['nom'])) {
                echo "<form method='post'>";
                echo "<label>envoyer une valeur:";
                echo "<select name='nom'>";
                echo "<option selected value='nullnom'>selection pays</option>";
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    foreach ($row as $k => $val) {
                        if ($k == "nom") {
                            $pays = $val;
                        }
                        if ($k == "iso") {
                            echo "<option name='$pays' value='$val'> $pays</option> <br/>\n";
                        } else {
                        }
                    }
                }
                echo "</select></label><br/>\n";
            }
            /*          choi de l'iso*/
            $is = $cnx->query("SELECT iso FROM pays");
            if (!isset($_POST['code'])) {
                echo "<label>";
                echo "<select name='code'>";
                echo "<option selected value='nulliso'>selection iso</option>";
                while ($row = $is->fetch(PDO::FETCH_ASSOC)) {
                    foreach ($row as $v => $val) {
                        echo "<option name=$val value='$val'> $val</option> <br/>\n";
                    }
                }
                echo "</select></label><br/>\n";
            }
            /*          choi de l'id*/
            $is = $cnx->query("SELECT * FROM pays");
            if (!isset($_POST['id'])) {
                echo "<label>";
                echo "<select name='id'>";
                echo "<option selected value='null'>selection id</option>";
                while ($row = $is->fetch(PDO::FETCH_ASSOC)) {
                    foreach ($row as $k => $val) {
                        if ($k == "id") {
                            $id = $val;
                        }
                        if ($k == "iso") {
                            echo "<option name='$val' value='$val'> $id</option> <br/>\n";
                        } else {
                        }
                    }
                }
                echo "</select></label>\n";
            }

            /*             //verification des qu'elle imput et ajoue dans la variable idi
 */
            if (!isset($_POST['submit']))
                echo "<input type='submit' name='submit' value='envoyer'>";
            echo "</form>";
            if (@$_POST['nom'] != "nullnom") {
                $idi = @$_POST['nom'];
            } elseif ($_POST['code'] != "nulliso") {
                $idi = $_POST['code'];
            } else $idi = $_POST['id'];
            ?>
            <nav>
                <a href="#<?php echo $idi; ?>"><?php if ($idi) {
                                                    echo 'afficher mon pays';
                                                } ?></a><br />
                <a href="http://localhost/php/PROJET/bdd.php"><?php if ($idi) {
                                                                    echo 'reset';
                                                                } ?></a>
            </nav>

             <!--       creation du tableau
 -->
      </div>
      <div class="div2">
         <?php
         $res = $cnx->query("SELECT * FROM pays");
         if ($res != false) {
            echo "<table><tr><th>Contenu de la table produits:</th></tr>\n";
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
               next($row);
               next($row);
               $idi = current($row);
               echo "<tr id=$idi>\n";
               reset($row);
               foreach ($row as $k => $v) {
                  if($k=="id"){
                     $ida = $v;
                  }
                  if($k=='image'){
                     echo "<td><img src='image.php?id=".$ida."'></td>";
                  }else{
                  echo "<td>" . $v . "</td>";
                  }
               }
               echo "</tr>\n";
            }
            echo "</table>";
         }
         ?></div>
   </div>