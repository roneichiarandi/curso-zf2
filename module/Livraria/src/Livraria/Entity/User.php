<?php

namespace Livraria\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Livraria\Entity\UserRepository")
 */
class User {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var int
	 */
	protected $id;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $nome;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $email;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $password;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $salt;

	public function __construct($options = null) {
		Configurator::configure($this, $options);
		$this->salt = base_convert(uniqid(mt_rand(true)), 16, 36);
	}

	public function getId()
	{
	    return $this->id;
	}
	
	public function setId($id)
	{
	    return $this->id = $id;
	}

	public function getNome()
	{
	    return $this->nome;
	}
	
	public function setNome($nome)
	{
	    return $this->nome = $nome;
	}

	public function getEmail()
	{
	    return $this->email;
	}
	
	public function setEmail($email)
	{
	    return $this->email = $email;
	}

	public function getPassword()
	{
	    return $this->password;
	}
	
	public function setPassword($password)
	{
		$hashSenha = $this->encryptPassword($password);
	    return $this->password = $hashSenha;
	}

	public function getSalt() 
	{
		return $this->salt;
	}

	public function toArray() {
		return array(
			'id' => $this->getId(),
			'nome' => $this->getNome(),
			'email' => $this->getEmail(),
			'password' => $this->getPassword(),
			'salt' => $this->salt
		);
	}

	public function encryptPassword($password) {
		$hashSenha = hash('sha512', $password . $this->salt);
		for($i=0; $i<64000; $i++) 
			$hashSenha = hash('sha512', $hashSenha);

		return $hashSenha;
	}
}