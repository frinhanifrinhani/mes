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
use Application\Model\Projeto;
//use Application\Model\Login;
//use Zend\Paginator\Adapter\DbSelect;
use Application\Form\ProjetoForm;

class ProjetoController extends AbstractActionController {

    protected $projetoTable;

    public function listarAction() {

        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $projetos = $this->getProjetoTable()->fetchAll($this->ACLPermitir()->container()['cod_participante']);
        //retorna dados pra a view
        return new ViewModel(array(
            'partial_loop_listar' => $projetos,
        ));
    }

    //metodo que retorna pagina de cadastro da funcionalidade Projeto
    public function cadastrarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $ultimoProjeto = null;
        $formProjeto = new ProjetoForm();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $projeto = new Projeto();

            $formProjeto->setInputFilter($projeto->getInputFilter());
            $formProjeto->setData($request->getPost());

            if ($formProjeto->isValid()) {

                $projeto->exchangeArray($formProjeto->getData());
                $retorno = $this->getProjetoTable()->salvar($projeto);

                $ultimoProjeto = $this->getProjetoTable()->getLastId();
            }
        }

        return new ViewModel(array(
            'cod_participante' => $this->ACLPermitir()->container()['cod_participante'],
            'ultimoProjeto' => $ultimoProjeto,
            'retorno' => $retorno,
            'form_projeto' => $formProjeto,
        ));
    }

    //metodo que retorna pagina de edicao da funcionalidade Projeto
    public function editarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();

        $retorno = false;
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
//        if (is_null($codProjeto)) {
//            return $this->redirect()->toRoute('projeto-cadastrar', array(
//                        'action' => 'cadastrar'
//            ));
//        }
        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        if ($projeto == true) {
            $formProjeto = new ProjetoForm();
            $formProjeto->setData($projeto->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('projeto');
        };

        $request = $this->getRequest();

        if ($request->isPost()) {

            $projeto = new projeto();

//            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//            $projeto->setDbAdapter($dbAdapter);
//            $formprojeto->setInputFilter($projeto->getInputFilter());
            $formProjeto->setData($request->getPost());

            if ($formProjeto->isValid()) {

                $projeto->exchangeArray($formProjeto->getData());
                $retorno = $this->getprojetoTable()->salvar($projeto);

                $ultimoProjeto = $this->getprojetoTable()->getLastId();
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_projeto' => $codProjeto,
            'form_projeto' => $formProjeto,
        ));
    }

    //metodo que retorna pagina de exclusao da funcionalidade Projeto
    public function excluirAction() {
        $retorno = false;
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
//        if (is_null($codProjeto)) {
//            return $this->redirect()->toRoute('projeto-cadastrar', array(
//                        'action' => 'cadastrar'
//            ));
//        }
        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        if ($projeto == true) {
            $formProjeto = new ProjetoForm();
            $formProjeto->setData($projeto->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('projeto');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $retorno = $this->getProjetoTable()->excluir($codProjeto);
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_projeto' => $codProjeto,
            'form_projeto' => $formProjeto,
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
