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
use Application\Model\ProjetoPorParticipante;
use Zend\Db\Sql\TableIdentifier;

class ProjetoPorParticipanteTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($codParticipante) {
        $select = new Select();
        $select->from(new TableIdentifier('participante_para_projeto'))
                ->columns(array('cod_projeto', 'cod_participante'))
                    ->join('projeto', 'projeto.cod_projeto = participante_para_projeto.cod_projeto','nome_projeto','right');
                 //->where("projeto.cod_participante = {$codParticipante}");
                 //->where("projeto.cod_projeto = 3 ");
                //->order(array('nome_projeto'));
                
//SELECT
//pp.cod_projeto,
//pp.cod_participante,
//pj.nome_projeto
//FROM participante_para_projeto pp
//RIGHT JOIN projeto pj ON pj.cod_projeto = pp.cod_projeto
        
        $linha = $this->tableGateway->selectWith($select);
       echo $select->getSqlString();
        return $linha;
    }
//    public function fetchAllProductOwner() {
//        $select = new Select();
//        $select->from(new TableIdentifier('participante'))
//                ->columns(array('cod_participante', 'nome_participante', 'cpf_participante', 'telefone_participante', 'email_participante', 'cod_tipo_participante', 'data_cadastro_participante'))
//                ->join('tipo_participante', 'tipo_participante.cod_tipo_participante = participante.cod_tipo_participante', 'tipo_participante')
//                ->where('participante.cod_tipo_participante = 1')
//                ->order(array('nome_participante'));
//        $linha = $this->tableGateway->selectWith($select);
////       echo $select->getSqlString();  
//        return $linha;
//    }
//    public function getLastId(){
//      $ultimoParticipante = $this->tableGateway->lastInsertValue;
//      return $ultimoParticipante;
// 
//    }
//
//    public function getParticipante($codParticipante)
//     {
//         $codParticipante = (int) $codParticipante;
//         $rowset = $this->tableGateway->select(array ('cod_participante' => $codParticipante));
//         $row = $rowset->current();
//         
//         return  $row;
//     }
//     
//     public function getParticipanteEmail($emailParticipante)
//     {
//         $rowset = $this->tableGateway->select(array ('email_participante' => $emailParticipante));
//         $row = $rowset->current();
//         
//         return  $row;
//     }
//    
//    public function salvar(Participante $participante){
//        $data = array(
//            'cod_participante' => $participante->codParticipante,
//            'nome_participante' => $participante->nomeParticipante,
//            'cpf_participante' => $participante->cpfParticipante,
//	    'telefone_participante' => $participante->telefoneParticipante,
//	    'email_participante' => $participante->emailParticipante,
//            'senha_participante' => md5($participante->senhaParticipante),
//            'cod_tipo_participante' => $participante->codTipoParticipante,
//        );
//
//        try{
//        $codParticipante = $participante->codParticipante;
//            if(!$this->getParticipante($codParticipante)){
//                $data['cod_participante'] = $codParticipante;
//                return $this->tableGateway->insert($data);
//            } else {
//                return $this->tableGateway->update($data, array('cod_participante' => $codParticipante));
//            }
//        }  catch (\Exception $e){
//             $e->getPrevious()->getMessage();
//        }
//    }
//        
//    
//    public function excluir($codParticipante){
//        try {
//           return $this->tableGateway->delete(array('cod_participante' => $codParticipante));    
//        } catch (\Exception $e) {
//           return $e->getPrevious()->getCode();
//           
//        }
//        
//    }
//    
//    public function alterarSenha($codParticipante,$senhaParticipante){
//        $senhaParticipante = array('senha_participante' => md5($senhaParticipante));
//        return $this->tableGateway->update($senhaParticipante, array('cod_participante' => $codParticipante));
//    }
//    
//    public function recuperarSenha($emailParticipante,$senhaParticipante){
//        $senhaParticipante = array('senha_participante' => md5($senhaParticipante));
//        return $this->tableGateway->update($senhaParticipante, array('email_participante' => $emailParticipante));
//    }

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