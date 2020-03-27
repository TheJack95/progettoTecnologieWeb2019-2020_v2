<?php
    class funzioniGenerali {
    #funzione per scrivere l'header
        public static function header() {
            $header_form = '<div id="header">'
                                .'<a href=""><img class="logoHeader" src="" alt="" /></a>'
                                .'<p class="nomeSito"><a href="">CONCESSIONARIA GREG</a></p>'
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
                               .'</div>';
            return $breadcrumb_form;
        }
    
    #funzione per scrivere il menu'
        public static function menu(){
            if(!isset($_SESSION)) {
                session_start();
            }
            $menu_form = '<ul>'
                            .'<li><a href="home.php"><span xml:lang="en">HOMEPAGE</span></a></li>'
                            .'<li><a href="noleggioVeicoli.php">VEICOLI A NOLEGGIO</a></li>'
                            .'<li><a href="acquistaVeicoli.php">VEICOLI IN VENDITA</a></li>'
                            .'<li><a href="contatti.php">CONTATTI</a></li>';
            
            if(isset($_SESSION["logged"]) && $_SESSION["logged"]->status == 2) { //login effettuato correttamente
                $menu_form .= '<li><a class="" href="">AREA PERSONALE</a></li>'
                            .'<li><a class="" href="">ESCI</a></li>'
                        .'</ul>';
            } else { //non ho fatto il login oppure qualcosa E' andato storto
                $menu_form .= '<li><a class="" href="">ACCEDI</a></li>'
                        .'</ul>';
            }
            return $menu_form;
        }
    
    #funzione per scrivere il footer
        public static function footer() {
            $footer_form = '<div id="footer">'
                                .'<p>CONCESSIONARIA GREG - Tutti i diritti riservati - A cura di <span xml:lang="en">Tecweb Group</span></p>'
                          .'</div>';
            return $footer_form;
        }
    }
?>