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
use Application\Model\Participante;
use Application\Model\Login;
//use Zend\Paginator\Adapter\DbSelect;
use Application\Form\ParticipanteForm;
use Application\Form\SenhaForm;
use Zend\Authentication\AuthenticationService;

class ParticipanteController extends AbstractActionController {

    protected $participanteTable;

    //metodo que retorna pagina incial da funcionalidade Participante
    public function listarAction() {

        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $participantes = $this->getParticipanteTable()->fetchAll();
        //retorna dados pra a view
        return new ViewModel(array(
            'partial_loop_listar' => $participantes,
        ));
    }

    public function criarContaProductOwnerAction() {
        $autenticacao = new AuthenticationService();
        if ($autenticacao->hasIdentity()) {
            return $this->redirect()->toRoute('inicio');
        }
        $this->layout('layout/layout_cadastro');
        $retorno = false;
        $ultimoParticipante = null;
        $formParticipante = new ParticipanteForm();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $participante = new Participante();

            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $participante->setDbAdapter($dbAdapter);

            $formParticipante->setInputFilter($participante->getInputFilter());
            $formParticipante->setData($request->getPost());

            if ($formParticipante->isValid()) {

                $participante->exchangeArray($formParticipante->getData());
                $retorno = $this->getParticipanteTable()->salvar($participante);

                if ($retorno == true) {
                    $identidade = $request->getPost('email_participante');
                    $credencial = $request->getPost('senha_participante');

                    $usuario = new Login($identidade, $credencial);
                    $usuario->autenticar($this->getServiceLocator());
                }
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'form_participante' => $formParticipante,
        ));
    }

    //metodo que retorna pagina de cadastro da funcionalidade Participante
    public function cadastrarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $ultimoParticipante = null;
        $formParticipante = new ParticipanteForm();

        $request = $this->getRequest();
        if ($request->isPost()) {

            $participante = new Participante();

            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $participante->setDbAdapter($dbAdapter);

            $formParticipante->setInputFilter($participante->getInputFilter());
            $formParticipante->setData($request->getPost());



            if ($formParticipante->isValid()) {

                $participante->exchangeArray($formParticipante->getData());
                $retorno = $this->getParticipanteTable()->salvar($participante);

                $ultimoParticipante = $this->getParticipanteTable()->getLastId();

                if ($retorno == true) {
                    $this->Email()->enviarEmailConfirmacao($participante->nomeParticipante, $participante->emailParticipante, $participante->senhaParticipante);
                }
            }
        }

        return new ViewModel(array(
            'ultimoParticipante' => $ultimoParticipante,
            'retorno' => $retorno,
            'form_participante' => $formParticipante,
        ));
    }

    //metodo que retorna pagina de edição dos dados da funcionalidade Participante
    public function editarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codParticipante = (int) $this->params()->fromRoute('cod_participante', null);

        $participante = $this->getParticipanteTable()->getParticipante($codParticipante);
        if ($participante == true) {
            $formParticipante = new ParticipanteForm();
            $formParticipante->setData($participante->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('participante');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $participante = new Participante();

            $formParticipante->setData($request->getPost());

            if ($formParticipante->isValid()) {

                $participante->exchangeArray($formParticipante->getData());
                $retorno = $this->getParticipanteTable()->salvar($participante);

                $ultimoParticipante = $this->getParticipanteTable()->getLastId();
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_participante' => $codParticipante,
            'form_participante' => $formParticipante,
        ));
    }

    //metodo que retorna pagina de exclusão dos dados da funcionalidade Participante
    public function excluirAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codParticipante = (int) $this->params()->fromRoute('cod_participante', null);

        $participante = $this->getParticipanteTable()->getParticipante($codParticipante);

        if ($participante == true) {
            $formParticipante = new ParticipanteForm();
            $formParticipante->setData($participante->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('participante');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $retorno = $this->getParticipanteTable()->excluir($codParticipante);
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_participante' => $codParticipante,
            'form_participante' => $formParticipante,
        ));
    }

    //metodo responsável por recuperar a senha dos usuários, 
    //redefinindo uma nava senha e enviando a mesma por e-mail
    public function recuperarSenhaAction() {
        //seta um novo layout usado para fora da área restrita
        $this->layout('layout/layout_cadastro');
        //instacia um objeto da classe ParticipanteForm, para criação dos campos na view
        $formParticipante = new ParticipanteForm();
        //getRequest() recupera os dados que vem pelo post
        $request = $this->getRequest();
        if ($request->isPost()) {
            //recupera o metodo getParticipanteEmail()da classe 
            //ParticipanteTable, que informa se existe ou não o e-mail informado
            $participante = $this->getParticipanteTable()->getParticipanteEmail($request->getPost()->email_participante);

            if ($participante == true) {
                //cria uma nova senha (única e aleatório) contendo 6 caracteres alfanuméricos, 
                //contendo letras minúsculas e/ou maiúsculas 
                $senhaParticipante = substr(md5(uniqid(rand(), true)), 0, 6);
                //retorna o metodo recuperarSenha() da classe ParticipanteTable, 
                //a o mesmo recebe por parametro o email do usuário e a nova senha gerada
                $retorno = $this->getParticipanteTable()->recuperarSenha($participante->emailParticipante, $senhaParticipante);
                if ($retorno == true) {
                    //retorna o metodo enviarEmailRecuperarSenha da ActionHelper MESEmail,
                    //responsável por enviar o e-mail com a nova senha
                    $this->Email()->enviarEmailRecuperarSenha($participante->nomeParticipante, $participante->emailParticipante, $senhaParticipante);
                    //retorna flashMessager
                    $this->flashMessenger()->addSuccessMessage('Uma nova senha foi envida para o e-mail informado!');
                }
            } else {
                //retorna flashMessager
                $this->flashMessenger()->addErrorMessage('Não existe usuário cadastrado com o e-mail informado!');
            }
        }
        //retorna os dados para a view através da um array
        return new ViewModel(array(
            //retorna o formulário
            'form_participante' => $formParticipante,
        ));
    }
    // metodo responsável por alterar a senha dos usuários
    public function alterarSenhaAction() {

        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        //recupera a sanha do usuário, a mesma se econtra no container de dados
        $senhaParticipante = $this->ACLPermitir()->container()['senha_participante'];
        //recupera o código do usuário, o mesmo se econtra no container de dados
        $codParticipante = $this->ACLPermitir()->container()['cod_participante'];
        //instacia um objeto da classe SenhaForm, para criação dos campos na view
        $formSenha = new SenhaForm();
        //getRequest() recupera os dados que vem pelo post
        $request = $this->getRequest();
        if ($request->isPost()) {
            $senhaAtual = md5($request->getPost()->senha_atual);

            if ($senhaAtual == $senhaParticipante) {
                $retorno = $this->getParticipanteTable()->alterarSenha($codParticipante, $request->getPost()->nova_senha);
                if ($retorno == true) {
                    $this->flashMessenger()->addSuccessMessage('Senha alterada com sucesso!');
                } else {
                    $this->flashMessenger()->addErrorMessage('Não foi possível alterar a senha!');
                }
            } else {
                $this->flashMessenger()->addWarningMessage('Senha atual não confere com a senha cadastrada!');
            }
        }
        return new ViewModel(array(
            'form_senha' => $formSenha,
        ));
    }

    //recupera e retorna a model PartticipanteTable
    public function getParticipanteTable() {
        if (!$this->participanteTable) {
            $sm = $this->getServiceLocator();
            $this->participanteTable = $sm->get('Application\Model\ParticipanteTable');
        }
        return $this->participanteTable;
    }

    //recupera e retorna o Service Manager
    private function getSm() {
        return $this->getEvent()->getApplication()->getServiceManager();
    }

}
