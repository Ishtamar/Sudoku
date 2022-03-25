<?php
    //Debuggage
    function tableauVisuel($T,$nombre){
        echo '<table>';
        for ($li=0;$li<=8;$li++){
            echo '<tr>';
            for ($co=0;$co<=8;$co++){
                echo '<td>';
                echo $T[$nombre-1][$li][$co];
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    //Partie vérification de la validite de la grille
    function verificationCase($S,$li,$co){
        if ($S[$li][$co]!=null){
            //Verification des lignes et colonnes
            for ($comp=0;$comp<=8;$comp++){
                if ($comp!=$li){
                    if($S[$li][$co]==$S[$comp][$co]){
                        return false;
                    }
                }
                if ($comp!=$co){
                    if($S[$li][$co]==$S[$li][$comp]){
                        return false;
                    }
                }
            }
            //Verification des secteurs
            for($i=0;$i<=2;$i++){
                for($j=0;$j<=2;$j++){
                    if (($li!=3*intdiv($li,3)+$i) || ($co!=3*intdiv($co,3)+$j)){
                        if($S[$li][$co]==$S[3*intdiv($li,3)+$i][3*intdiv($co,3)+$j]){
                            return false;
                        }
                    }
                }
            }
            //Si rien n'a échoué depuis
            return true;
        }else{
            return true;
        }
    }

    function verificationSudoku($S){
        for($li=0;$li<=8;$li++){
            for($co=0;$co<=8;$co++){
                if (!verificationCase($S,$li,$co)){
                    return false;
                }
            }
        }
        return true;
    }


    //Partie Tableau de possibilites

    function remplissagePossibilites($S){
        $P=array();
        for ($nombre=0;$nombre<=8;$nombre++){
            $P[]=array();
            for ($li=0;$li<=8;$li++){
                $P[$nombre][]=array();
                for ($co=0;$co<=8;$co++){
                    $P[$nombre][$li][]=1;
                }
            }
        }
        
        for ($li=0;$li<=8;$li++){
            for ($co=0;$co<=8;$co++){
                if ($S[$li][$co]!=null){
                    $nombre=$S[$li][$co]-1;
                    //Annulation par lignes et colonnes
                    for ($comp=0;$comp<=8;$comp++){
                        $P[$nombre][$li][$comp]=0;
                        $P[$nombre][$comp][$co]=0;
                    }
                    //Annulation des secteurs
                    for($i=0;$i<=2;$i++){
                        for($j=0;$j<=2;$j++){
                            $P[$nombre][3*intdiv($li,3)+$i][3*intdiv($co,3)+$j]=0;
                        }
                    }
                }
            }
        }
        
        //Annulation des cases déjà remplies
        for ($li=0;$li<=8;$li++){
            for ($co=0;$co<=8;$co++){
                if ($S[$li][$co]!=null){
                    for ($nombre=0;$nombre<=8;$nombre++){
                        $P[$nombre][$li][$co]=0;
                    }
                }
            }
        }
        return $P;
    }

    function trouverPossibilites($S){
        $P=remplissagePossibilites($S);
        $solutions=array();
        
        //Trouver des cases ou un seul chiffre est possible
        if (true){
            for ($li=0;$li<=8;$li++){
                for ($co=0;$co<=8;$co++){
                    if ($S[$li][$co]==null){
                        $compteur=0;
                        $candidat=-1;

                        for ($nombre=0;$nombre<=8;$nombre++){
                            if ($P[$nombre][$li][$co]==1){
                                $compteur++;
                                $candidat=$nombre;
                            }
                        }
                        if ($compteur==0){
                            return -1;
                        }elseif ($compteur==1){
                            $solutions[]=array($li,$co,$candidat+1);
                        }
                    }   
                }
            }
        }
        //Trouver des chiffres qui ne peuvent se trouver que sur une seule case
        for ($nombre=0;$nombre<=8;$nombre++){
            //Balayage des lignes
            if (true){
                for ($li=0;$li<=8;$li++){
                    $trouve=false;
                    $compteur=0;
                    $candidat=-1;

                    for ($co=0;$co<=8;$co++){
                        if ($S[$li][$co]==$nombre+1){
                            $trouve=true;
                        }
                        if ($P[$nombre][$li][$co]==1){
                            $compteur++;
                            $candidat=$co;
                        }
                    }
                    if (!$trouve){
                        if ($compteur==0){
                            return -1;
                        }elseif ($compteur==1){
                            $solutions[]=array($li,$candidat,$nombre+1);
                        }
                    }
                }
            }
            //Balayage des colonnes
            if (true){
                for ($co=0;$co<=8;$co++){
                    $trouve=false;
                    $compteur=0;
                    $candidat=-1;

                    for ($li=0;$li<=8;$li++){
                        if ($S[$li][$co]==$nombre+1){
                            $trouve=true;
                        }
                        if ($P[$nombre][$li][$co]==1){
                            $compteur++;
                            $candidat=$li;
                        }
                    }
                    if (!$trouve){
                        if ($compteur==0){
                            return -1;
                        }elseif ($compteur==1){
                            $solutions[]=array($candidat,$co,$nombre+1);
                        }
                    }
                }
            }
            //Balayage des secteurs
            if (true){
                for ($i1=0;$i1<=2;$i1++){
                    for ($j1=0;$j1<=2;$j1++){
                        $trouve=false;
                        $compteur=0;
                        $candidat1=-1;
                        $candidat2=-1;

                        for ($i2=0;$i2<=2;$i2++){
                            for ($j2=0;$j2<=2;$j2++){
                                $li=3*$i1+$i2;
                                $co=3*$j1+$j2;
                                if ($S[$li][$co]==$nombre+1){
                                    $trouve=true;
                                }
                                if ($P[$nombre][$li][$co]==1){
                                    $compteur++;
                                    $candidat1=$li;
                                    $candidat2=$co;
                                }
                            }
                        }
                        if (!$trouve){
                            if ($compteur==0){
                                return -1;
                            }elseif ($compteur==1){
                                $solutions[]=array($candidat1,$candidat2,$nombre+1);
                            }
                        }
                    }
                }
            }
        }  
        return $solutions;
    }

    function resoudreSudokuSimple($S){
        $actions=trouverPossibilites($S);
        while (!empty($actions)){
            foreach($actions as $action){
                $S[$action[0]][$action[1]]=$action[2];
            }
            $actions=trouverPossibilites($S);
        }
    }
?>