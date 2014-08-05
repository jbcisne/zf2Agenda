<?php

namespace Contato\Form;

//import Form\Captcha
use Zend\Captcha;
//import Form\Formt
use Zend\Form\Form;
//import Form\Element
use Zend\Form\Element;

class ContatoForm extends Form
{
    public function __construct($name = null) {
        parent::__construct($name);
        
        //config form atributes
        $this->setAttributes(array(
            'method'=> 'POST',
            'class' => 'form-horizontal',
        ));
        
        //elemento do tipo hidden
        $this->add(array(
            'type'  =>  'Hidden', # ou 'type' => 'Zend\Form\Element\Hidden'
            'name'  =>  'id',
        ));
        
        $this->add(array(
            'type'  =>  'Text', # ou 'type' => 'Zend\Form\Element\Text'
            'name'  =>  'nome',
            'attributes' => array(
                'class'=> 'form-control',
                'id' => 'inputNome',
                'placeholder'=> 'Nome Completo',
            )
        ));
        
        $this->add(
            (new Element\Text()) /* uso de interface fluente do PHP >= 5.4*/
            ->setName('telefone_principal')
            ->setAttributes([ /* [] == array() no PHP >= 5.4 */
                'class' => 'form-control',
                'id' => 'inputTelefonePrincipal',
                'placeholder' => 'Digite seu telefone principal',

            ])
        );
        
        $this->add(array(
            'type'  =>  'Text', # ou 'type' => 'Zend\Form\Element\Text'
            'name'  =>  'telefone_secundario',
            'attributes' => array(
                'class'=> 'form-control',
                'id' => 'inputTelefoneSecundario',
                'placeholder'=> 'Digite seu telefone secundário (opcional)',
            )
        ));
        
        $this->add(
            (new Element\Captcha())
            ->setName('captcha')
            ->setOptions(array(
                'captcha' => (new Captcha\Figlet(array(
                    'wordLen' => 12,        # quantidade de caracteres para o nosso captcha
                    'timeout' => 300,       # tempo de validade do captcha em milisegundos
                    'outputWidth' => '500', # quantidade de strings por linha do captcha
                    'font' => 'data/fonts/banner3.flf' # font para o captcha do tipo figlet
                )))->setMessage('Campo faltando ou digitado incorretamente')
            ))
            ->setAttributes([
                'class' => 'form-control',
                'id' => 'inputCaptcha',
                'placeholder'=>'Digite a plavra acima, para prosseguir',
            ])
        );
        
        $this->add(new Element\Csrf('security'));
        
    }
}