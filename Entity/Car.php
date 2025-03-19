<?php

class Car
{
    private int | null $id;
    private string $brand;
    private string $model;
    private int $horsePower;
    private string $image;

    public function __construct(int|null $id, string $brand, string $model, int $horsePower, string $image)
    {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->horsePower = $horsePower;
        $this->image = $image;
    }



    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of brand
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * Set the value of brand
     *
     * @return  self
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get the value of model
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Get the value of horsePower
     */
    public function getHorsePower(): int
    {
        return $this->horsePower;
    }

    /**
     * Set the value of horsePower
     *
     * @return  self
     */
    public function setHorsePower($horsePower)
    {
        $this->horsePower = $horsePower;
    }

    /**
     * Get the value of image
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}
