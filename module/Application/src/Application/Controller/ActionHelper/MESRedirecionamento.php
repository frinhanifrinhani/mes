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
use Zend\View\Model\ViewModel;
use Application\Model\Sprint;

class MESRedirecionamento extends AbstractPlugin {


    public function redirecionarParaProjeto($projeto) {
        if ($projeto == false) {
            $controller = $this->getController();
            $redirector = $controller->getPluginManager()->get('Redirect');
            return $redirector->toRoute('projeto');
        }
    }

}
