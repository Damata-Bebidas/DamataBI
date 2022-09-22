<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author welingtonmarquezini
 */
interface crudBasic {
    //put your code here
    public function inserir();
    public function alterar();
    public function deletar($id);
    public function find($id);//consultar
    public function consult();//todos os registros da tabela do banco de dados
}
