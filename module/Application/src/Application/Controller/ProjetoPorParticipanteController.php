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
use Application\Model\ProjetoPorParticipante;
use Application\Model\Login;

class ProjetoPorParticipanteController extends AbstractActionController {

    protected $participanteTable;
    protected $projetoPorParticipanteTable;
    protected $projetoTable;
    
//    public function escolherParticipanteAction(){
//        $participante = $this->getParticipanteTable()->fetchAll();
//        return new ViewModel(array(
//            'partial_loop_participantes' => $participante,
//        ));
//    }
    public function listarAction(){
        //        metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
//        
//        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        $codParticipante = (int) $this->params()->fromRoute('cod_participante', null);
        $projeto = $this->getProjetoPorParticipanteTable()->fetchAll($codParticipante);
//        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
//        var_dump($participante);die;
        return new ViewModel(array(
                'cod_participante' => $codParticipante,
//            'participante_por_projeto' => $participante,
            'projeto_por_participante' => $projeto,
        ));
    }

//    //metodo que retorna pagina incial da funcionalidade Participante
//    public function addProjetoAction() {
//
////        //metodo que verifica autenticação e perfil
//        $this->ACLPermitir()->permitir();
//        $projeto = $this->getProjetoTable()->fetchAll();
////        //retorna dados pra a view
//        return new ViewModel(array(
//            'partial_loop_projetos' => $projeto,
//        ));
//       
//    }
//
//    public function criarContaProductOwnerAction() {
//        $autenticacao = new AuthenticationService();
//        if ($autenticacao->hasIdentity()) {
//            return $this->redirect()->toRoute('inicio');
//        }
//        $this->layout('layout/layout_cadastro');
//        $retorno = false;
//        $ultimoParticipante = null;
//        $formParticipante = new ParticipanteForm();
//
//        $request = $this->getRequest();
//
//        if ($request->isPost()) {
//
//            $participante = new Participante();
//
//            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//            $participante->setDbAdapter($dbAdapter);
//
//            $formParticipante->setInputFilter($participante->getInputFilter());
//            $formParticipante->setData($request->getPost());
//
//            if ($formParticipante->isValid()) {
//
//                $participante->exchangeArray($formParticipante->getData());
//                $retorno = $this->getParticipanteTable()->salvar($participante);
//
//                if ($retorno == true) {
//                    $identidade = $request->getPost('email_participante');
//                    $credencial = $request->getPost('senha_participante');
//
//                    $usuario = new Login($identidade, $credencial);
//                    $usuario->autenticar($this->getServiceLocator());
//                }
//            }
//        }
//
//        return new ViewModel(array(
//            'retorno' => $retorno,
//            'form_participante' => $formParticipante,
//        ));
//    }
//
//    //metodo que retorna pagina de cadastro da funcionalidade Participante
//    public function cadastrarAction() {
//        //metodo que verifica autenticação e perfil
//        $this->ACLPermitir()->permitir();
//        $retorno = false;
//        $ultimoParticipante = null;
//        $formParticipante = new ParticipanteForm();
//
//        $request = $this->getRequest();
//        if ($request->isPost()) {
//
//            $participante = new Participante();
//
//            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//            $participante->setDbAdapter($dbAdapter);
//
//            $formParticipante->setInputFilter($participante->getInputFilter());
//            $formParticipante->setData($request->getPost());
//
//
//
//            if ($formParticipante->isValid()) {
//
//                $participante->exchangeArray($formParticipante->getData());
//                $retorno = $this->getParticipanteTable()->salvar($participante);
//
//                $ultimoParticipante = $this->getParticipanteTable()->getLastId();
//// DESCOMENTAR PARA ENVIAR EMAIL (OFFLINE PROVOCA ERRO)
////                if ($retorno == true) {
////                    $this->Email()->enviarEmailConfirmacao($participante->nomeParticipante, $participante->emailParticipante, $participante->senhaParticipante);
////                }
//            }
//        }
//
//        return new ViewModel(array(
//            'ultimoParticipante' => $ultimoParticipante,
//            'retorno' => $retorno,
//            'form_participante' => $formParticipante,
//        ));
//    }
//
//    //metodo que retorna pagina de edição dos dados da funcionalidade Participante
//    public function editarAction() {
//        //metodo que verifica autenticação e perfil
//        $this->ACLPermitir()->permitir();
//        $retorno = false;
//        $codParticipante = (int) $this->params()->fromRoute('cod_participante', null);
//
//        $participante = $this->getParticipanteTable()->getParticipante($codParticipante);
//        if ($participante == true) {
//            $formParticipante = new ParticipanteForm();
//            $formParticipante->setData($participante->getArrayCopy());
//        } else {
//            return $this->redirect()->toRoute('participante');
//        }
//
//        $request = $this->getRequest();
//
//        if ($request->isPost()) {
//
//            $participante = new Participante();
//
//            $formParticipante->setData($request->getPost());
//
//            if ($formParticipante->isValid()) {
//
//                $participante->exchangeArray($formParticipante->getData());
//                $retorno = $this->getParticipanteTable()->salvar($participante);
//
//                $ultimoParticipante = $this->getParticipanteTable()->getLastId();
//            }
//        }
//
//        return new ViewModel(array(
//            'retorno' => $retorno,
//            'cod_participante' => $codParticipante,
//            'form_participante' => $formParticipante,
//        ));
//    }
//
//    //metodo que retorna pagina de exclusão dos dados da funcionalidade Participante
//    public function excluirAction() {
//        //metodo que verifica autenticação e perfil
//        $this->ACLPermitir()->permitir();
//        $retorno = false;
//        $codParticipante = (int) $this->params()->fromRoute('cod_participante', null);
//        $solicitante = $this->ACLPermitir()->container()['cod_participante'];
//        $participante = $this->getParticipanteTable()->getParticipante($codParticipante);
//
//        if ($participante == true) {
//            $formParticipante = new ParticipanteForm();
//            $formParticipante->setData($participante->getArrayCopy());
//        } else {
//            return $this->redirect()->toRoute('participante');
//        }
//
//        $request = $this->getRequest();
//
//        if ($request->isPost()) {
//            $retornoCod = $this->getParticipanteTable()->excluir($codParticipante);
//            if($retornoCod == 23000){
//                $retorno = false;
//            }else{
//                $retorno = true;
//            }
//        }
//
//        return new ViewModel(array(
//            'retorno' => $retorno,
//            'solicitante' => $solicitante,
//            'cod_participante' => $codParticipante,
//            'form_participante' => $formParticipante,
//        ));
//    }
//
//    //metodo responsável por recuperar a senha dos usuários, 
//    //redefinindo uma nava senha e enviando a mesma por e-mail
//    public function recuperarSenhaAction() {
//        //seta um novo layout usado para fora da área restrita
//        $this->layout('layout/layout_cadastro');
//        //instacia um objeto da classe ParticipanteForm, para criação dos campos na view
//        $formParticipante = new ParticipanteForm();
//        //getRequest() recupera os dados que vem pelo post
//        $request = $this->getRequest();
//        if ($request->isPost()) {
//            //recupera o metodo getParticipanteEmail()da classe 
//            //ParticipanteTable, que informa se existe ou não o e-mail informado
//            $participante = $this->getParticipanteTable()->getParticipanteEmail($request->getPost()->email_participante);
//
//            if ($participante == true) {
//                //cria uma nova senha (única e aleatório) contendo 6 caracteres alfanuméricos, 
//                //contendo letras minúsculas e/ou maiúsculas 
//                $senhaParticipante = substr(md5(uniqid(rand(), true)), 0, 6);
//                //retorna o metodo recuperarSenha() da classe ParticipanteTable, 
//                //a o mesmo recebe por parametro o email do usuário e a nova senha gerada
//                $retorno = $this->getParticipanteTable()->recuperarSenha($participante->emailParticipante, $senhaParticipante);
//                if ($retorno == true) {
//                    //retorna o metodo enviarEmailRecuperarSenha da ActionHelper MESEmail,
//                    //responsável por enviar o e-mail com a nova senha
//                    
//                    // DESCOMENTAR PARA ENVIAR EMAIL (OFFLINE PROVOCA ERRO)
//                    $this->Email()->enviarEmailRecuperarSenha($participante->nomeParticipante, $participante->emailParticipante, $senhaParticipante);
//                    //retorna flashMessager
//                    $this->flashMessenger()->addSuccessMessage('Uma nova senha foi envida para o e-mail informado!');
//                }
//            } else {
//                //retorna flashMessager
//                $this->flashMessenger()->addErrorMessage('Não existe usuário cadastrado com o e-mail informado!');
//            }
//        }
//        //retorna os dados para a view através da um array
//        return new ViewModel(array(
//            //retorna o formulário
//            'form_participante' => $formParticipante,
//        ));
//    }
//    // metodo responsável por alterar a senha dos usuários
//    public function alterarSenhaAction() {
//
//        //metodo que verifica autenticação e perfil
//        $this->ACLPermitir()->permitir();
//        //recupera a sanha do usuário, a mesma se econtra no container de dados
//        $senhaParticipante = $this->ACLPermitir()->container()['senha_participante'];
//        //recupera o código do usuário, o mesmo se econtra no container de dados
//        $codParticipante = $this->ACLPermitir()->container()['cod_participante'];
//        //instacia um objeto da classe SenhaForm, para criação dos campos na view
//        $formSenha = new SenhaForm();
//        //getRequest() recupera os dados que vem pelo post
//        $request = $this->getRequest();
//        if ($request->isPost()) {
//            $senhaAtual = md5($request->getPost()->senha_atual);
//
//            if ($senhaAtual == $senhaParticipante) {
//                $retorno = $this->getParticipanteTable()->alterarSenha($codParticipante, $request->getPost()->nova_senha);
//                if ($retorno == true) {
//                    $this->flashMessenger()->addSuccessMessage('Senha alterada com sucesso!');
//                } else {
//                    $this->flashMessenger()->addErrorMessage('Não foi possível alterar a senha!');
//                }
//            } else {
//                $this->flashMessenger()->addWarningMessage('Senha atual não confere com a senha cadastrada!');
//            }
//        }
//        return new ViewModel(array(
//            'form_senha' => $formSenha,
//        ));
//    }
//
    //recupera e retorna a model ParticipanteProjetoTable
    public function getProjetoPorParticipanteTable() {
        if (!$this->projetoPorParticipanteTable) {
            $sm = $this->getServiceLocator();
            $this->projetoPorParticipanteTable = $sm->get('Application\Model\ProjetoPorParticipanteTable');
        }
        return $this->projetoPorParticipanteTable;
    }
    //recupera e retorna a model ParticipanteTable
//    public function getParticipanteTable() {
//        if (!$this->participanteTable) {
//            $sm = $this->getServiceLocator();
//            $this->participanteTable = $sm->get('Application\Model\ParticipanteTable');
//        }
//        return $this->participanteTable;
//    }
//    //recupera e retorna a model projetoTable
    public function getProjetoTable() {
        if (!$this->projetoTable) {
            $sm = $this->getServiceLocator();
            $this->projetoTable = $sm->get('Application\Model\ProjetoTable');
        }
        return $this->projetoTable;
    }
//
    //recupera e retorna o Service Manager
    private function getSm() {
        return $this->getEvent()->getApplication()->getServiceManager();
    }

}
