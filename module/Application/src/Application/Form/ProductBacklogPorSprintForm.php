<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;

use Zend\Mvc\Controller\Plugin\Url;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Application\Controller\SprintBacklogController;

class ProductBacklogPorSprintForm extends Form {

    public $sprintTable;
    public $projetoTable;
    public $codProjeto;    

    public function __construct($codProjeto) {
        parent::__construct('product_backlog_por_sprint_form');
        $this->setCodProjeto($codProjeto);
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'product_backlog_por_sprint_form');

        $this->add(array(
            'name' => 'cod_sprint',
            'type' => 'Select',
            'attributes' => array(
                'id' => 'cod_sprint',
                'class' => 'form-control',
                'onchange'=>'location = this.value'
            ),
            'options' => array(
                'label' => 'Sprint',
                'value_options' => $this->getValueSprintOptions(),
            ),
        ));
        $this->add(array(
            'name' => 'cod_product_backlog',
            'type' => 'checkbox',
            'attributes' => array(
                'id' => 'cod_product_backlog',
                'class' => 'form-control',
            ),
//            'options' => array(
//                'label' => 'Código da Sprint',
//            ),
        ));



        $this->add(array(
            'name' => 'botao_salvar',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary',
                'id' => 'botao_salvar',
            ),
        ));
    }

    public function setCodProjeto($codProjeto) {
        $this->codProjeto = $codProjeto;
    }

    private function getCodProjeto() {
        return $this->codProjeto;
    }

    //Busca status
    private function getSprintTable() {
        if (!$this->sprintTable) {
            $sm = $GLOBALS['sm'];
            $this->sprintTable = $sm->get('Application\Model\SprintTable');
        }
        return $this->sprintTable;
    }

    private function getValueSprintOptions() {
        
        $valueSprintOptions = array();
        $sprints = $this->getSprintTable()->fetchAll($this->getCodProjeto());
        $valueSprintOptions[''] = 'Selecione...';
        foreach ($sprints as $sprint) {
            $url= "productbacklog-por-sprint-listar/{$sprint->codSprint}";
//            $valueSprintOptions[$sprint->codSprint] = $sprint->nomeSprint;
            $valueSprintOptions[$url] = $sprint->nomeSprint;
//            $this->url('sprintbacklog',array('cod_projeto'=>$this->codProjeto))
        }
        return $valueSprintOptions;
    }

}
