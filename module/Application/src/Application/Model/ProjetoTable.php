<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Application\Model\ProjetoTable;
use Zend\Db\Sql\TableIdentifier;
use Zend\I18n\View\Helper\DateFormat;

class ProjetoTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $select = new Select();
        $select->from(new TableIdentifier('projeto'))
                ->columns(array('cod_projeto', 'nome_projeto', 'descricao_projeto', 'data_inicio_projeto', 'data_fim_projeto', 'cod_status', 'data_cadastro_projeto'))
                ->join('status', 'status.cod_status = projeto.cod_status', 'descricao_status')
                ->join('participante', 'participante.cod_participante = projeto.cod_participante', 'nome_participante')
//                ->where('projeto.cod_participante = ' . $productOwner)
                ->order(array('nome_projeto'));
        $linha = $this->tableGateway->selectWith($select);
//       echo $select->getSqlString();  
        return $linha;
    }

    public function getLastId() {
        $ultimoProjeto = $this->tableGateway->lastInsertValue;
        return $ultimoProjeto;
    }

    public function getProjeto($codProjeto) {
        $codProjeto = (int) $codProjeto;
        $rowset = $this->tableGateway->select(array('cod_projeto' => $codProjeto));
        $row = $rowset->current();

        return $row;
    }
    
    public function getProjetoJoin($codProjeto){
        
        $select = new Select();
        $select->from(new TableIdentifier('projeto'))
                ->columns(array('cod_projeto', 'nome_projeto', 'descricao_projeto', 'data_inicio_projeto', 'data_fim_projeto', 'cod_status', 'data_cadastro_projeto'))
                ->join('status', 'status.cod_status = projeto.cod_status', 'descricao_status')
                ->join('participante', 'participante.cod_participante = projeto.cod_participante', 'nome_participante')
                ->order(array('cod_projeto' => 'desc'));
        $rowset = $this->tableGateway->selectWith($select);
//       echo $select->getSqlString();  
        $linha = $rowset->current();
        return $linha;
    
    }

    public function salvar(Projeto $projeto) {
        $data = array(
            'cod_projeto' => $projeto->codProjeto,
            'nome_projeto' => $projeto->nomeProjeto,
            'descricao_projeto' => $projeto->descricaoProjeto,
            'data_inicio_projeto' => implode('-', array_reverse(explode('/', $projeto->dataInicioProjeto))),
            'data_fim_projeto' => implode('-', array_reverse(explode('/', $projeto->dataFimProjeto))),
            'cod_participante' => $projeto->codParticipante,
            'cod_status' => $projeto->codStatus,
        );

        try {
            $codProjeto = $projeto->codProjeto;
            var_dump($this->getProjeto($codProjeto));
            if (!$this->getProjeto($codProjeto)) {
                echo 'aqui';
                $data['cod_projeto'] = $codProjeto;
                return $this->tableGateway->insert($data);
            } else {
                return $this->tableGateway->update($data, array('cod_projeto' => $codProjeto));
            }
        } catch (\Exception $e) {
            return $e->getPrevious()->getCode();
        }
    }

    public function excluir($codProjeto) {
        $this->tableGateway->delete(array('cod_projeto' => $codProjeto));
    }

    //metodo que retorna sql da tableGateway
    public function getSql() {
        return $this->tableGateway->getSql();
    }

    //metodo que retorna select da tableGateway
    public function getSelect() {
        $select = new Select($this->tableGateway->getTable());
        return $select;
    }

}
