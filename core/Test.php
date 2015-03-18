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

	protected $class_test   = '';
	private   $nbSuccess_c  = 0;
	private   $nbTest_c     = 0;
	private   $nbSuccess_m  = 0;
	private   $nbTest_m     = 0;

	const ICO_OK = "<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:svg=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\"><metadata id=\"metadata4151\">image/svg+xml</metadata><title>Layer 1</title><g id=\"layer1\"><circle fill=\"#00ff00\" stroke-width=\"40\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" id=\"path4696\" cx=\"10\" cy=\"10\" r=\"8\"/><path fill=\"none\" stroke=\"#7eff7e\" stroke-width=\"1\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" id=\"path4698\" d=\"m4 11a6 6 0 0 1 2-6 6 6 0 0 1 6-2\"/><path fill=\"none\" fill-rule=\"evenodd\" stroke=\"#005700\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" d=\"m14 6c-2 2-4 5-5 8l-3-3\" id=\"path4708\"/></g></svg>";
	const ICO_KO = "<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:svg=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\"><metadata>image/svg+xml</metadata><title>Layer 1</title><circle fill=\"#ff0000\" stroke-width=\"40\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" cx=\"10\" cy=\"10\" r=\"8\"/><path fill=\"none\" stroke=\"#ff7e7e\" stroke-width=\"1\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" d=\"m4 11a6 6 0 0 1 2-6 6 6 0 0 1 6-2\"/><path fill=\"none\" fill-rule=\"evenodd\" stroke=\"#ffffff\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" d=\"m10 5l0 7\"/><circle fill=\"#ffffff\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"4\" r=\"1\" cy=\"15\" cx=\"10\"/></svg>";

	function __construct() {
		$this->class_test = get_class($this);
	}
	
	private function startTestClass() {
		$this->nbSuccess_c=0;
		$this->nbTest_c   =0;
		$this->nbSuccess_m=0;
		$this->nbTest_m   =0;
	}
	private function startTestMethode() {
		$this->nbSuccess_m=0;
		$this->nbTest_m   =0;
	}
	private function getPourcentSuccessMethode() {
		if ($this->nbTest_m == 0) {
			return "****%";
		} else {
			return round(100 * $this->nbSuccess_m / $this->nbTest_m, 1) . "%";
		}
	}	
	private function getPourcentSuccessClass() {
		if ($this->nbTest_c == 0) {
			return "****%";
		} else {
			return round(100 * $this->nbSuccess_c / $this->nbTest_c, 1) . "%";
		}
	}
	private function registerResult($result) {
		$this->nbTest_c++;
		$this->nbTest_m++;
		if ($result) {
			$this->nbSuccess_c++;
			$this->nbSuccess_m++;
		}
	}

	function run() {
		$this->startTestClass();
		?>
		<div class="test_class">
			<h3>Test de la class <span class="class_name"><?= $this->class_test; ?></span></h3>
			<?php
			$methodes = get_class_methods($this->class_test);
			foreach ($methodes as $methode) {
				if (substr($methode, 0, 6) == 'test__') {
					$methode_name = substr($methode, 6);
					$this->startTestMethode();
					ob_start();
					$succes = call_user_func(array($this, $methode));
					$comment = ob_get_contents();
					ob_end_clean();
					?>
			<div class="test_methode <?= ($succes) ? "ok" : "ko"; ?>">
				<div class="test_methode_resume ihiddable"><?= $this->getPourcentSuccessMethode();?></div>
				<p>Test de la methode <span class="methode_name"><?= $methode_name; ?></span></p>
				<div class="test_methode_comment hiddable"><?= $comment; ?></div>
			</div>
					<?php
				}
			}
			?>
			<div class="test_class_resume"><?= $this->getPourcentSuccessClass();?></div>
		</div>
		<?php
	}

	function show_var($name, $val){
		ob_start();
		var_dump($val);
		$contents = ob_get_contents();
		ob_end_clean();
		echo "<div>Variable \$$name : $contents</div>";
	}
	
	function testEgal($elementTest, $elementComparaison, $libelle) {
		$succes = ($elementTest == $elementComparaison);
		if ($succes) {
			echo "<p>" . self::ICO_OK . nl2br($libelle) . "</p>";
		} else {
			echo "<p>" . self::ICO_KO . nl2br($libelle) . "</p>";
		}
		$this->registerResult($succes);
		return $succes;
	}


}
