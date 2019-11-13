<?php

namespace GrupoAnexxa\Shopify;

class CreaterOrders extends Order 
{

  public function __construct(){
   parent::__construct();
  
  }
/*, $quantity, $title, $price, $firstname, $lastname, $company, $address, $suite, $city, $country, $state, $zipcode*/
  public static function insertOrder($email, $quantity, $title, $price, $firstname, $lastname, $company, $address, $suite, $city, $country, $state, $zipcode,$amount)
  {
    set_time_limit(0);
  $obj  = new Order();
  
    $params = array(
      "order" => array(
        "email"            => $obj->setEmail($email),
        "send_receipt"     => true,
        "send_fulfillment_receipt" => true,
        "line_items" => array(
          array(
          "title" => $obj->setTitle($title),
          "price" => $obj->setPrice($price),
          "quantity"    => $obj->setQuantify($quantity)
        )
        ),
        "customer" => array(
            array(
          "first_name"   =>  $obj->setFirstname($firstname),
          "last_name"    =>  $obj->setLastname($lastname),
          "email"        =>  $obj->setEmail($email)
        )
        ),
        "transactions" => array(
         array(
            "kind" => "sale",
            "status" => "success",
            "amount" => $obj->setAmount($amount)
          )
        ),
        "shipping_address" => array(
            array(
          "company"  => $obj->setCompany($company),
          "address1" => $obj->setAddress($address),
          "suite"    => $obj->setSuite($suite),
          "city"     => $obj->setCity($city),
          "country"  => $obj->setCountry($country),
          "province" => $obj->setState($state),
          "zip"      => $obj->setZipcode($zipcode)
        )
        )
      )
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://8639a288878e119de8ab26cfee270dfe:34c84d7f4c7af34951668bd7694a7a1a@zicpay-com-br.myshopify.com/admin/api/2019-10/orders.json",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_RETURNTRANSFER => true, 
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($params),
      CURLOPT_HTTPHEADER => array(
        "Accept: */*",
        "Accept-Encoding: gzip, deflate",
        "Authorization: Basic ODYzOWEyODg4NzhlMTE5ZGU4YWIyNmNmZWUyNzBkZmU6MzRjODRkN2Y0YzdhZjM0OTUxNjY4YmQ3Njk0YTdhMWE=",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Content-Length: 643",
        "Content-Type: application/json",
        "Cookie: __cfduid=dc53de3d09f733d98b38b69c655d98d431573136545",
        "Host: zicpay-com-br.myshopify.com",
        "Postman-Token: 74054ef4-08e6-4d3e-ba74-63c2f0eb60cf,cf7165e5-e0fc-4ab7-a0a7-24ba77df65a6",
        "User-Agent: PostmanRuntime/7.19.0",
        "cache-control: no-cache"
      ),
    ));


    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
       echo "cURL Error #:" . $err;
    } else {
       echo $response;
    }
  }
}

$obj = new CreaterOrders();



