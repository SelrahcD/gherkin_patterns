<?php

declare(strict_types=1);


use Root\App\Customer;

final class CustomerBuilder
{
    private string $firstname;
    private string $lastname;
    private string $birthDate;
    private string $address;
    private string $phoneNumber;

    /**
     * @param string $firstname
     */
    public function withFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @param string $lastname
     */
    public function withLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;

    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate(string $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;

    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;

    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function __construct(\Faker\Generator $generator)
    {
        $this->firstname = $generator->firstName;
        $this->lastname = $generator->lastName;
        $this->birthDate = $generator->date();
        $this->address = $generator->address;
        $this->phoneNumber = $generator->phoneNumber;
    }


    public function withInfo(array $userData): Customer
    {
        foreach ($userData as $key => $value) {
            $this->setValue($key, $value);
        }

        return $this->build();
    }

    public function build(): Customer
    {
        return new Customer(
            $this->firstname,
            $this->lastname,
            $this->phoneNumber,
            $this->address,
            $this->birthDate
        );
    }

    private function setValue(string $key, mixed $value): void
    {
        $prefixes = ['set', 'with'];

        foreach ($prefixes as $prefix) {
            $methodName = $prefix . str_replace(' ', '', $key);

            if (method_exists($this, $methodName)) {
                call_user_func_array([$this, $methodName], [$value]);
                return;
            }
        }


        throw new InvalidArgumentException(sprintf("Could not find a method to set the value for %s", $key));
    }
}