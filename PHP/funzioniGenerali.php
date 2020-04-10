<?php
    class funzioniGenerali {
    #funzione per scrivere l'header
        public static function header() {
            $header_form = '<div id="header">'."\n".
                            '   <a href="home.php"><img class="logoHeader" src="" alt="logo concessionaria greg" /></a>'."\n".
                            '   <p class="nomeSito"><a href="home.php">CONCESSIONARIA GREG</a></p>'."\n".
                            '</div>';
            return $header_form;
        }

    #funzione per scrivere i breadcrumb
        public static function breadcrumb(...$sequenza){
            $breadcrumb_form = '<div id="breadcrumb">'."\n".
                                '   <p>Ti trovi in: ';
            foreach($sequenza as $element){
                $breadcrumb_form .= "$element ";
            }
            $breadcrumb_form .=     "</p>"."\n"
                               .'</div>'."\n";

            $breadcrumb_form .= "<noscript class=\"messaggio\">"."\n"
                                ."    <h1>"."\n"
                                ."        Il tuo browser non supporta JavaScript oppure &egrave; stato disabilitato. Alcune funzionalit&agrave; potrebbero non funzionare correttamente."."\n"
                                ."    </h1>"."\n"
                                ."</noscript>"."\n";
            return $breadcrumb_form;
        }

        /**
         * Funzione per scrivere il menu
         */
        public static function menu(){
            if(!isset($_SESSION)) {
                session_start();
            }
                $menu_form =    '<div id="menu">'."\n".
                                '   <ul>'."\n".
                                '       <li><a href="home.php"><span xml:lang="en" lang="en">HOME</span></a></li>'."\n".
                                '       <li><a href="noleggioVeicoli.php">VEICOLI A NOLEGGIO</a></li>'."\n".
                                '       <li><a href="acquistaVeicoli.php">VEICOLI IN VENDITA</a></li>'."\n".
                                '       <li><a href="contatti.php">CONTATTI</a></li>'."\n";
            if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) { //login effettuato come amministratore
              $menu_form .=   '       <li><a class="" href="homeAmministratore.php">AREA AMMINISTRATORE</a></li>'."\n".
                              '       <li><a class="" href="../PHP/logout.php">ESCI</a></li>'."\n";
            } elseif(isset($_SESSION["user"])) { //login effettuato come utente
                $menu_form .=   '       <li><a class="" href="areaPrivata.php">AREA PERSONALE</a></li>'."\n".
                                '       <li><a class="" href="../PHP/logout.php">ESCI</a></li>'."\n";
            } else { //non ho fatto il login oppure qualcosa e' andato storto
                $menu_form .=   '       <li><a class="" href="login.php">ACCEDI</a></li>'."\n";
            }
                $menu_form .=   '   </ul>'."\n".
                                '</div>';

            return $menu_form;
        }

        /**
         * Funzione per scrivere il footer
         */
        public static function footer() {
            $footer_form =  '<div id="footer">'."\n".
                            '   <p>CONCESSIONARIA GREG - Tutti i diritti riservati - A cura di <span xml:lang="en" lang="en">Tecweb Group</span></p>'."\n".
                            '</div>';
            return $footer_form;
        }

        /**
         * Funzione per settare il messaggio nella pagina vuota
         *
         * @param string $messaggio string testo da visualizzare
         * @param bool $errore indica se il messaggio &egrave;  un errore
         *
         * @return string l'HTML della pagina
         */
        public static function setMessaggio($messaggio, $errore){

            $class  = $errore ? "errorMessage" : "messaggio";
            $breadcrumb  = $errore ? "Errore" : "Messaggio";

            $output = file_get_contents("../HTML/paginaVuota.html");
            $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb($breadcrumb),$output);
            $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
            $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
            $output = str_replace("<messaggio></messaggio>","<p class='$class'>$messaggio</p>",$output);

            return $output;
        }

        /**
         * Verifica se l'utente &egrave; loggato
         * @return Object status, message
         */
        public static function checkSession() {
            if(!isset($_SESSION))
                session_start();

            if(isset($_SESSION["user"])) {
                return (Object) [
                    "status" => true,
                    "message" => "utente loggato",
                ];
            } else {
                return (Object) [
                    "status" => false,
                    "message" => funzioniGenerali::setMessaggio('Devi effettuare l&apos;accesso prima di procedere con l&apos;operazione. Vai alla pagina di <a href="../PAGES/login.php">login</a>', true)
                ];
            }
        }
    }
?>
