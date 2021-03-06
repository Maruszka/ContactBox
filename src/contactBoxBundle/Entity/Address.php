<?php

namespace contactBoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="contactBoxBundle\Entity\AddressRepository")
 */
class Address {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=60)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=60)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="house_number", type="string", length=50)
     */
    private $houseNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="flat_number", type="string", length=50)
     */
    private $flatNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="addresses")
     * @ORM\JoinColumn()
     */
    private $person;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street) {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * Set houseNumber
     *
     * @param string $houseNumber
     * @return Address
     */
    public function setHouseNumber($houseNumber) {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return string 
     */
    public function getHouseNumber() {
        return $this->houseNumber;
    }

    /**
     * Set flatNumber
     *
     * @param integer $flatNumber
     * @return Address
     */
    public function setFlatNumber($flatNumber) {
        $this->flatNumber = $flatNumber;

        return $this;
    }

    /**
     * Get flatNumber
     *
     * @return integer 
     */
    public function getFlatNumber() {
        return $this->flatNumber;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Address
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set person
     *
     * @param \contactBoxBundle\Entity\Person $person
     * @return Address
     */
    public function setPerson(\contactBoxBundle\Entity\Person $person = null) {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \contactBoxBundle\Entity\Person 
     */
    public function getPerson() {
        return $this->person;
    }

}
