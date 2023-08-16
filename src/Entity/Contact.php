<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 100,
    )]
    /**
     * 
     * @var string
     */
    private string $firstname;

    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 100,
    )]
    /**
     * @var string
     */
    private string $lastname;

    #[Assert\NotBlank()]
    #[Assert\Regex(pattern: "/[0-9]{9}/")]
    /**
     * @var string
     */
    private string $phone;

    #[Assert\NotBlank()]
    #[Assert\Email()]
    /**
     * @var string
     */
    private string $email;

    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 10,
    )]
    /**
     * @var string
     */
    private string $message;

    /**
     * @var Housing
     */
    private Housing $housing;

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname 
     * @return self
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname 
     * @return self
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone 
     * @return self
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email 
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message 
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return Housing
     */
    public function getHousing(): Housing
    {
        return $this->housing;
    }

    /**
     * @param Housing $housing 
     * @return self
     */
    public function setHousing(Housing $housing): self
    {
        $this->housing = $housing;
        return $this;
    }
}
