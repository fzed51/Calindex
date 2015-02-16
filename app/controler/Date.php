<?php

namespace App\Controler;

use Core\Pattern\GetterSetter;

class DateException extends \Exception {
    
}

class DateNotValidException extends DateException {
    
}

class Date {

    use GetterSetter;

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
        return $this->year;
    }

    private $day;

    private function set_day(/* int */$day) {
        $this->day = $day;
    }

    private function get_day() {
        return $this->year;
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

    public function add_day($day, $clone = false) {
        if ($clone) {
            $date = clone $this;
        } else {
            $date = $this;
        }
        if ($day == 0) {
            return $date;
        }
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;
        for ($p = 0; $p < abs($day); $p++) {
            if ($day > 0) {
                $day = $this->day++;
                if ($day > self::nb_jours_mois($year, $month)) {
                    $day = 1;
                    $month++;
                    if ($month > 12) {
                        $month = 1;
                        $year++;
                    }
                }
            } else {
                $day = $this->day++;
                if ($day < 1) {
                    $month--;
                    if ($month < 1) {
                        $month = 12;
                        $year--;
                    }
                    $day = self::nb_jours_mois($year, $month);
                }
            }
        }
        $date->year = $year;
        $date->month = $month;
        $date->day = $day;
        return $date;
    }

    public function add_month($month, $clone = false) {
        if ($clone) {
            $date = clone $this;
        } else {
            $date = $this;
        }
        if ($month == 0) {
            return $date;
        }
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;
        for ($p = 0; $p < abs($month); $p++) {
            if ($month > 0) {
                $month++;
                if ($month > 12) {
                    $month = 1;
                    $year++;
                }
            } else {
                $month--;
                if ($month < 1) {
                    $month = 12;
                    $year--;
                }
            }
        }
        $day = min($day, self::nb_jours_mois($year, $month));
        $date->year = $year;
        $date->month = $month;
        $date->day = $day;
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
            return [$a, $b];
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
        $j = $j + 1;
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

    static public function make($year, $month, $day) {
        return new self(\sprintf("%04d%02d%02d", $year, $month, $day));
    }

}
