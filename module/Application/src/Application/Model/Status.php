<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\I18n\Filter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;



class Status 
{
    public $codStatus;
    public $descricaoStatus;
    protected $inputFilter;
    
    function exchangeArray($data)
    {
        $this->codStatus = (isset($data['cod_status'])) ? $data['cod_status'] : null;
        $this->descricaoStatus = (isset($data['descricao_status'])) ? $data['descricao_status'] : null;

    }
    
    public function getArrayCopy()
    {
        return array(
            'cod_status' => $this->codStatus,
            'descricao_status' => $this->descricaoStatus,
        );
    }
    
    public function toArray(){
        return get_object_vars($this);
    }
    
}
