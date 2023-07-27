<?php

namespace App\Entity;


class HousingSearch
{

	private ?string $city = null;

	private ?int $maxPrice = null;

	private ?int $rooms = null;


	/**
	 * @return string|null
	 */
	public function getCity(): ?string
	{
		return $this->city;
	}

	/**
	 * @param string|null $city 
	 * @return self
	 */
	public function setCity(?string $city): self
	{
		$this->city = $city;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getMaxPrice(): ?int
	{
		return $this->maxPrice;
	}

	/**
	 * @param int|null $maxPrice 
	 * @return self
	 */
	public function setMaxPrice(?int $maxPrice): self
	{
		$this->maxPrice = $maxPrice;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getRooms(): ?int
	{
		return $this->rooms;
	}

	/**
	 * @param int|null $rooms 
	 * @return self
	 */
	public function setRooms(?int $rooms): self
	{
		$this->rooms = $rooms;
		return $this;
	}
}
