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



class Participante implements InputFilterAwareInterface 
{

    public $codParticipante;
    public $nomeParticipante;
    public $cpfParticipante;
    public $telefoneParticipante;
    public $emailParticipante;
    public $codTipoParticipante;
    public $tipoParticipante;
    public $senhaParticipante;
    public $dataCadastroParticipante; 
    protected $inputFilter;
    
    function exchangeArray($data)
    {
        $this->codParticipante = (isset($data['cod_participante'])) ? $data['cod_participante'] : null;
        $this->nomeParticipante = (isset($data['nome_participante'])) ? $data['nome_participante'] : null;
        $this->cpfParticipante = (isset($data['cpf_participante'])) ? $data['cpf_participante'] : null;
        $this->telefoneParticipante = (isset($data['telefone_participante'])) ? $data['telefone_participante'] : null;
        $this->emailParticipante = (isset($data['email_participante'])) ? $data['email_participante'] : null;
        $this->codTipoParticipante = (isset($data['cod_tipo_participante'])) ? $data['cod_tipo_participante'] : null;
        $this->tipoParticipante = (isset($data['tipo_participante'])) ? $data['tipo_participante'] : null;
        $this->senhaParticipante = (isset($data['senha_participante'])) ? $data['senha_participante'] : null;
        $this->dataCadastroParticipante = (isset($data['data_cadastro_participante'])) ? $data['data_cadastro_participante'] : null;
        
    }
    
    public function getArrayCopy()
    {
        return array(
            
            'cod_participante' => $this->codParticipante,
            'nome_participante' => $this->nomeParticipante,
            'cpf_participante' => $this->cpfParticipante,
            'telefone_participante' => $this->telefoneParticipante,
            'email_participante' => $this-> emailParticipante,
            'cod_tipo_participante'  => $this->codTipoParticipante,
            'tipo_participante'  => $this->tipoParticipante,
            'senha_participante'  => $this->senhaParticipante,
            'data_cadastro_participante' => $this->dataCadastroParticipante,
        );
    }


    
    public function toArray(){
        return get_object_vars($this);
    }
        
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Sem uso");
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
    
    
//    public function getInputFilter()
//    {
//        if (!$this->inputFilter) {
//            $inputFilter = new InputFilter();
//            $factory     = new InputFactory();
// 
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'id',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'Int'),
//                ),
//            )));
// 
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'name',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'StripTags'),
//                    array('name' => 'StringTrim'),
//                ),
//                'validators' => array(
//                    array(
//                        'name'    => 'StringLength',
//                        'options' => array(
//                            'encoding' => 'UTF-8',
//                            'min'      => 5,
//                            'max'      => 255,
//                        ),
//                    ),
//                ),
//            )));
//             
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'gender',
//                'validators' => array(
//                    array(
//                        'name'    => 'InArray',
//                        'options' => array(
//                            'haystack' => array(2,3),
//                            'messages' => array(
//                                'notInArray' => 'Please select your gender !' 
//                            ),
//                        ),
//                    ),
//                ),
//            )));
//             
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'hobby',
//                'required' => true 
//            )));
//             
//             
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'email',
//                'validators' => array(
//                    array(
//                        'name'    => 'EmailAddress'
//                    ),
//                ),
//            )));
//             
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'birth',
//                'validators' => array(
//                    array(
//                        'name'    => 'Between',
//                        'options' => array(
//                            'min' => '1970-01-01',
//                            'max' => date('Y-m-d')
//                        ),
//                    ),
//                ),
//            ))); 
//             
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'address',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'StripTags'),
//                    array('name' => 'StringTrim'),
//                ),
//                'validators' => array(
//                    array(
//                        'name'    => 'StringLength',
//                        'options' => array(
//                            'encoding' => 'UTF-8',
//                            'min'      => 5,
//                            'max'      => 255,
//                        ),
//                    ),
//                ),
//            )));
//             
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'direction',
//                'required' => true  
//            )));
//              
// 
//            $this->inputFilter = $inputFilter;
//        }
// 
//        return $this->inputFilter;
//    }
}
