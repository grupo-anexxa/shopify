<?php

use GrupoAnexxa\Shopify\ShopifyAPI;

require_once 'src/autoload.php';

/*Dados da shopify*/
$apiKey      = '8639a288878e119de8ab26cfee270dfe';
$apiPassword = '34c84d7f4c7af34951668bd7694a7a1a';
$nameShop    = 'zicpay-com-br';

$shopify = new ShopifyAPI($apiKey, $apiPassword, $nameShop);

$title       = (string) 'Maça Verde';
$producttype = (string) 'Não sei mesmo';
$vendor      = (string) 'Legumes';
$price       = (string) '20.20';  /*Usar ponto*/
$amount      = (string) "40.00"; /*Usar ponto*/
$taxes       = (string) '0';
$email       = (string) 'steve.lastnameson@example.com';
$quantity    = (string) '2';
$firstname   = (string) 'John';
$lastname    = (string) 'West';
$phone       = (string) '+15142246011';
$company     = (string) 'Grupo Anexxa';
$country     = (string) 'Brasil';
$address     = (string) 'rua Ze comeia';
$suite       = (string) '131';
$city        = (string) 'São paulo';
$country     = (string) 'Brazil';
$state       = (string) 'São Paulo';
$zipcode     = (string) '03008030';

/*Param title não pode ficar vazio*/

/* 
Customers -
Customer must have a name, phone number or email address"
*/


$order = $shopify->setFirstname($firstname);
$order = $shopify->setLastname($lastname);
$order = $shopify->setEmail($email);
$order = $shopify->setPhone($phone);
$order = $shopify->setTitle($title);
$order = $shopify->setPrice($price);
$order = $shopify->setQuantity($quantity);
$order = $shopify->setAmount($amount);
$order = $shopify->setCompany($company);
$order = $shopify->setAddress($address);
$order = $shopify->setSuite($suite);
$order = $shopify->setCity($city);
$order = $shopify->setCountry($country);
$order = $shopify->setState($state);
$order = $shopify->setZipcode($zipcode);

$geturlorder = $shopify->getUrlOrder($order);

$products = $shopify->setTitle($title);
$products = $shopify->setProducttype($producttype);
$products = $shopify->setVendor($vendor);
$products = $shopify->setPrice($price);

$geturlproducts = $shopify->getUrlProducts($products);

$costumers = $shopify->setFirstname($firstname);
$costumers = $shopify->setLastname($lastname);
$costumers = $shopify->setEmail($email);
$costumers = $shopify->setPhone($phone);
$costumers = $shopify->setAddress($address);
$costumers = $shopify->setSuite($suite);
$costumers = $shopify->setCity($city);
$costumers = $shopify->setCountry($country);
$costumers = $shopify->setState($state);
$costumers = $shopify->setZipcode($zipcode);

$geturlcostumers = $shopify->getUrlCustomers($costumers);

//var_dump($geturlorder);
