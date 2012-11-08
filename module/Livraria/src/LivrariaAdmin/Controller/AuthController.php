<?php

namespace LivrariaAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel,
	Zend\Authentication\AuthenticationService,
	Zend\Authentication\Storage\Session as SessionStorage;

use LivrariaAdmin\Form\Login as LoginForm;

class AuthController extends AbstractActionController{

	public function __construct() {
		$this->entity     = 'Livraria\Entity\Categoria';
		$this->form       = 'LivrariaAdmin\Form\Categoria';
		$this->service    = 'Livraria\Service\Categoria';
		$this->controller = 'categorias';
		$this->route 	  = 'livraria-admin';
	}

	public function indexAction() {
		$form = new LoginForm;
		$error = false;

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if($form->isValid()) {
				$data = $request->getPost()->toArray();

				$auth = new AuthenticationService;
				$sessionStorage = new SessionStorage('LivrariaAdmin');
				$auth->setStorage($sessionStorage);

				$authAdapter = $this->getServiceLocator()->get('Livraria\Auth\Adapter');
				$authAdapter->setUsername($data['email']);
                $authAdapter->setPassword($data['password']);

				$result = $auth->authenticate($authAdapter);

				if ($result->isValid()) {
					# php 5.4 == $sessionStorage->write($auth->getIdentity()['user'], null);
					
					$user = $auth->getIdentity();
					$sessionStorage->write($user['user'], null);

					return $this->redirect()->toRoute('livraria-admin', array('controller' => 'categorias'));
				}else
					$error = true;
			}
		}

		return new ViewModel(array('form' => $form, 'error' => $error));
	}

	public function logoutAction() {
		$auth = new AuthenticationService;
		$auth->setStorage(new SessionStorage('LivrariaAdmin'));
		$auth->clearIdentity();

		return $this->redirect()->toRoute('livraria-admin-auth');
	}

}