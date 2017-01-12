<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\ActionHelper;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mail;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;

class MESEmail extends AbstractPlugin
{

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
}