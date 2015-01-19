<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="./style/app-dist.css">
		<link rel="stylesheet" type="text/css" href="./style/index-dist.css">
        <title>Calendex - ce mois</title>
		<?php
		// Initialisation des données
		setlocale(LC_ALL, array('fr_FR.UTF-8','fr_FR@euro','fr_FR','fra_fra', 'french_france'));
		$aujourdhui_annee = (new \DateTime())->format('Y');
		$aujourdhui_mois  = (new \DateTime())->format('m');
		$aujourdhui_jour  = (new \DateTime())->format('d');
		$aujourdhui = new \DateTime($aujourdhui_annee. $aujourdhui_mois. $aujourdhui_jour);
		$_1erdumois = new \DateTime($aujourdhui_annee. $aujourdhui_mois. '01');
		$deb = clone $_1erdumois;
		$deb->modify('-1 month');
		$fin = clone $_1erdumois;
		$fin->modify('+2 month');
		function weInt2Abr( $weInt ){
			switch ($weInt) {
				case 0:
					return 'D';
				case 1:
					return 'L';
				case 2:
					return 'M';
				case 3:
					return 'M';
				case 4:
					return 'J';
				case 5:
					return 'V';
				case 6:
					return 'S';
				default:
					return '?';
			}
		}
		?>
    </head>
    <body>
		<div id="maste">
			<div id="header">
				<h1>
					<span class="logo"></span>
					<span class="titre"></span>
				</h1>
				<div class="btnnav">
					
				</div>
			</div>
			<div id="content">
				<?php 	for($mois = $deb; $mois < $fin; $mois->modify('1 month')): ?>
				<div class="mois">
					<?php if((int)$aujourdhui_mois != (int)$mois->format('m')):	?>
						<div class="masc"></div>
					<?php endif; ?>
					<div class="mois-in">
						<div class="titremois">
							<?= $mois->format('F') ; ?>
						</div>
						<div class="jours">
							<?php
							$jour = clone $mois;
							$refMois = $mois->format('m');
							while ( $jour->format('m') == $refMois ):
								$classeJour = 'jour';
								if(((int) $jour->format('w')) == 0 or ((int) $jour->format('w')) == 6){
									$classeJour .= ' we';
								}
								?>
							<table class="<?php echo $classeJour ; ?>">
								<tr>
									<td class="abrnomjour"><?= weInt2Abr($jour->format('w'));?></td>
									<td class="numjour"><?= $jour->format('j');?></td>
									<td class="event">
										<ul class="event-perp">
											<li>
												St Jean
											</li>
										</ul><ul class="event-norm">
											<li>12:00 Sandrine, Fafa</li>
											<li>18:00 Fabien, rdv ostéo</li>
										</ul>
									</td>
									<td class="za vac">&nbsp;</td>
									<td class="zb">&nbsp;</td>
									<td class="zc vac">&nbsp;</td>
									<td class="btnadd"><a href="" class="btn btnadd-perp">+</a>
									<a href="" class="btn btnadd-norm">+</a></td>
								</tr>
							</table>
							<?php $jour->modify('+1 day') ; endwhile; ?>
						</div>
					</div>
				</div>				
				<?php	endfor; ?>
			</div>
		</div>
    </body>
</html>
