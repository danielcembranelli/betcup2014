<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class copa {

    public function getMelhorRanking($args) {
        $CI = &get_instance();
        $time1 = $CI->db->query("SELECT ranking FROM times WHERE id = ?", $args[0])->row(0);
        $time2 = $CI->db->query("SELECT ranking FROM times WHERE id = ?", $args[1])->row(0);

        //if (($time1->ranking + 1 == $time2->ranking) || $time1->ranking - 1 == $time2->ranking)
            //return 2;

        //if ($time1->ranking < $time2->ranking)
            //return 1;
        //else
            //return 3;
		return mt_rand(1, 3);
    }

    public function getChaves($count = null) {
        $a = Array('A1', 'A2', 'A3', 'A4', 'B1', 'B2', 'B3', 'B4', 'C1', 'C2', 'C3', 'C4', 'D1', 'D2', 'D3', 'D4', 'E1', 'E2', 'E3', 'E4', 'F1', 'F2', 'F3', 'F4', 'G1', 'G2', 'G3', 'G4', 'H1', 'H2', 'H3', 'H4');
        return ($count == "count") ? count($a) : $a;
    }

    public function getFasePrimeira($count = null) {
        $a = Array('A1 A2', 'A3 A4', 'B1 B2', 'B3 B4', 'C1 C2', 'C3 C4', 'D1 D2', 'D3 D4', 'E1 E2', 'E3 E4', 'F1 F2', 'F3 F4', 'G1 G2', 'G3 G4', 'H1 H2', 'H3 H4', 'A1 A3', 'A2 A4', 'B1 B3', 'B2 B4', 'C1 C3', 'C2 C4', 'D1 D3', 'D2 D4', 'E1 E3', 'E2 E4', 'F1 F3', 'F2 F4', 'G1 G3', 'G2 G4', 'H1 H3', 'H2 H4', 'A1 A4', 'A2 A3', 'B1 B4', 'B2 B3', 'C1 C4', 'C2 C3', 'D1 D4', 'D2 D3', 'E1 E4', 'E2 E3', 'F1 F4', 'F2 F3', 'G1 G4', 'G2 G3', 'H1 H4', 'H2 H3');
        return ($count == "count") ? count($a) : $a;
    }

    public function getFaseOitavas($count = null) {
        $a = Array('1*A 2*B', '1*C 2*D', '1*B 2*A', '1*D 2*C', '1*E 2*F', '1*G 2*H', '1*F 2*E', '1*H 2*G');
        return ($count == "count") ? count($a) : $a;
    }

    public function getFaseQuartas($count = null) {
        $a = Array('J49 J50', 'J53 J54', 'J51 J52', 'J55 J56');
        return ($count == "count") ? count($a) : $a;
    }

    public function getFaseSemiFinal($count = null) {
        $a = Array('J57 J58', 'J59 J60');
        return ($count == "count") ? count($a) : $a;
    }

    public function getFaseTerceiroLugar($count = null) {
        $a = Array('P61 P62');
        return ($count == "count") ? count($a) : $a;
    }

    public function getFaseFinal($count = null) {
        $a = Array('V61 V62');
        return ($count == "count") ? count($a) : $a;
    }

    public function getEmpatadosFasePrimeira($args) {
        $CI = &get_instance();
        $v = $CI->db->query("SELECT * FROM jogos WHERE campeonato = ? AND fase = 'primeirafase' AND timea LIKE ?", array($args[0], $args[1] . '%'));
        $a = array();
        foreach ($v->result() as $row) {
            if (empty($a[$row->timea]))
                $a[$row->timea] = 0;
            if (empty($a[$row->timeb]))
                $a[$row->timeb] = 0;

            if ($row->defesa == "e") {
                $a[$row->timea] += 1;
                $a[$row->timeb] += 1;
            } else if ($row->defesa == "a") {
                $a[$row->timea] += 3;
            } else if ($row->defesa == "b") {
                $a[$row->timeb] += 3;
            }
        }
        arsort($a);

        $keys = array_keys($a);
        $values = array_values($a);

        if (($values[0] != $values[1]) && ($values[1] != $values[2]))
            $empate = 0;
        else
            $empate = 1;

        $times[] = $keys[0];
        $times[] = $keys[1];
        if ($values[1] == $values[2])
            $times[] = $keys[2];
        if ($values[1] == $values[3])
            $times[] = $keys[3];

        return array('empate' => $empate, 'primeirolivre' => ($values[0] != $values[1]) ? 1 : 0, 'times' => $times);
    }

    public function vencedoresFasePrimeira($args) {
        $CI = &get_instance();
        $v = $CI->db->query("SELECT * FROM jogos WHERE campeonato = ? AND fase = 'primeirafase' AND timea LIKE ?", array($args[0], $args[1] . '%'));
        $a = array();
        foreach ($v->result() as $row) {
            if (empty($a[$row->timea]))
                $a[$row->timea] = 0;
            if (empty($a[$row->timeb]))
                $a[$row->timeb] = 0;

            if ($row->defesa == "e") {
                $a[$row->timea] += 1;
                $a[$row->timeb] += 1;
            } else if ($row->defesa == "a") {
                $a[$row->timea] += 3;
            } else if ($row->defesa == "b") {
                $a[$row->timeb] += 3;
            }
        }
        arsort($a);

        $keys = array_keys($a);
        $values = array_values($a);

        if (($values[0] != $values[1]) && ($values[1] != $values[2])) {
            $empate = 0;
            $primeiro = $keys[0];
            $segundo = $keys[1];
        }
        else
            $empate = 1;

        return array('empate' => $empate, 'times' => array('0' => $primeiro, '1' => $segundo), $a);
    }

    public function vencedoresFaseOitavas($args) {
        $CI = &get_instance();
        $j = $CI->db->query("SELECT * FROM jogos WHERE fase = 'oitavas' AND campeonato = ? AND jogo = ?", $args)->row(0);

        if ($j->defesa == "p")
            $time = ($j->defesapenalti == "a") ? $j->timea : $j->timeb;

        else if ($j->defesa == "a")
            $time = $j->timea;
        else
            $time = $j->timeb;

        return $time;
    }

    public function vencedoresFaseQuartas($args) {
        $CI = &get_instance();
        $j = $CI->db->query("SELECT * FROM jogos WHERE fase = 'quartas' AND campeonato = ? AND jogo = ?", $args)->row(0);

        if ($j->defesa == "p")
            $time = ($j->defesapenalti == "a") ? $j->timea : $j->timeb;
        else if ($j->defesa == "a")
            $time = $j->timea;
        else
            $time = $j->timeb;

        return $time;
    }

    public function vencedoresFaseSemiFinal($args) {
        $CI = &get_instance();
        $j = $CI->db->query("SELECT * FROM jogos WHERE fase = 'semifinal' AND campeonato = ? AND jogo = ?", $args)->row(0);

        if ($j->defesa == "p")
            $time = ($j->defesapenalti == "a") ? $j->timea : $j->timeb;
        else if ($j->defesa == "a")
            $time = $j->timea;
        else
            $time = $j->timeb;

        return $time;
    }

    public function perdedoresFaseSemiFinal($args) {
        $CI = &get_instance();
        $j = $CI->db->query("SELECT * FROM jogos WHERE fase = 'semifinal' AND campeonato = ? AND jogo = ?", $args)->row(0);

        if ($j->defesa == "p")
            $time = ($j->defesapenalti == "a") ? $j->timeb : $j->timea;
        else if ($j->defesa == "a")
            $time = $j->timeb;
        else
            $time = $j->timea;

        return $time;
    }

    public function getJogosFasePrimeira($args) {

        if ($args[0] == "A") {
            $A = Array(1, 2, 17, 18, 33, 34);
            return $A;
        } elseif ($args[0] == "B") {
            $B = Array(3, 4, 19, 20, 35, 36);
            return $B;
        } elseif ($args[0] == "C") {
            $C = Array(5, 6, 21, 22, 37, 38);
            return $C;
        } elseif ($args[0] == "D") {
            $D = Array(7, 8, 23, 24, 39, 40);
            return $D;
        } elseif ($args[0] == "E") {
            $E = Array(9, 10, 25, 26, 41, 42);
            return $E;
        } elseif ($args[0] == "F") {
            $F = Array(11, 12, 27, 28, 43, 44);
            return $F;
        } elseif ($args[0] == "G") {
            $G = Array(13, 14, 29, 30, 45, 46);
            return $G;
        } elseif ($args[0] == "H") {
            $H = Array(15, 16, 31, 32, 47, 48);
            return $H;
        }
    }

    public function getInfoJogo($args) {
        $CI = &get_instance();
        return $CI->db->query("SELECT DATE_FORMAT(datajogo, '%d/%m') AS data, DATE_FORMAT(datajogo, '%h:%i') AS hora, timea, timeb, local FROM jogos WHERE campeonato = ? AND jogo = ?", $args)->row(0);
    }

    public function getInfoTime($args) {
        $CI = &get_instance();
        return $CI->db->query("SELECT times.id, times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chaves.chave = ?", $args)->row(0);
    }

    public function getGrupoJogoFasePrimeira($args) {
        $j = Array(1 => 'A', 2 => 'A', 17 => 'A', 18 => 'A', 33 => 'A', 34 => 'A', 3 => 'B', 4 => 'B', 19 => 'B', 20 => 'B', 35 => 'B', 36 => 'B', 5 => 'C', 6 => 'C', 21 => 'C', 22 => 'C', 37 => 'C', 38 => 'C', 7 => 'D', 8 => 'D', 23 => 'D', 24 => 'D', 39 => 'D', 40 => 'D', 9 => 'E', 10 => 'E', 25 => 'E', 26 => 'E', 41 => 'E', 42 => 'E', 11 => 'F', 12 => 'F', 27 => 'F', 28 => 'F', 43 => 'F', 44 => 'F', 13 => 'G', 14 => 'G', 29 => 'G', 30 => 'G', 45 => 'G', 46 => 'G', 15 => 'H', 16 => 'H', 31 => 'H', 32 => 'H', 47 => 'H', 48 => 'H');
        return $j[$args];
    }

    public function vencedoresApostaFasePrimeira($args) {
        $CI = &get_instance();
        $v = $CI->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'primeirafase' AND timea LIKE ?", array($args[0], $args[1] . '%'));
        $a = array();
        foreach ($v->result() as $row) {
            if (empty($a[$row->timea]))
                $a[$row->timea] = 0;
            if (empty($a[$row->timeb]))
                $a[$row->timeb] = 0;

            if ($row->defesa == "e") {
                $a[$row->timea] += 1;
                $a[$row->timeb] += 1;
            } else if ($row->defesa == "a") {
                $a[$row->timea] += 3;
            } else if ($row->defesa == "b") {
                $a[$row->timeb] += 3;
            }
        }
        arsort($a);

        $keys = array_keys($a);
        $values = array_values($a);

        $primeiro = "";
        $segundo = "";
        if (($values[0] != $values[1]) && ($values[1] != $values[2])) {
            $empate = 0;
            $primeiro = $keys[0];
            $segundo = $keys[1];
        }
        else
            $empate = 1;

        return array('empate' => $empate, 'times' => array('0' => $primeiro, '1' => $segundo));
    }

    public function getEmpatadosApostaFasePrimeira($args) {
        $CI = &get_instance();
        $v = $CI->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'primeirafase' AND timea LIKE ?", array($args[0], $args[1] . '%'));
        $a = array();
        foreach ($v->result() as $row) {
            if (empty($a[$row->timea]))
                $a[$row->timea] = 0;
            if (empty($a[$row->timeb]))
                $a[$row->timeb] = 0;

            if ($row->defesa == "e") {
                $a[$row->timea] += 1;
                $a[$row->timeb] += 1;
            } else if ($row->defesa == "a") {
                $a[$row->timea] += 3;
            } else if ($row->defesa == "b") {
                $a[$row->timeb] += 3;
            }
        }
        arsort($a);

        $keys = array_keys($a);
        $values = array_values($a);

        if (($values[0] != $values[1]) && ($values[1] != $values[2]))
            $empate = 0;
        else
            $empate = 1;

        $times[] = $keys[0];
        $times[] = $keys[1];
        if ($values[1] == $values[2])
            $times[] = $keys[2];
        if ($values[1] == $values[3])
            $times[] = $keys[3];

        return array('empate' => $empate, 'primeirolivre' => ($values[0] != $values[1]) ? 1 : 0, 'times' => $times);
    }

    public function vencedoresApostaFasePrimeira_Editar($args) {
        $CI = &get_instance();
        $v = $CI->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'primeirafase' AND timea LIKE ?", array($args[0], $args[1] . '%'));
        $a = array();
        foreach ($v->result() as $row) {
            if (empty($a[$row->timea]))
                $a[$row->timea] = 0;
            if (empty($a[$row->timeb]))
                $a[$row->timeb] = 0;

            if ($row->defesa == "e") {
                $a[$row->timea] += 1;
                $a[$row->timeb] += 1;
            } else if ($row->defesa == "a") {
                $a[$row->timea] += 3;
            } else if ($row->defesa == "b") {
                $a[$row->timeb] += 3;
            }
        }
        arsort($a);

        $keys = array_keys($a);
        $values = array_values($a);

        $primeiro = "";
        $segundo = "";
        if (($values[0] != $values[1]) && ($values[1] != $values[2])) {
            $empate = 0;
            $primeiro = $keys[0];
            $segundo = $keys[1];
        }
        else
            $empate = 1;

        return array('empate' => $empate, 'times' => array('0' => $primeiro, '1' => $segundo));
    }

    public function getEmpatadosApostaFasePrimeira_Editar($args) {
        $CI = &get_instance();
        $v = $CI->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'primeirafase' AND timea LIKE ?", array($args[0], $args[1] . '%'));
        $a = array();
        foreach ($v->result() as $row) {
            if (empty($a[$row->timea]))
                $a[$row->timea] = 0;
            if (empty($a[$row->timeb]))
                $a[$row->timeb] = 0;

            if ($row->defesa == "e") {
                $a[$row->timea] += 1;
                $a[$row->timeb] += 1;
            } else if ($row->defesa == "a") {
                $a[$row->timea] += 3;
            } else if ($row->defesa == "b") {
                $a[$row->timeb] += 3;
            }
        }
        arsort($a);

        $keys = array_keys($a);
        $values = array_values($a);

        if (($values[0] != $values[1]) && ($values[1] != $values[2]))
            $empate = 0;
        else
            $empate = 1;

        $times[] = $keys[0];
        $times[] = $keys[1];
        if ($values[1] == $values[2])
            $times[] = $keys[2];
        if ($values[1] == $values[3])
            $times[] = $keys[3];

        return array('empate' => $empate, 'primeirolivre' => ($values[0] != $values[1]) ? 1 : 0, 'times' => $times);
    }
    
    public function getChavesGrupo($args) {
        $CI = &get_instance();
        $premio = $CI->db->query("SELECT campeonato FROM premios WHERE id = ?", $CI->uri->segment(3))->row(0);
        $v = $CI->db->query("SELECT chaves.chave, times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id AND chaves.campeonato = times.campeonato WHERE chaves.campeonato = ? AND chaves.chave LIKE ? ORDER BY chaves.chave ASC", array($premio->campeonato, $args[0] . '%'));
        $v = $v->result();
        
        return $v;
    }

}