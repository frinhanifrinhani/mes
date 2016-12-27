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

    public function fetchAllParticipantes() {
        $select = new Select();
        $select->from(new TableIdentifier('participante'))
                ->columns(array('cod_participante', 'nome_participante', 'cpf_participante', 'telefone_participante', 'email_participante', 'cod_tipo_participante', 'data_cadastro_participante'))
                ->join('tipo_participante', 'tipo_participante.cod_tipo_participante = participante.cod_tipo_participante', 'tipo_participante');
        $linha = $this->tableGateway->selectWith($select);
//       echo $select->getSqlString();  
        return $linha;
    }
    
    public function salvar(){
        
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
