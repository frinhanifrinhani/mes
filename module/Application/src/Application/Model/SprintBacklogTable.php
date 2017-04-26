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
use Application\Model\SprintBacklog;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Expression;

class SprintBacklogTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($codProjeto) {
        $select = new Select();
        $select->from(new TableIdentifier('sprint_backlog'))
                ->columns(array('cod_sprint_backlog', 'nome_sprint_backlog', 'descricao_sprint_backlog', 'tempo_sprint_backlog', 'cod_status', 'cod_participante', 'cod_projeto'))
                ->join('status', 'status.cod_status = sprint_backlog.cod_status', 'descricao_status')
                ->join('participante', 'participante.cod_participante = sprint_backlog.cod_participante', 'nome_participante')
                ->where('cod_projeto = ' . $codProjeto)
                ->order(array('sprint_backlog.cod_sprint_backlog' => 'DESC'));
        $linha = $this->tableGateway->selectWith($select);
//       echo $select->getSqlString();
        return $linha;
    }

    //metodo que retorna ultma sprint cadastrada
//    public function getLastId() {
//        $ultimoSprint = $this->tableGateway->lastInsertValue;
//        return $ultimoSprint;
//    }

    public function getSprintBacklog($codSprintBacklog) {
        $codSprintBacklog = (int) $codSprintBacklog;
        $rowset = $this->tableGateway->select(array('cod_sprint_backlog' => $codSprintBacklog));
        $row = $rowset->current();

        return $row;
    }

    public function salvar(SprintBacklog $sprintBacklog) {
        $data = array(
            'cod_sprint_backlog' => $sprintBacklog->codSprintBacklog,
            'nome_sprint_backlog' => $sprintBacklog->nomeSprintBacklog,
            'descricao_sprint_backlog' => $sprintBacklog->descricaoSprintBacklog,
            'tempo_sprint_backlog' => $sprintBacklog->tempoSprintBacklog,
            'cod_status' => $sprintBacklog->codStatus,
            'cod_projeto' => $sprintBacklog->codProjeto,
            'cod_participante' => $sprintBacklog->codParticipante,
            'cod_product_backlog' => $sprintBacklog->codProductBacklog,
        );

        try {
            $codSprintBacklog = $sprintBacklog->codSprintBacklog;
            if (!$this->getSprintBacklog($codSprintBacklog)) {
                $data['cod_sprint_backlog'] = $codSprintBacklog;
                return $this->tableGateway->insert($data);
            } else {
                return $this->tableGateway->update($data, array('cod_sprint_backlog' => $codSprintBacklog));
            }
        } catch (\Exception $e) {
            return $e->getPrevious()->getCode();
        }
    }

    public function excluir($codSprintBacklog) {
        return $this->tableGateway->delete(array('cod_sprint_backlog' => $codSprintBacklog));
    }

    public function retornarDadosSprintBacklog($codProjeto) {
        $expression = new Expression();
        $select = new Select();

        $select->from('sprint_backlog');

        $sprintBacklogEmAberto = new Select();
        $sprintBacklogEmAberto->from('sprint_backlog')
                ->columns(array('sprint_backlog_em_aberto' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint_backlog.cod_projeto = {$codProjeto} AND sprint_backlog.cod_status = 1");

        $sprintBacklogEmAndamento = new Select();
        $sprintBacklogEmAndamento->from('sprint_backlog')
                ->columns(array('sprint_backlog_em_andamento' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint_backlog.cod_projeto = {$codProjeto} AND sprint_backlog.cod_status = 2");

        $sprintBacklogParado = new Select();
        $sprintBacklogParado->from('sprint_backlog')
                ->columns(array('sprint_backlog_parado' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint_backlog.cod_projeto = {$codProjeto} AND sprint_backlog.cod_status = 3");

        $sprintBacklogFinalizado = new Select();
        $sprintBacklogFinalizado->from('sprint_backlog')
                ->columns(array('sprint_backlog_finalizado' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint_backlog.cod_projeto = {$codProjeto} AND sprint_backlog.cod_status = 4");

        $totalSprintBacklog = new Select();
        $totalSprintBacklog->from('sprint_backlog')
                ->columns(array('total_sprint_backlog' => $expression->setExpression("COUNT('cod_status')")))
                ->where("sprint_backlog.cod_projeto = {$codProjeto}");

        $select->columns(array(
                    'sprint_backlog_em_aberto' => new \Zend\Db\Sql\Expression('?', array($sprintBacklogEmAberto)),
                    'sprint_backlog_em_andamento' => new \Zend\Db\Sql\Expression('?', array($sprintBacklogEmAndamento)),
                    'sprint_backlog_parado' => new \Zend\Db\Sql\Expression('?', array($sprintBacklogParado)),
                    'sprint_backlog_finalizado' => new \Zend\Db\Sql\Expression('?', array($sprintBacklogFinalizado)),
                    'total_sprint_backlog' => new \Zend\Db\Sql\Expression('?', array($totalSprintBacklog)),
                ))
                ->join('projeto', 'projeto.cod_projeto = sprint_backlog.cod_projeto', array())
                ->group(array(
                    'sprint_backlog_em_aberto',
                    'sprint_backlog_em_andamento',
                    'sprint_backlog_parado',
                    'sprint_backlog_finalizado',
                    'total_sprint_backlog')
        );

        $linha = $this->tableGateway->selectWith($select);
//        echo $select->getSqlString();
        $rowset = $linha->current();
        return $rowset;
    }

//    //metodo que retorna sql da tableGateway
//    public function getSql() {
//        return $this->tableGateway->getSql();
//    }
//
//    //metodo que retorna select da tableGateway
//    public function getSelect() {
//        $select = new Select($this->tableGateway->getTable());
//        return $select;
//    }
}
