<?php
    class funzioniGiulia {
        public static function menuAmm() {
            $menuAmm_form = '<div id="menuAmministratore">'.
                                '<ul>'.
                                    '<li><a href="../PHP/homeAmministratore.php"><span xml:lang="en">HOME</span> AREA PERSONALE</a></li>'.
                                    '<li><a href="../PHP/infoAmministratore.php">INFORMAZIONI PERSONALI</a></li>'.
                                    '<li><a href="../PHP/messaggiAmministratore.php">MESSAGGI</a></li>'.
                                    '<li><a href="../PHP/veicoliNoleggioAmministratore.php">VEICOLI A NOLEGGIO</a></li>'.
                                    '<li><a href="../PHP/veicoliVenditaAmministratore.php">VEICOLI IN VENDITA</a></li>'.
                                '</ul>'.
                            '</div>';
            return $menuAmm_form;
        }
    }
?>