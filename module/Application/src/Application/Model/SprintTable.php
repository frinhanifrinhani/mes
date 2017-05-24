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
use Zend\Db\Sql\Expression;

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
        return $linha;
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
            'cod_status' => $sprint->codStatus,
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
            return $e->getPrevious()->getCode();
        }
    }

    public function excluir($codSprint) {
        return $this->tableGateway->delete(array('cod_sprint' => $codSprint));
    }

    public function retornarDadosSprint($codProjeto) {
        $expression = new Expression();
        $select = new Select();

        $select->from('sprint');

        $sprintEmAberto = new Select();
        $sprintEmAberto->from('sprint')
                ->columns(array('sprint_em_aberto' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint.cod_projeto = {$codProjeto} AND sprint.cod_status = 1");

        $sprintEmAndamento = new Select();
        $sprintEmAndamento->from('sprint')
                ->columns(array('sprint_em_andamento' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint.cod_projeto = {$codProjeto} AND sprint.cod_status = 2");

        $sprintParado = new Select();
        $sprintParado->from('sprint')
                ->columns(array('sprint_parado' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint.cod_projeto = {$codProjeto} AND sprint.cod_status = 3");

        $sprintFinalizado = new Select();
        $sprintFinalizado->from('sprint')
                ->columns(array('sprint_finalizado' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint.cod_projeto = {$codProjeto} AND sprint.cod_status = 4");

        $totalSprint = new Select();
        $totalSprint->from('sprint')
                ->columns(array('total_sprint' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint.cod_projeto = {$codProjeto}");

        $select->columns(array(
                    'sprint_em_aberto' => new \Zend\Db\Sql\Expression('?', array($sprintEmAberto)),
                    'sprint_em_andamento' => new \Zend\Db\Sql\Expression('?', array($sprintEmAndamento)),
                    'sprint_parado' => new \Zend\Db\Sql\Expression('?', array($sprintParado)),
                    'sprint_finalizado' => new \Zend\Db\Sql\Expression('?', array($sprintFinalizado)),
                    'total_sprint' => new \Zend\Db\Sql\Expression('?', array($totalSprint)),
                ))
                ->join('projeto', 'projeto.cod_projeto = sprint.cod_projeto', array())
                ->group(array(
                    'sprint_em_aberto',
                    'sprint_em_andamento',
                    'sprint_parado',
                    'sprint_finalizado',
                    'total_sprint')
        );

        $linha = $this->tableGateway->selectWith($select);
        $rowset = $linha->current();
        return $rowset;
    }

    public function countSprint() {
        $expression = new Expression();

        $select = new Select();
        $select->from('sprint');

        $totalSprint = new Select();
        $totalSprint->from('sprint')
                ->columns(array('total_sprint' => $expression->setExpression("COUNT('cod_sprint')")));

        $sprintFinalizado = new Select();
        $sprintFinalizado->from('sprint')
                ->columns(array('sprint_finalizado' => $expression->setExpression("COUNT(cod_status)")))
                ->where("cod_status = 4");

        $select->columns(array(
                    'total_sprint' => new \Zend\Db\Sql\Expression('?', array($totalSprint)),
                    'sprint_finalizado' => new \Zend\Db\Sql\Expression('?', array($sprintFinalizado)),
                ))
                ->group(array(
                    'total_sprint',
                    'sprint_finalizado')
        );

        $linha = $this->tableGateway->selectWith($select);
        $rowset = $linha->current();
        return $rowset;
    }

}
