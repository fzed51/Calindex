<?php
namespace App;

class App extends \Core\AppAbstract {

    function run()
    {
        if(isset($_GET['p'])){
            $page = $_GET['p'];
        }else{
            $page='calendrier';
        }
        
        switch ($page){
            case 'calendrier':
                $calendar = new \Calindex();

                if (isset($_GET['annee'], $_GET['mois'])){
                        $annee = (int)$_GET['annee'];
                        $mois  = (int)$_GET['mois'];
                        if($mois < 1 || $mois > 12){
                                $calendar->index();
                        }else{
                                $calendar->affiche($annee, $mois);
                        }
                }else{
                        $calendar->index();
                }
                break;
        }
    }

}