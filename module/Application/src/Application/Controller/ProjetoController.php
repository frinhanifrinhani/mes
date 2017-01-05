<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;




class ProjetoController extends AbstractActionController
{
    protected $projetoTable;
    
    public function listarAction() {

        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $projetos = $this->getProjetoTable()->fetchAll();
        //retorna dados pra a view
        return new ViewModel(array(
            'partial_loop_listar' => $projetos,
        ));
    }
    
    //metodo que retorna pagina de cadastro da funcionalidade Projeto
    public function cadastrarAction() {
        
        return new ViewModel(array(
           
        ));
    }
    //metodo que retorna pagina de edicao da funcionalidade Projeto
    public function editarAction() {
        
        return new ViewModel(array(
           
        ));
    }
    //metodo que retorna pagina de exclusao da funcionalidade Projeto
    public function excluirAction() {
        
        return new ViewModel(array(
           
        ));
    }
    
    //recupera e retorna a model ProjetoTable
    public function getProjetoTable() {
        if (!$this->projetoTable) {
            $sm = $this->getServiceLocator();
            $this->projetoTable = $sm->get('Application\Model\ProjetoTable');
        }
        return $this->projetoTable;
    }

    //recupera e retorna o Service Manager
    private function getSm() {
        return $this->getEvent()->getApplication()->getServiceManager();
    }
}
