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
//       echo $select->getSqlString();  
        return $linha;
    }
    
    public function salvar(Participante $participante){
        
        $data = array(
            'cod_participante' => $participante->codParticipante,
            'nome_participante' => $participante->nomeParticipante,
            'cpf_participante' => $participante->cpfParticipante,
	    'telefone_participante' => $participante->telefoneParticipante,
	    'email_participante' => $participante->emailParticipante,
            'cod_tipo_participante' => $participante->codTipoParticipante,
        );
//        var_dump($data);
        var_dump($this->tableGateway->insert($data));
//        $this->tableGateway->insert($data);
//        $codigo = $setor->codigo;
//        if(!$this->getSetor($codigo)){
//            $data['codigo'] = $codigo;
//            $this->tableGateway->insert($data);
//        }else{
//            $this->tableGateway->update($data, array('codigo' => $codigo));
//        }
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
