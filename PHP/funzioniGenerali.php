<?php
    class funzioniGenerali {
    #funzione per scrivere l'header
        public static function header() {
            $header_form = '<div id="header">'
                                .'<a href="home.php"><img class="logoHeader" src="" alt="" /></a>'
                                .'<p class="nomeSito"><a href="home.php">CONCESSIONARIA GREG</a></p>'
                        .'</div>';
            return $header_form;
        }

    #funzione per scrivere i breadcrumb
        public static function breadcrumb(...$sequenza){
            $breadcrumb_form = '<div id="breadcrumb">'
                                    .'<p>Ti trovi in: ';
            foreach($sequenza as $element){
                $breadcrumb_form .= "$element ";
            }
            $breadcrumb_form .=     "</p>"
                               .'</div>'."\n";

            $breadcrumb_form .= "<noscript>"."\n"
                                ."    <h2>"."\n"
                                ."        Il tuo browser non supporta JavaScript oppure &egrave; stato disabilitato. Alcune funzionalit&agrave; potrebbero non funzionare correttamente."."\n"
                                ."    </h2>"."\n"
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
            $menu_form = '<ul>'
                            .'<li tabindex="1"><a href="home.php"><span xml:lang="en">HOME</span></a></li>'
                            .'<li tabindex="2"><a href="noleggioVeicoli.php">VEICOLI A NOLEGGIO</a></li>'
                            .'<li tabindex="3"><a href="acquistaVeicoli.php">VEICOLI IN VENDITA</a></li>'
                            .'<li tabindex="4"><a href="contatti.php">CONTATTI</a></li>';

            if(isset($_SESSION["user"])) { //login effettuato correttamente
                $menu_form .= '<li tabindex="5"><a class="" href="areaPrivata.php">AREA PERSONALE</a></li>'
                            .'<li tabindex="6"><a class="" href="../PHP/logout.php">ESCI</a></li>'
                        .'</ul>';
            } else { //non ho fatto il login oppure qualcosa e' andato storto
                $menu_form .= '<li tabindex="5"><a class="" href="login.php">ACCEDI</a></li>'
                        .'</ul>';
            }
            return $menu_form;
        }

        /**
         * Funzione per scrivere il footer
         */
        public static function footer() {
            $footer_form = '<div id="footer">'
                                .'<p>CONCESSIONARIA GREG - Tutti i diritti riservati - A cura di <span xml:lang="en">Tecweb Group</span></p>'
                          .'</div>';
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

            $output = file_get_contents("../HTML/paginaVuota.html");
            $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Errore"),$output);
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
                    "message" => funzioniGenerali::setMessaggio("Devi effettuare l&apos;accesso prima di procedere con l&apos;operazione. Verrai reindirizzato alla pagina di login", true)
                ];
            }
        }
    }
?>
