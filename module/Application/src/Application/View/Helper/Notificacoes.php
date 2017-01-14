<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Notificacoes extends AbstractHelper
{
    public function __invoke()
    {
        echo $this->view->flashMessenger()->renderCurrent('error', array('alert', 'alert-danger'));
        echo $this->view->flashMessenger()->renderCurrent('warning', array('alert', 'alert-warning'));
        echo $this->view->flashMessenger()->renderCurrent('success', array('alert', 'alert-success'));
        echo $this->view->flashMessenger()->renderCurrent('default', array('alert', 'alert-info'));
        $this->view->flashMessenger()->getPluginFlashMessenger()->clearCurrentMessagesFromNamespace('default');
        $this->view->flashMessenger()->getPluginFlashMessenger()->clearCurrentMessagesFromNamespace('success');
        $this->view->flashMessenger()->getPluginFlashMessenger()->clearCurrentMessagesFromNamespace('warning');
        $this->view->flashMessenger()->getPluginFlashMessenger()->clearCurrentMessagesFromNamespace('error');
    }
}