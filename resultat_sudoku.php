<?php
    if (!isset($_POST['S'])){
        header('Location:sudoku.php');
        exit;
    }else{
        $S=$_POST['S'];
        $compteurRemplis=81;
        for($li=0;$li<=8;$li++){
            for($co=0;$co<=8;$co++){
                if ($S[$li][$co]==null){
                    $compteurRemplis--;
                }
            }
        }
        if ($compteurRemplis<=17){
            //header('Location:/sudoku.php');
            //exit;
        }
    }
    include('fonctions.php');
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Résultat du Sudoku</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page">
        <p>
            <?php
               if (verificationSudoku($S)){
                   echo('La grille suivante est valide :');
               }else{
                   echo('La grille suivante n\' est pas valide :');
               }
            ?>
        </p>
        <form action="/resultat_sudoku.php" method="post">
            <table class="principal">
                <!-- Tableau principal de 3x3-->
                <?php for($li=0;$li<=2;$li++): ?>
                    <tr>
                        <?php for($co=0;$co<=2;$co++): ?>
                            <td>
                                <table class="secondaire">
                                    <!-- Tableaux secondaires de 3x3-->
                                    <?php for($li2=0;$li2<=2;$li2++): ?>
                                        <tr>
                                            <?php for($co2=0;$co2<=2;$co2++): ?>
                                                <td>
                                                    <?php
                                                        $numLi=3*$li+$li2;
                                                        $numCo=3*$co+$co2;
                                                        $nom='S[' . $numLi . '][' . $numCo . ']';
                                                        if ($S[$numLi][$numCo]==null){
                                                            echo('<input type="number" min="1"max="9" name="' . $nom . '" id="S' . $numLi . $numCo . '" />' );
                                                        }else{
                                                            $etat="fixer";
                                                            if (!verificationCase($S,$numLi,$numCo)){
                                                                $etat .= " erreur";
                                                            }
                                                            echo('<input type="hidden" value="' . $S[$numLi][$numCo] . '" name="' . $nom . '" id="S' . $numLi . $numCo . '" />' );
                                                            echo('<div class="' . $etat . '">' . $S[$numLi][$numCo] . '</div>');
                                                        }
                                                    ?>
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                    <?php endfor; ?>
                                </table>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>
            <p id="listeChiffresPossibles"></p>
            
            <div class="boutons">
                <div>
                    <?php if (verificationSudoku($S)): ?>
                        <button type="submit">Envoyer</button>
                        <button type="reset">Effacer</button>
                    <?php endif; ?>
                    <input type="button" value="Annuler" onclick="history.back()" />
                </div>
                <div>
                    <button type="button" onclick="afficherCases()">Afficher cases</button>
                    <button type="button" onclick="afficherChiffresPossibles()">Afficher chiffres</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<script type="text/javascript">
    let actions=<?php echo json_encode(trouverPossibilites($S)); ?>;

    function afficherCases() {
        for(let comp=0;comp<actions.length;comp++){
            let caseJaune=document.getElementById("S" + actions[comp][0] + actions[comp][1]);
            caseJaune.style.backgroundColor="yellow";
        }
    }
    
    function afficherChiffresPossibles() {
        let texte='';
        for (let chiffre=1;chiffre<=9;chiffre++){
            for(let comp=0;comp<actions.length;comp++){
                if (actions[comp][2]==chiffre){
                    texte+=(' '+chiffre);
                    break;
                }
            }
        }
        if (texte!=''){
            const blocTexte=document.getElementById("listeChiffresPossibles");
            blocTexte.innerHTML='Les chiffres possibles sont : ' + texte;
        }
    }
</script>