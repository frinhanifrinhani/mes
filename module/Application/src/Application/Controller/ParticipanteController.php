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
//use Application\Model\Login;
//use Zend\Paginator\Adapter\DbSelect;
use Application\Form\ParticipanteForm;
use Zend\Mail;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;

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
                    $this->enviarEmailConfirmacao($participante->nomeParticipante, $participante->emailParticipante, $participante->senhaParticipante);
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
        $retorno = false;
        $codParticipante = (int) $this->params()->fromRoute('cod_participante', null);
        if (is_null($codParticipante)) {
            return $this->redirect()->toRoute('participante-cadastrar', array(
                        'action' => 'cadastrar'
            ));
        }
        $participante = $this->getParticipanteTable()->getParticipante($codParticipante);
        $formParticipante = new ParticipanteForm();
        $formParticipante->setData($participante->getArrayCopy());

        $request = $this->getRequest();

        if ($request->isPost()) {

            $participante = new Participante();

//            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//            $participante->setDbAdapter($dbAdapter);
//            $formParticipante->setInputFilter($participante->getInputFilter());
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

        $retorno = false;
        $codParticipante = (int) $this->params()->fromRoute('cod_participante', null);
        if (is_null($codParticipante)) {
            return $this->redirect()->toRoute('participante-cadastrar', array(
                        'action' => 'cadastrar'
            ));
        }
        $participante = $this->getParticipanteTable()->getParticipante($codParticipante);
        $formParticipante = new ParticipanteForm();
        $formParticipante->setData($participante->getArrayCopy());

        $request = $this->getRequest();

        if ($request->isPost()) {
            $retorno = $this->getParticipanteTable()->excluir($codParticipante);
            //return $this->redirect()->toRoute('participante');
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_participante' => $codParticipante,
            'form_participante' => $formParticipante,
        ));
    }

    public function gerarSenha() {
        
    }

    public function enviarEmailConfirmacao($nomeParticipante, $emailParticipante, $senhaParticipante) {
        $mailbody = "Olá $nomeParticipante!\n";
        $mailbody .= "\n";
        $mailbody .= "Bem vindo ao My Easy Scrum!\n";
        $mailbody .= "\n";
        $mailbody .= "Sua conta foi criada com sucesso, e pode ser acessada através do link mes.tf \n";
        $mailbody .= "\n";
        $mailbody .= "Usuário: $emailParticipante \n";
        $mailbody .= "Senha: $senhaParticipante\n";
        $mailbody .= "\n";
        $mailbody .= "Obs: A senha fornecida é provisória, você deve altera-la assim que acessar o sistema.";


        $mail = new Message();
        $mail->setBody($mailbody);

        //$mail->setFrom('email@gmail.com', 'Fulano');
        $mail->addTo($emailParticipante, $nomeParticipante);
        $mail->setSubject('Acesso');

        $transport = new Sendmail();
        $transport->send($mail);
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
