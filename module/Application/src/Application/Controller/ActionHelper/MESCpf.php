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


class MESCpf extends AbstractPlugin
{

    public function limparMascaraCpf($val){
        $replacePonto = str_replace('.', '', $val);
        $replaceTraco = str_replace('-', '', $replacePonto);
        $replaced = $replaceTraco;
        
        return $replaced;
        
    }
    
    
}