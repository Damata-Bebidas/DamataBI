<?php
/**
 * Description of check
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class checkReacao implements crudBasic {
    private $db,$id_check, $id_key_check, $id_tr, $matricula, $freq,
            $qt1,$qt2,$qt3,$qt4,$qt5,$qt6,$qt7,$qt8,$qt9,$qt10,$obs;
//construtor
function __construct(\PDO $db) {
    $this->db = $db;
}
//metodos modificadores
public function find($id){
    $query = "SELECT * FROM `checkReacao` WHERE `id_key_check`=:id ORDER BY `id_check` ASC;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function vericarStatus($id){
    $query = "SELECT * FROM `checkReacao` WHERE `id_check`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function consult(){
    $query = "SELECT * FROM `checkReacao`;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function inserir() {
    $query = "INSERT INTO `checkReacao`(`id_check`, `id_key_check`, `id_tr`, "
            . "`matricula`, `freq`, `QT1_1`, `QT1_2`, `QT2_1`, `QT2_2`, `QT2_3`,"
            . "`QT3_1`, `QT3_2`, `QT3_3`, `QT3_4`, `QT3_5`, `Obs`) VALUES ("
            . ":id_check,:id_key_check,:id_tr,:mat,:freq,:QT1_1,:QT1_2,:QT2_1,"
            . ":QT2_2,:QT2_3,:QT3_1,:QT3_2,:QT3_3,:QT3_4,:QT3_5,:obs);";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_check',$this->getId_check());
    $stmt->bindValue(':id_key_check',$this->getId_key_check());
    $stmt->bindValue(':id_tr',$this->getId_tr());
    $stmt->bindValue(':mat',$this->getMatricula());
    $stmt->bindValue(':freq',$this->getFreq());
    $stmt->bindValue(':QT1_1',$this->getQt1());
    $stmt->bindValue(':QT1_2',$this->getQt2());
    $stmt->bindValue(':QT2_1',$this->getQt3());
    $stmt->bindValue(':QT2_2',$this->getQt4());
    $stmt->bindValue(':QT2_3',$this->getQt5());
    $stmt->bindValue(':QT3_1',$this->getQt6());
    $stmt->bindValue(':QT3_2',$this->getQt7());
    $stmt->bindValue(':QT3_3',$this->getQt8());
    $stmt->bindValue(':QT3_4',$this->getQt9());
    $stmt->bindValue(':QT3_5',$this->getQt10());
    $stmt->bindValue(':obs',$this->getObs());
    $stmt->execute();
}
public function alterar() {
    $query = "UPDATE `checkReacao` SET `id_key_check`=:id_key_check,`id_tr`=:id_tr,"
            . "`matricula`=:mat,`freq`=:freq,`QT1`=:QT1_1,`QT2`=:QT1_2,`QT3`=:QT2_1,"
            . "`QT4`=:QT2_2,`QT5`=:QT2_3,`QT6`=:3_1,`QT7`=:QT3_2,`QT8`=:QT3_3,"
            . "`QT9`=:QT3_4,`QT10`=:QT3_5 WHERE `id_check`=:id_check";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_check',$this->getId_check());
    $stmt->bindValue(':id_key_check',$this->getId_key_check());
    $stmt->bindValue(':id_tr',$this->getId_tr());
    $stmt->bindValue(':mat',$this->getMatricula());
    $stmt->bindValue(':freq',$this->getFreq());
    $stmt->bindValue(':QT1_1',$this->getQt1());
    $stmt->bindValue(':QT1_2',$this->getQt2());
    $stmt->bindValue(':QT2_1',$this->getQt3());
    $stmt->bindValue(':QT2_2',$this->getQt4());
    $stmt->bindValue(':QT2_3',$this->getQt5());
    $stmt->bindValue(':QT3_1',$this->getQt6());
    $stmt->bindValue(':QT3_2',$this->getQt7());
    $stmt->bindValue(':QT3_3',$this->getQt8());
    $stmt->bindValue(':QT3_4',$this->getQt9());
    $stmt->bindValue(':QT3_5',$this->getQt10());
    $stmt->bindValue(':obs',$this->getObs());
    $stmt->execute();
    if($stmt->execute()){
        return true;
    };
}
public function deletar($id) {
    $query = "DELETE FROM `checkReacao` WHERE `id_check`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id', $id);
    if($stmt->execute()){
        return true;
    };
}
// get and setter
    function getId_check() {
        return $this->id_check;
    }

    function getId_key_check() {
        return $this->id_key_check;
    }

    function getId_tr() {
        return $this->id_tr;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function getFreq() {
        return $this->freq;
    }

    function getQt1() {
        return $this->qt1;
    }

    function getQt2() {
        return $this->qt2;
    }

    function getQt3() {
        return $this->qt3;
    }

    function getQt4() {
        return $this->qt4;
    }

    function getQt5() {
        return $this->qt5;
    }

    function getQt6() {
        return $this->qt6;
    }

    function getQt7() {
        return $this->qt7;
    }

    function getQt8() {
        return $this->qt8;
    }

    function getQt9() {
        return $this->qt9;
    }

    function getQt10() {
        return $this->qt10;
    }

    function setId_check($id_check) {
        $this->id_check = $id_check;
        return $this;
    }

    function setId_key_check($id_key_check) {
        $this->id_key_check = $id_key_check;
        return $this;
    }

    function setId_tr($id_tr) {
        $this->id_tr = $id_tr;
        return $this;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }

    function setFreq($freq) {
        $this->freq = $freq;
        return $this;
    }

    function setQt1($qt1) {
        $this->qt1 = $qt1;
        return $this;
    }

    function setQt2($qt2) {
        $this->qt2 = $qt2;
        return $this;
    }

    function setQt3($qt3) {
        $this->qt3 = $qt3;
        return $this;
    }

    function setQt4($qt4) {
        $this->qt4 = $qt4;
        return $this;
    }

    function setQt5($qt5) {
        $this->qt5 = $qt5;
        return $this;
    }

    function setQt6($qt6) {
        $this->qt6 = $qt6;
        return $this;
    }

    function setQt7($qt7) {
        $this->qt7 = $qt7;
        return $this;
    }

    function setQt8($qt8) {
        $this->qt8 = $qt8;
        return $this;
    }

    function setQt9($qt9) {
        $this->qt9 = $qt9;
        return $this;
    }

    function setQt10($qt10) {
        $this->qt10 = $qt10;
        return $this;
    }
    
    function getObs() {
        return $this->obs;
    }

    function setObs($obs) {
        $this->obs = $obs;
        return $this;
    }
}