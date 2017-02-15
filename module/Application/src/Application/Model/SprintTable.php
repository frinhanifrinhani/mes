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
use Application\Model\Sprint;
use Zend\Db\Sql\TableIdentifier;

class SprintTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($codProjeto) {
        $select = new Select();
        $select->from(new TableIdentifier('sprint'))
                ->columns(array('cod_sprint', 'nome_sprint', 'descricao_sprint', 'tempo_sprint', 'cod_status', 'cod_projeto'))
                ->join('status', 'status.cod_status = sprint.cod_status', 'descricao_status')
                ->where('cod_projeto = ' . $codProjeto)
                ->order(array('cod_sprint' => 'desc'));
        $linha = $this->tableGateway->selectWith($select);
//       echo $select->getSqlString();  
        return $linha;
    }

    public function getLastId() {
        $ultimoSprint = $this->tableGateway->lastInsertValue;
        return $ultimoSprint;
    }

    public function getSprint($codSprint) {
        $codSprint = (int) $codSprint;
        $rowset = $this->tableGateway->select(array('cod_sprint' => $codSprint));
        $row = $rowset->current();

        return $row;
    }

    public function salvar(Sprint $sprint) {
        $data = array(
            'cod_sprint' => $sprint->codSprint,
            'nome_sprint' => $sprint->nomeSprint,
            'descricao_sprint' => $sprint->descricaoSprint,
            'tempo_sprint' => $sprint->tempoSprint,
            'cod_status' => $sprint->codStatusSprint,
            'cod_projeto' => $sprint->codProjeto,
        );

        try {
            $codSprint = $sprint->codSprint;
            if (!$this->getSprint($codSprint)) {
                $data['cod_sprint'] = $codSprint;
                return $this->tableGateway->insert($data);
            } else {
                return $this->tableGateway->update($data, array('cod_sprint' => $codSprint));
            }
        } catch (\Exception $e) {
            $e->getPrevious()->getMessage();
        }
    }

    public function excluir($codSprint) {
        return $this->tableGateway->delete(array('cod_sprint' => $codSprint));
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
