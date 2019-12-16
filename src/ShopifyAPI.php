<?php

/*
*		INTEGRAÇÃO COM O SHOPIFY - ATUALIZADO 2019-12-10
*		LINK DO CODIGO: 		https://github.com/grupo-anexxa/shopify
*		LINK DA DOCUMENTAÇÃO:	https://help.shopify.com/en/api/reference/orders/order
*		LINK DAS CREDENCIAIS: 	https://zicpay-com-br.myshopify.com/admin/apps/private
*/


class ShopifyAPI
{
	private $testMode = true;

	private  $productType;
	private  $title;
	private  $vendor;
	private  $price;
	private  $taxes;	
	private  $email;
	private  $firstName;
	private  $lastName;
	private  $phone;
	private  $quantity;
	private  $company;
	private  $address1;
	private  $address2;
	private  $city;
	private  $countryName;
	private  $countryCode;
	private  $stateName;
	private  $stateCode;
	private  $zipCode;
	private  $amount;
	private  $id;

	protected $apiKey;      
	protected $apiPassword; 
	protected $nameShop;  


	public function __construct($apiKey = '', $apiPassword = '', $nameShop = '')
	{
		$this->apiKey 	   = $apiKey;
		$this->apiPassword = $apiPassword;
		$this->nameShop    = $nameShop;
	}


