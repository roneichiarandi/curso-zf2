<?php

namespace LivrariaAdmin\Form;

use Zend\Form\Form;

class Login extends Form {

	public function __construct($name = null) {
		parent::__construct('login');

		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'email',
			'options' => array(
				'type' => 'email',
				'label' => 'E-mail'
			),
			'attributes' => array(
				'placeholder' => 'Entre com o E-mail'
			)
		));

		$this->add(array(
			'name' => 'password',
			'options' => array(
				'type' => 'text',
				'label' => 'Senha'
			),
			'attributes' => array(
				'type' => 'password'
			)
		));

		$this->add(array(
			'name' => 'submit',
			'type' => 'Zend\Form\Element\Submit',
			'attributes' => array(
				'value' => 'Login',
				'class' => 'btn-success'
			)
		));
	}
}