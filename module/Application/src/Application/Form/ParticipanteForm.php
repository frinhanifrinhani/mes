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

class ParticipanteForm extends Form {
    public $tipoParticipanteTable;
    
    public function __construct() {
        parent::__construct('form_participante');
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'form_participante');
        
        $this->add(array(
            'name' => 'cod_participante',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'cod_participante',
              'class'=>'form-control',
              'placeholder'=>'Código do Participante',
//              'readonly'=>'readonly',
            ),
            'options'=>array(
                'label'=>'Código do Participante',
            ),
        ));
        
        $this->add(array(
            'name' => 'nome_participante',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'nome_participante',
              'class'=>'form-control',
              'placeholder'=>'Nome Completo',
            ),
            'options'=>array(
                'label'=>'Nome do participante *',
            ),
        ));
        
        $this->add(array(
            'name' => 'cpf_participante',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'cpf_participante',
              'class'=>'form-control',
              'placeholder'=>'CPF',
            ),
            'options'=>array(
                'label'=>'CPF *',
            ),
        ));
        
        $this->add(array(
            'name' => 'telefone_participante',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'telefone_usuario',
              'class'=>'form-control',
              'placeholder'=>'Telefone para contato',
            ),
            'options'=>array(
                'label'=>'Telefone',
            ),
        ));
        
        $this->add(array(
            'name' => 'email_participante',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'email_usuario',
              'class'=>'form-control',
              'placeholder'=>'E-mail',
            ),
            'options'=>array(
                'label'=>'E-mail *',
            ),
        ));
        
        $this->add(array(
            'name' => 'cod_tipo_participante',
            'type' => 'Select',
            'attributes'=>array(
              'id' => 'cod_tipo_participante',
              'class'=>'form-control',
              
            ),
            'options'=>array(
                'label'=>'Tipo de participante *',
                'value_options' => $this->getValueOptions(),
                
            ),
        ));

        $this->add(array(
            'name' => 'botao_salvar',
            'type' => 'Submit',
            'attributes'=> array(
              'value' => 'Salvar', 
              'class'=>'btn btn-primary',
              'id' => 'botao_salvar',
            ),
        ));
    }
    
    //Busca tipo de participante
    private function getTipoParticipanteTable(){
        if(!$this->tipoParticipanteTable){
            $sm = $GLOBALS['sm'];
            $this->tipoParticipanteTable = $sm->get('Application\Model\TipoParticipanteTable');
        }
        return $this->tipoParticipanteTable;
    }
    
    private function getValueOptions(){
        $valueOptions = array();
        $tiposParticipantes = $this->getTipoParticipanteTable()->fetchAll();
        $valueOptions['']='Selecione...';
        foreach ($tiposParticipantes as $tipoParticipante){
            $valueOptions[$tipoParticipante->codTipoParticipante]= $tipoParticipante->tipoParticipante;
        }
        return $valueOptions;
    }
}
