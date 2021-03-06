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
use Application\Model\Participante;
use Zend\Db\Sql\TableIdentifier;

use Zend\Db\Adapter\Exception\InvalidQueryException;

class ParticipanteTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $select = new Select();
        $select->from(new TableIdentifier('participante'))
                ->columns(array('cod_participante', 'nome_participante', 'cpf_participante', 'telefone_participante', 'email_participante', 'cod_tipo_participante', 'data_cadastro_participante'))
                ->join('tipo_participante', 'tipo_participante.cod_tipo_participante = participante.cod_tipo_participante', 'tipo_participante')
                ->order(array('cod_participante'=>'desc'));
        $linha = $this->tableGateway->selectWith($select);
        return $linha;
    }
    
    public function fetchAllScrumTeam() {
        $select = new Select();
        $select->from(new TableIdentifier('participante'))
                ->columns(array('cod_participante', 'nome_participante', 'cpf_participante', 'telefone_participante', 'email_participante', 'cod_tipo_participante', 'data_cadastro_participante'))
                ->join('tipo_participante', 'tipo_participante.cod_tipo_participante = participante.cod_tipo_participante', 'tipo_participante')
                ->where(array('participante.cod_tipo_participante = 3'))
                ->order(array('participante.cod_participante'=>'desc'));
        $linha = $this->tableGateway->selectWith($select);
        return $linha;
    }
    
    public function fetchAllProductOwner() {
        $select = new Select();
        $select->from(new TableIdentifier('participante'))
                ->columns(array('cod_participante', 'nome_participante', 'cpf_participante', 'telefone_participante', 'email_participante', 'cod_tipo_participante', 'data_cadastro_participante'))
                ->join('tipo_participante', 'tipo_participante.cod_tipo_participante = participante.cod_tipo_participante', 'tipo_participante')
                ->where('participante.cod_tipo_participante = 1')
                ->order(array('nome_participante'));
        $linha = $this->tableGateway->selectWith($select);
        return $linha;
    }

    public function getParticipante($codParticipante)
     {
         $codParticipante = (int) $codParticipante;
         $rowset = $this->tableGateway->select(array ('cod_participante' => $codParticipante));
         $row = $rowset->current();
         
         return  $row;
     }
     
     public function getParticipanteEmail($emailParticipante)
     {
         $rowset = $this->tableGateway->select(array ('email_participante' => $emailParticipante));
         $row = $rowset->current();
         
         return  $row;
     }
    
    public function salvar(Participante $participante){
        $data = array(
            'cod_participante' => $participante->codParticipante,
            'nome_participante' => $participante->nomeParticipante,
            'cpf_participante' => $participante->cpfParticipante,
	    'telefone_participante' => $participante->telefoneParticipante,
	    'email_participante' => $participante->emailParticipante,
            'senha_participante' => md5($participante->senhaParticipante),
            'cod_tipo_participante' => $participante->codTipoParticipante,
        );

        try{
        $codParticipante = $participante->codParticipante;
            if(!$this->getParticipante($codParticipante)){
                $data['cod_participante'] = $codParticipante;
                return $this->tableGateway->insert($data);
            } else {
                return $this->tableGateway->update($data, array('cod_participante' => $codParticipante));
            }
        }  catch (\Exception $e){
            return $e->getPrevious()->getCode();
        }
    }
        
    
    public function excluir($codParticipante){
        try {
           return $this->tableGateway->delete(array('cod_participante' => $codParticipante));    
        } catch (\Exception $e) {
           return $e->getPrevious()->getCode();
           
        }
        
    }
    
    public function alterarSenha($codParticipante,$senhaParticipante){
        $senhaParticipante = array('senha_participante' => md5($senhaParticipante));
        return $this->tableGateway->update($senhaParticipante, array('cod_participante' => $codParticipante));
    }
    
    public function recuperarSenha($emailParticipante,$senhaParticipante){
        $senhaParticipante = array('senha_participante' => md5($senhaParticipante));
        return $this->tableGateway->update($senhaParticipante, array('email_participante' => $emailParticipante));
    }

}
