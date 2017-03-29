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

class ProductBacklogPorSprint implements InputFilterAwareInterface {

    public $codProductBacklog;
    public $codSprint;
    protected $inputFilter;
    protected $dbAdapter;
    
    //Recupera os valores que vem por post e passa para os Atributos, caso não exista valores, pass null (no ZF2 faz o papel do get)
    function exchangeArray($data) {
        $this->codProductBacklog = (isset($data['cod_product_backlog'])) ? $data['cod_product_backlog'] : null;
        $this->codSprint = (isset($data['cod_sprint'])) ? $data['cod_sprint'] : null;
    }
    //Rassa os valores que vem do banco para os Atributos, (no ZF2 faz o papel do set)
    public function getArrayCopy() {
        return array(
            'cod_product_backlog' => $this->codProductBacklog,
            'cod_sprint' => $this->codSprint,
            
        );
    }

    //seta o adaptador do banco de dados
    public function setDbAdapter($dbAdapter) {

        $this->dbAdapter = $dbAdapter;
    }

    //seta o inputfilter e retorna uma exessão
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Não");
    }

    //recupera o input filter, tratado os dados que vem do Form
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'nome_product_backlog',
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
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo Nome do Item não pode ser vazio!'
                                    ),
                                ),
                            ),
                        )
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'descricao_product_backlog',
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
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo Descrição do Item não pode ser vazio!'
                                    ),
                                ),
                            ),
                        )
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'prioridade_product_backlog',
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
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo Prioridade não pode ser vazio!'
                                    ),
                                ),
                            ),
                        )
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function toArray() {
        return get_object_vars($this);
    }

}
