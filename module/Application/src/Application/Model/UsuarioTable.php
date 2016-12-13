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
use Application\Model\Usuario;
use Zend\Db\Sql\TableIdentifier;

class UsuarioTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) 
    {
        $this->tableGateway = $tableGateway;
    }

        public function selecionarTodosFuncionarios(){
        $select  = new Select();
        $select->from(new TableIdentifier('usuario') )
               ->columns(array('cod_funcionario','usuario','senha','status_usuario','cod_participante','data_cadastro_usuario'));
        $linha = $this->tableGateway->selectWith($select);

        return $linha;
    }
    
    
}
