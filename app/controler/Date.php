<?php

namespace App\Controler;

use Core\Pattern\GetterSetter;

class DateException extends \Exception {
    
}

class DateNotValidException extends DateException {
    
}

class Date {

    use GetterSetter;

    static private $dico = [
        'fr' => [
            'mois' => ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
                'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
            'mois_abr' => ['jan.', 'fév.', 'mars', 'avr.', 'mai', 'juin',
                'jui.', 'aout', 'sep.', 'oct.', 'nov.', 'déc.'],
            'jour' => ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'],
            'jour_abr' => ['lu.', 'ma.', 'me.', 'je.', 've.', 'sa.', 'di.']
        ],
        // TODO: ajoute la culture english
        'en' => [
            'mois' => ['january'],
            'mois_abr' => [],
            'jour' => [],
            'jour_abr' => []
        ],
    ];
    static public $culture = 'fr';
    private $year;

    private function set_year(/* int */$year) {
        $this->year = $year;
    }

    private function get_year() {
        return $this->year;
    }

    private $month;

    private function set_month(/* int */$month) {
        $this->month = $month;
    }

    private function get_month() {
        return $this->month;
    }

    private $day;

    private function set_day(/* int */$day) {
        $this->day = $day;
    }

    private function get_day() {
        return $this->day;
    }

    public function __construct(/* string */$date = null) {
        if ($date === null) {
            $date = date("Ymd");
        }
        $day = 1;
        $month = 1;
        if (strlen($date) > 4) {
            if (strlen($date) > 6) {
                $day = (int) substr($date, -2);
                $date = substr($date, 0, -2);
            }
            $month = (int) substr($date, -2);
            $date = substr($date, 0, -2);
        }
        if (strlen($date) > 0) {
            $this->set_year((int) $date);
            $this->set_month($month);
            $this->set_day($day);
        }
    }

    public function __toString() {
        return \sprintf("%04d%02d%02d", $this->year, $this->month, $this->day);
    }

    public function add_day($nb_day, $clone = false) {
        if ($clone) {
            $date = clone $this;
        } else {
            $date = $this;
        }
        if ($nb_day == 0) {
            return $date;
        }
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;
        if ($nb_day > 0) {
            for ($p = 0; $p < $nb_day; $p++) {
                $day++;
                if ($day > self::nb_jours_mois($year, $month)) {
                    $day = 1;
                    $month++;
                    if ($month > 12) {
                        $month = 1;
                        $year++;
                    }
                }
            }
            $date->year = $year;
            $date->month = $month;
            $date->day = $day;
        } else {
            $date->sub_day(abs($nb_day));
        }
        return $date;
    }

    public function sub_day($day, $clone = false) {
        if ($clone) {
            $date = clone $this;
        } else {
            $date = $this;
        }
        if ($nb_day == 0) {
            return $date;
        }
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;
        if ($nb_day > 0) {
            for ($p = 0; $p < $nb_day; $p++) {
                $day++;
                if ($day < 1) {
                    $month--;
                    if ($month < 1) {
                        $month = 12;
                        $year--;
                    }
                    $day = self::nb_jours_mois($year, $month);
                }
            }
            $date->year = $year;
            $date->month = $month;
            $date->day = $day;
        } else {
            $date->add_day(abs($nb_day));
        }
        return $date;
    }

    public function add_month($nb_month, $clone = false) {
        if ($clone) {
            $date = clone $this;
        } else {
            $date = $this;
        }
        if ($nb_month == 0) {
            return $date;
        }
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;
        if ($nb_month > 0) {
            while ($nb_month-- > 0) {
                $month++;
                if ($month > 12) {
                    $month = 1;
                    $year++;
                }
            }
            $day = min($day, self::nb_jours_mois($year, $month));
            $date->year = $year;
            $date->month = $month;
            $date->day = $day;
        } else {
            $date->sub_month(abs($nb_month));
        }
        return $date;
    }

    public function sub_month($nb_month, $clone = false) {
        if ($clone) {
            $date = clone $this;
        } else {
            $date = $this;
        }
        if ($nb_month == 0) {
            return $date;
        }
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;
        if ($nb_month > 0) {
            while ($nb_month-- > 0) {
                $month--;
                if ($month < 1) {
                    $month = 12;
                    $year--;
                }
            }
            $day = min($day, self::nb_jours_mois($year, $month));
            $date->year = $year;
            $date->month = $month;
            $date->day = $day;
        } else {
            $date->add_month(abs($nb_month));
        }
        return $date;
    }

