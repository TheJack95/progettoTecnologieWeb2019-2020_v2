<?php
    class funzioniAmministratore {
        public static function menuAmm() {
            $menuAmm_form = '<div id="menuAmministratore">'.
                                '<ul>'.
                                    '<li><a href="homeAmministratore.php"><span xml:lang="en">HOME</span> AREA PERSONALE</a></li>'.
                                    '<li><a href="infoAmministratore.php">INFORMAZIONI PERSONALI</a></li>'.
                                    '<li><a href="messaggiAmministratore.php">MESSAGGI</a></li>'.
                                    '<li><a href="veicoliNoleggioAmministratore.php">VEICOLI A NOLEGGIO</a></li>'.
                                    '<li><a href="veicoliVenditaAmministratore.php">VEICOLI IN VENDITA</a></li>'.
                                '</ul>'.
                            '</div>';
            return $menuAmm_form;
        }
    }
?>