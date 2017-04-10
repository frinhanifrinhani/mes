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
use Zend\Db\TableGateway\TableGateway;


class ProjetoPorParticipante implements InputFilterAwareInterface {

//    public $codParticipante;
//    public $nomeParticipante;
//    public $emailParticipante;
//    public $cpfParticipante;
//    public $tipoParticipante;
    public $codProjeto;
    public $nomeProjeto;
    public $nomeParticipante;
//    protected $inputFilter;
    protected $dbAdapter;

    function exchangeArray($data) {
//        $this->codParticipante = (isset($data['cod_participante'])) ? $data['cod_participante'] : null;
//        $this->nomeParticipante = (isset($data['nome_participante'])) ? $data['nome_participante'] : null;
//        $this->emailParticipante = (isset($data['email_participante'])) ? $data['email_participante'] : null;
//        $this->cpfParticipante = (isset($data['cpf_participante'])) ? $data['cpf_participante'] : null;
//        $this->tipoParticipante = (isset($data['tipo_participante'])) ? $data['tipo_participante'] : null;
        $this->codProjeto = (isset($data['cod_projeto'])) ? $data['cod_projeto'] : null;
        $this->nomeProjeto = (isset($data['nome_projeto'])) ? $data['nome_projeto'] : null;
        $this->nomeParticipante = (isset($data['nome_participante'])) ? $data['nome_participante'] : null;
    }

    public function getArrayCopy() {
        return array(
//            'cod_participante' => $this->codParticipante,
//            'nome_participante' => $this->nomeParticipante,
//            'email_participante' => $this->email_participante,
//            'cpf_participante' => $this->cpf_participante,
//            'tipo_participante' => $this->tipo_participante,
            'cod_projeto' => $this->codProjeto,
            'nome_projeto' => $this->nomeProjeto,
            'nome_participante' => $this->nomeParticipante,
        );
    }


    /* add */
    public function setDbAdapter($dbAdapter) {

        $this->dbAdapter = $dbAdapter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }
//
    public function getInputFilter() {
//        if (!$this->inputFilter) {
//            $inputFilter = new InputFilter();
//            $factory = new InputFactory();
//
//            $inputFilter->add($factory->createInput(array(
//                        'name' => 'nome_participante',
//                        'required' => true,
//                        'filters' => array(
//                            array('name' => 'StripTags'),
//                            array('name' => 'StringTrim')
//                        ),
//                        'validators' => array(
//                            array(
//                                'name' => 'NotEmpty',
//                                'options' => array(
//                                    'messages' => array(
//                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo nome não pode ser vazio!'
//                                    ),
//                                ),
//                            ),
//                            array(
//                                'name' => 'StringLength',
//                                'options' => array(
//                                    'min' => 3,
//                                    'max' => 255,
//                                    'messages' => array(
//                                        \Zend\Validator\StringLength::TOO_SHORT => 'O campo nome deve ter no mínimo 3 caracteres!',
//                                        \Zend\Validator\StringLength::TOO_LONG => 'O campo nome deve ter no máximo 255 caracteres!',
//                                    )
//                                ),
//                            ),
//                        )
//            )));
//
//            //verifica duplicidade do cpf
//            $inputFilter->add($factory->createInput(array(
//                        'name' => 'cpf_participante',
//                        'required' => true,
//                        'validators' => array(
//                            array(
//                                'name' => '\Zend\Validator\Db\NoRecordExists',
//                                'options' => array(
//                                    'table' => 'participante',
//                                    'field' => 'cpf_participante',
//                                    'adapter' => $this->dbAdapter,
//                                    'messages' => array(
//                                        \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'CPF já cadastrado',
//                                    ),
//                                ),
//                            ),
//                        ),
//            )));
////            verifica duplicidade do email
//            $inputFilter->add($factory->createInput(array(
//                        'name' => 'email_participante',
//                        'required' => true,
//                        'validators' => array(
//                            array(
//                                'name' => '\Zend\Validator\Db\NoRecordExists',
//                                'options' => array(
//                                    'table' => 'participante',
//                                    'field' => 'email_participante',
//                                    'adapter' => $this->dbAdapter,
//                                    'messages' => array(
//                                        \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'Email já cadastrado',
//                                    ),
//                                ),
//                            ),
//                        ),
//            )));
//
//            $this->inputFilter = $inputFilter;
//        }
//
        return $this->inputFilter;
    }

    public function toArray() {
        return get_object_vars($this);
    }
}
