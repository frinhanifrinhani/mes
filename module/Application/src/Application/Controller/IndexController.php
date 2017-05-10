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
use Zend\Authentication\AuthenticationService;
use Application\Model\Login;
use Zend\Session\Container;
//use Application\Controller\ProjetoController;
use Application\Model\Projeto;

class IndexController extends AbstractActionController {

    protected $projetoTable;

    public function indexAction() {
        $autenticacao = new AuthenticationService;
        if ($autenticacao->hasIdentity()) {
            return $this->redirect()->toRoute('inicio');
        } else {
            return $this->redirect()->toRoute('login');
        }
    }
    public function acessoNegadoAction() {
        return new ViewModel();
    }

    public function inicioAction() {

        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $projetos = $this->getProjetoTable()->fetchAll($this->ACLPermitir()->container()['cod_participante']);
//        $codProjeto = $this->getProjetoTable()->getProjeto();
        return new ViewModel(array(
            'partial_loop_projetos' => $projetos,
            'nome_participante' => $this->ACLPermitir()->container()['nome_participante'],
            
        ));
    }
    public function projetoEscolhidoAction() {

        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $projetos = $this->getProjetoTable()->fetchAll($this->ACLPermitir()->container()['cod_participante']);
        return new ViewModel(array(
            'partial_loop_projetos' => $projetos,
            'nome_participante' => $this->ACLPermitir()->container()['nome_participante'],
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
