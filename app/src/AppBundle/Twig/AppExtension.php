<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 22.08.17
 * Time: 15:40
 */

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }

    public function getFunctions()
    {
        return ['simple' => new \Twig_Function_Method($this, 'simple')];
    }

    public function simple($value)
    {
        return $value;
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }
}