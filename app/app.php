<?php
namespace App;

use App\Controler\Calindex;
use Core\AppAbstract;
use Core\Helper\Collection;

class App extends AppAbstract {

    function run()
    {
        $get = new Collection($_GET);
        $page = $get->getDefaut('p', 'calendrier');
                
        switch ($page){
            case 'calendrier':
                $calendar = new Calindex();

                if (isset($get->annee,$get->mois)){
                        $annee = (int)$get->annee;
                        $mois  = (int)$get->mois;
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