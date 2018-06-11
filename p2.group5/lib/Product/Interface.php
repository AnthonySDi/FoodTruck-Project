<?php
/**
 * Any product implementing the Product_Interface can be handled by Cart
 */
interface Product_Interface
{
    public function getCost();

    public function setCost($cost = NULL);

    public function getDescription();

    public function setDescription($description = NULL);

    public function getName();

    public function setName($name = NULL);
}