	public function checkShop()
	{

		$url = 'https://'.$this->apiKey.':'.$this->apiPassword.'@'.$this->nameShop.'.myshopify.com/admin/api/2019-10/orders.json';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "Accept: */*",
		    "Accept-Encoding: gzip, deflate",
		    "Authorization: Basic ODYzOWEyODg4NzhlMTE5ZGU4YWIyNmNmZWUyNzBkZmU6MzRjODRkN2Y0YzdhZjM0OTUxNjY4YmQ3Njk0YTdhMWE=",
		    "Cache-Control: no-cache",
		    "Connection: keep-alive"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return "cURL Error #:" . $err;
		} else {
		  return $response;
		}

	}


	public function queryShop()
	{
		
		$responseShop = $this->getUrlShop('https://'.$this->apiKey.':'.$this->apiPassword.'@'.$this->nameShop.'.myshopify.com/admin/api/2019-10/shop.json');

		if (($jsonShop = json_decode($responseShop)) === null) {
			echo  '[apiKey or apiPassword or nameShop invalid]';
		}else{
			return true;
		}		
	}


	public function getUrlShop($url)
	{

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_ENCODING, "");
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive','Cache-Control: no-cache' ));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return $response;
		}
	}


	public function getOrder()
	{
		if($this->queryShop() === true)
		{
			$url = 'https://'.$this->apiKey.':'.$this->apiPassword.'@'.$this->nameShop.'.myshopify.com/admin/api/2019-10/orders.json';
			
			$params = array(
				"order" => array(
					"email"            			=> $this->email,
					"phone"        				=>  $this->phone,
					"send_receipt"     			=> true,
					"send_fulfillment_receipt" 	=> true,
					"total_price" 				=> $this->amount,
					"test" 						=> $this->testMode,
					"total_tax"					=>$this->taxes,
					"line_items" => array(
						array(
							"variant_id"  => null,
							"title" 	  => $this->title,
							"price" 	  => $this->price,
							"quantity"    => $this->quantity
						)
					),
					"customer" => array(
						"first_name"   =>  $this->firstName,
						"last_name"    =>  $this->lastName,
						"email"        =>  $this->email,
						"phone"        =>  $this->phone
					),
					"transactions" => array(
						array(
							"kind"   => "sale",
							"status" => "success",
							"amount" => $this->amount
						)
					),
					"shipping_address"=> array(
						"address1"=> $this->address1,
						"address2"=> $this->address2,
						"city"=> $this->city,
						"company"=> $this->company,
						"country"=> $this->countryName,
						"first_name"=> $this->firstName,
						"last_name"=> $this->lastName,
						"phone"=> $this->phone,
						"province"=> $this->stateName,
						"zip"=> $this->zipCode,
						"name"=> $this->firstName.' '.$this->lastName,
						"country_code"=> $this->countryCode,
						"province_code"=> $this->stateCode
					)
				)
			);

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_ENCODING, "");
			curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive','Cache-Control: no-cache' ));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				return $response;
			}

		} else {
			return false;
		}
	}



	public function getProducts()
	{

		if($this->queryShop() === true)
		{
			$url = 'https://'.$this->apiKey.':'.$this->apiPassword.'@'.$this->nameShop.'.myshopify.com/admin/api/2019-10/products.json';
			
			$params = array(
				'product' => array(
					'title'        => $this->title,
					'product_type' => $this->productType,
					'vendor'       => $this->vendor,
					'variants' => array(
						'price'  => $this->price
					)
				)
			);

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_ENCODING, "");
			curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive','Cache-Control: no-cache' ));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				return $response;
			}

		} else {
			return false;
		}
	}

	public function getCustomers()
	{

		if($this->queryShop() === true)
		{
			$url = 'https://'.$this->apiKey.':'.$this->apiPassword.'@'.$this->nameShop.'.myshopify.com/admin/api/2019-10/customers.json';
			
			$params = array(
				"customer" => array(
					"first_name"   =>  $this->firstName,
					"last_name"    =>  $this->lastName,
					"email"        =>  $this->email,
					"phone"        =>  $this->phone,
					"shipping_address" => array(
						array(
							"company"  => $this->company,
							"address1" => $this->address,
							"suite"    => $this->suite,
							"city"     => $this->city,
							"country"  => $this->country,
							"province" => $this->state,
							"zip" 	   => $this->zipCode
						)
					)
				)
			);

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_ENCODING, "");
			curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive','Cache-Control: no-cache' ));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				echo $response;
			}

		} else {
			return false;
		}
	}


	public function getProductType(){
		return $this->productType;
	}
	public function setProductType($productType){
		$this->productType = $productType;
	}
	public function getTitle(){
		return $this->title;
	}
	public function setTitle($title){
		$this->title = $title;
	}
	public function getVendor(){
		return $this->vendor;
	}
	public function setVendor($vendor){
		$this->vendor = $vendor;
	}
	public function getPrice(){
		return $this->price;
	}
	public function setPrice($price){
		$this->price = $price;
	}
	public function getTaxes(){
		return $this->taxes;
	}
	public function setTaxes($taxes){
		$this->taxes = $taxes;
	}
	public function getEmail(){
		return $this->email;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	public function getFirstName(){
		return $this->firstName;
	}
	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}
	public function getLastName(){
		return $this->lastName;
	}
	public function setLastName($lastName){
		$this->lastName = $lastName;
	}
	public function getPhone(){
		return $this->phone;
	}
	public function setPhone($phone){
		$this->phone = $phone;
	}
	public function getQuantity(){
		return $this->quantity;
	}
	public function setQuantity($quantity){
		$this->quantity = $quantity;
	}
	public function getCompany(){
		return $this->company;
	}
	public function setCompany($company){
		$this->company = $company;
	}
	public function getAddress1(){
		return $this->address1;
	}
	public function setAddress1($address1){
		$this->address1 = $address1;
	}
	public function getAddress2(){
		return $this->address2;
	}
	public function setAddress2($address2){
		$this->address2 = $address2;
	}
	public function getCity(){
		return $this->city;
	}
	public function setCity($city){
		$this->city = $city;
	}
	public function getCountryName(){
		return $this->countryName;
	}
	public function setCountryName($countryName){
		$this->countryName = $countryName;
	}
	public function getCountryCode(){
		return $this->countryCode;
	}
	public function setCountryCode($countryCode){
		$this->countryCode = $countryCode;
	}
	public function getStateName(){
		return $this->stateName;
	}
	public function setStateName($stateName){
		$this->stateName = $stateName;
	}
	public function getStateCode(){
		return $this->stateCode;
	}
	public function setStateCode($stateCode){
		$this->stateCode = $stateCode;
	}
	public function getZipCode(){
		return $this->zipCode;
	}
	public function setZipCode($zipCode){
		$this->zipCode = $zipCode;
	}
	public function getAmount(){
		return $this->amount;
	}
	public function setAmount($amount){
		$this->amount = $amount;
	}
	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id = $id;
	}	
	public function getApiKey(){
		return $this->apiKey;
	}
	public function setApiKey($apiKey){
		$this->apiKey = $apiKey;
	}
	public function getApiPassword(){
		return $this->apiPassword;
	}
	public function setApiPassword($apiPassword){
		$this->apiPassword = $apiPassword;
	}
	public function getNameShop(){
		return $this->nameShop;
	}
	public function setNameShop($nameShop){
		$this->nameShop = $nameShop;
	}

}

