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


    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'nome_participante',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim')
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo nome não pode ser vazio!'
                                    ),
                                ),
                            ),
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'min' => 3,
                                    'max' => 255,
                                    'messages' => array(
                                        \Zend\Validator\StringLength::TOO_SHORT => 'O campo nome deve ter no mínimo 3 caracteres!',
                                        \Zend\Validator\StringLength::TOO_LONG => 'O campo nome deve ter no máximo 255 caracteres!',
                                    )
                                ),
                            ),
                        )
            )));
           $this->inputFilter = $inputFilter; 
        }
        return $this->inputFilter;
    }
    
    public function toArray(){
        return get_object_vars($this);
    }
    
}