    static public function annee_bisextille($year) {
        return (($year % 400) == 0) || (($year % 4) == 0 && ($year % 100) != 0);
    }

    static public function nb_jours_mois($year, $month) {
        switch ($month) {
            case 2:
                if (self::annee_bisextille($year)) {
                    return 29;
                } else {
                    return 28;
                }
            case 4:
            case 6:
            case 9:
            case 11:
                return 30;
            default:
                return 31;
        }
    }

    static public function dimanche_paques($year) {
        $divmod = function($a, $b) {
            $c = (int) $a / $b;
            $d = $a % $b;
            return [$c, $d];
        };
        $n = $year % 19;
        list($c, $u) = $divmod($year, 100);
        list($s, $t) = $divmod($c, 4);
        $p = (int) (($c + 8) / 25);
        $q = (int) (($c - $p + 1) / 3);
        $e = ( 19 * $n + $c - $s - $q + 15) % 30;
        list($b, $d) = $divmod($u, 4);
        $l = (32 + 2 * $t + 2 * $b - $e - $d) % 7;
        $h = (int) (($n + 11 * $e + 22 * $l) / 451);
        list($m, $j) = $divmod($e + $l - 7 * $h + 114, 31);
        $j += 1;
        return Self::make($year, $m, $j);
    }

    static public function lundi_paques($year) {
        $paques = self::dimanche_paques($year);
        return $paques->add_day(1);
    }

    static public function ascension($year) {
        $paques = self::dimanche_paques($year);
        return $paques->add_day(39);
    }

    static public function pentecote($year) {
        $paques = self::dimanche_paques($year);
        return $paques->add_day(50);
    }

    static public function jour_semaine($y, $m, $d) {
        $D = 0;
        if ($m > 3) {
            $D = ( (int) ((23 * $m) / 9) + $d + 4 + $y + (int) ($y / 4) -
                    (int) ($y / 100) + (int) ($y / 400) - 2 );
        } else {
            $z = $y - 1;
            $D = ( (int) ((23 * $m) / 9) + $d + 4 + $y + (int) ($z / 4) -
                    (int) ($z / 100) + (int) ($z / 400) );
        }
        return (($D - 1) % 7) + 1;
    }

    static public function make($year, $month, $day) {
        return new self(\sprintf("%04d%02d%02d", $year, $month, $day));
    }

    public function format($format = 'yyyymmdd') {
        $culture = self::$culture;
        $dico = self::$dico[$culture];
        $pattern = '/(yyyy|yy|m{1,4}|d{1,4})*/';
        $yyyy = (string) $this->year;
        $yy = (string) ($this->year % 100);
        $mmmm = $dico['mois'][($this->month - 1)];
        $mmm = $dico['mois_abr'][($this->month - 1)];
        $mm = substr("0" . (string) $this->month, -2);
        $m = (string) $this->month;
        $j = self::jour_semaine($this->year, $this->month, $this->day);
        $dddd = $dico['jour'][$j - 1];
        $ddd = $dico['jour_abr'][$j - 1];
        $dd = substr("0" . (string) $this->day, -2);
        $d = (string) $this->day;
        $matches = ['yyyy', 'yy', 'mmmm', 'mmm', 'mm', 'm', 'dddd', 'ddd', 'dd', 'd', 'j'];
        $pt = 0;
        $out = '';
        while ($pt < strlen($format)) {
            $ismatche = false;
            $matche = '';
            if (in_array(substr($format, $pt, 1), ['y', 'm', 'd', 'j'])) {
                $i = 0;
                $matche = '';
                while ((!$ismatche) && $i < count($matches)) {
                    $matche = $matches[$i];
                    if (substr($format, $pt, strlen($matche)) == $matche) {
                        $ismatche = true;
                    }
                    $i++;
                }
                unset($i);
            }
            if ($ismatche) {
                $out.= ${$matche};
                $pt += strlen($matche);
            } elseif (substr($format, $pt, 1) == '\\') {
                $pt++;
                $out .= substr($format, $pt, 1);
                $pt++;
            } else {
                $out .= substr($format, $pt, 1);
                $pt++;
            }
        }
        return $out;
    }

}
