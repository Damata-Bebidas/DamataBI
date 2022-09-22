<?php
/**
 * Description of orm
 *
 * @author welingtonmarquezini
 */
require_once 'crudBasic.php';
class orm implements crudBasic {
    private $db;
    //construtor
    public function __construct(\PDO $db) {
        $this->db = $db;
    }
    //queries
    public function inserir() {
        $query = "
            CREATE TABLE IF NOT EXISTS `encarreiramento` ( 
              `id` INT PRIMARY KEY AUTO_INCREMENT, 
              `matricula` INT NOT NULL,
              `data` DATE NOT NULL,
              `cargo` CHAR(1) NOT NULL,
              FOREIGN KEY(`matricula`) REFERENCES `cadastro`(`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `remuneracao` (
                `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `data` date NOT NULL,
                `setor` char(1) NOT NULL,
                `tipo` char(1) NOT NULL,
                `matricula_colaborador` int(11) NOT NULL,
                `status` char(2) NOT NULL,
                `dias_trabalhados` smallint(2) NOT NULL,
                `atributo` varchar(50) NOT NULL,
                `valor` decimal(10,2) NOT NULL,
                `gratificacao` decimal(10,2) DEFAULT NULL,
                FOREIGN KEY(`matricula_colaborador`) REFERENCES `cadastro`(`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        $stmt = $this->db->prepare($query);
        if($stmt->execute()){
            return true;
        }
    }
    
    public function alterar() {
        $query = "
                ALTER TABLE `passivo` DROP IF EXISTS `ano`;
                ALTER TABLE `apiconfig` ADD IF NOT EXISTS `data` DATETIME  NOT NULL AFTER `api`;
                ALTER TABLE `tokenSicoob` ADD IF NOT EXISTS `data` DATETIME NOT NULL AFTER `token`;
                ALTER TABLE `encarreiramento` CHANGE IF EXISTS `cargo` `cargo` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
                ALTER TABLE `mapeamento` CHANGE IF EXISTS `iniciativa` `iniciativa` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;
            ";
        $stmt = $this->db->prepare($query);       
        if($stmt->execute()){
            return true;
        }
    }

    public function deletar($id) {
        $query = "DROP TABLE IF EXISTS `tabela01`;";
        $stmt = $this->db->prepare($query);
        if($stmt->execute()){
            return true;
        }
    }

    public function consult() {
        $query = "DELETE FROM `boleto` WHERE `data` < DATE_SUB(NOW(), INTERVAL 30 DAY);";
        $stmt = $this->db->prepare($query);
        if($stmt->execute()){
            return true;
        }
    }
    
    public function find($id) {
        $query = "DELETE FROM `tokenSicoob` WHERE `data` < DATE_SUB(NOW(), INTERVAL 30 DAY);";
        $stmt = $this->db->prepare($query);
        if($stmt->execute()){
            return true;
        }
    }
}
