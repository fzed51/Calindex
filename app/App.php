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
        
        switch ($page {
            case 'calendrier':
            break;
        }
    }

}