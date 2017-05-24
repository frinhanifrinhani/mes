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

class TipoParticipante 
{

    public $codTipoParticipante;
    public $tipoParticipante;
    protected $inputFilter;
    
    function exchangeArray($data)
    {
        $this->codTipoParticipante = (isset($data['cod_tipo_participante'])) ? $data['cod_tipo_participante'] : null;
        $this->tipoParticipante = (isset($data['tipo_participante'])) ? $data['tipo_participante'] : null;
 
    }
    
    public function getArrayCopy()
    {
        return array(
            
            'cod_tipo_participante' => $this->codTipoParticipante,
            'tipo_participante' => $this->tipoParticipante,
            
        );
    }

    public function toArray(){
        return get_object_vars($this);
    }
    
}
