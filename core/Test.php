<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of Test
 *
 * @author fabien.sanchez
 */
class Test {

protected $class_test = '';

const ICO_OK = "<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:svg=\"http://www.w3.org/2000/svg\" 
width=\"20\" height=\"20\"><metadata id=\"metadata4151\">image/svg+xml</metadata>
<title>Layer 1</title><g id=\"layer1\"><circle fill=\"#00ff00\" stroke-width=\"40\" 
stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" 
id=\"path4696\" cx=\"10\" cy=\"10\" r=\"8\"/><path fill=\"none\" stroke=\"#7eff7e\" 
stroke-width=\"1\" stroke-linecap=\"round\" stroke-linejoin=\"round\" 
stroke-miterlimit=\"4\" id=\"path4698\" d=\"m4 11a6 6 0 0 1 2-6 6 6 0 0 1 6-2\"/>
<path fill=\"none\" fill-rule=\"evenodd\" stroke=\"#005700\" stroke-width=\"2\" 
stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" 
d=\"m14 6c-2 2-4 5-5 8l-3-3\" id=\"path4708\"/></g></svg>";
const ICO_KO = "<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:svg=\"http://www.w3.org/2000/svg\" 
width=\"20\" height=\"20\"><metadata>image/svg+xml</metadata><title>Layer 1</title>
<circle fill=\"#ff0000\" stroke-width=\"40\" stroke-linecap=\"round\" 
stroke-linejoin=\"round\" stroke-miterlimit=\"4\" cx=\"10\" cy=\"10\" r=\"8\"/>
<path fill=\"none\" stroke=\"#ff7e7e\" stroke-width=\"1\" stroke-linecap=\"round\" 
stroke-linejoin=\"round\" stroke-miterlimit=\"4\" d=\"m4 11a6 6 0 0 1 2-6 6 6 0 0 1 6-2\"/>
<path fill=\"none\" fill-rule=\"evenodd\" stroke=\"#ffffff\" stroke-width=\"2\" 
stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" d=\"m10 5l0 7\"/>
<circle fill=\"#ffffff\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" 
stroke-miterlimit=\"4\" r=\"1\" cy=\"15\" cx=\"10\"/></svg>";

function __construct() {
$this->class_test = get_class($this);
}

function run() {
?>
<div class="test_class">
    <h3>Test de la class <span class="class_name"><?= $this->class_test; ?></span></h3>
    <?php
    $methodes = get_class_methods($this->class_test);
    foreach ($methodes as $methode) {
    if (substr($methode, 0, 6) == 'test__'){
    $methode_name = substr($methode, 6);
    ob_start();
    $succes = call_user_func(array($this, $methode));
    $comment = ob_get_contents();
    ob_end_clean();    
    ?>
    <div class="test_methode <?= ($succes)?"ok":"ko"; ?>">
        <p>Test de la methode <span class="methode_name"><?= $methode_name; ?></span></p>
        <p class="test_methode_comment"><?= $comment; ?></p>
    </div>
    <?php
    }
    }
    ?>
</div>
<?php
}

function testEgal($elementTest, $elementComparaison, $libelle) {
$succes = ($elementTest == $elementComparaison);
if ($succes) {
    echo 
}
return array($succes, $comment);
}

}
