<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Solveur Sudoku</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page">
        <p>
            Veuillez entrer la grille avec laquelle vous souhaitez travailler. Vous pourrez :
        </p>
        <ul>
            <li>Vérifier si la grille ne comporte pas d'erreur</li>
            <li>Trouver quelles cases sont faisables (<span class="detail">cases où un seul candidat est possible</span>)</li>
            <li>Trouver quelles valeurs sont faibales (<span class="detail">valeurs où une case a un seul candidat possible</span>)</li>
            <li>Résoudre le SUDOKU en mode simple (<span class="detail">remplissage itératif de cases où un seul candidat est possible</span>)</li>
            <li>Résoudre le SUDOKU en mode complexe (<span class="detail">des  tentatives sont effectuées si aucune case n'a qu'un seul candidat possible</span>)</li>
         </ul>
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
                                                        $place=1+27*$li+9*$li2+3*$co+$co2;
                                                        echo('<input type="number" min="1"max="9" name="S[' . $numLi . '][' . $numCo . ']" />' );
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

            <div class="boutons">
                <button type="submit">Envoyer</button>
                <button type="reset">Effacer</button>
            </div>
        </form>
    </div>
</body>
</html>