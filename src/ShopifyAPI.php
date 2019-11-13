<?php

namespace GrupoAnexxa\Shopify;


class ShopifyAPI
{

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
	private  $address;
	private  $suite;
	private  $city;
	private  $country;
	private  $state;
	private  $zipCode;
	private  $amount;
	private  $id;

	protected $apiKey;       /*8639a288878e119de8ab26cfee270dfe*/
	protected $apiPassword; /*34c84d7f4c7af34951668bd7694a7a1a*/
	protected $nameShop;   /*zicpay-com-br*/

	public function __construct($apiKey = '', $apiPassword = '', $nameShop = '', $email='', $quantity='', $vendor='', $title='', $productType='', $price='', $firstName='', $lastName='', $company='', $address='', $suite='', $city='', $country='', $state='', $zipCode='', $amount='')
	{
		$this->apiKey 	   = $apiKey;
		$this->apiPassword = $apiPassword;
		$this->nameShop    = $nameShop;
		$this->title 	   = $title;
		$this->vendor      = $vendor;
		$this->productType = $productType;
		$this->quantity    = $quantity;
		$this->email       = $email;
		$this->price 	   = $price;
		$this->firstName   = $firstName;
		$this->lastName    = $lastName;
		$this->company 	   = $company;
		$this->address     = $address;
		$this->suite       = $suite;
		$this->city        = $city;
		$this->country     = $country;
		$this->state       = $state;
		$this->zipCode     = $zipCode;
		$this->amount      = $amount;
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

	public function getUrlOrder()
	{
		if($this->queryShop() === true)
		{
			$url = 'https://'.$this->apiKey.':'.$this->apiPassword.'@'.$this->nameShop.'.myshopify.com/admin/api/2019-10/orders.json';
			
			$params = array(
				"order" => array(
					"email"            => $this->email,
					"send_receipt"     => true,
					"send_fulfillment_receipt" => true,
					"total_price" => $this->amount,
					"line_items" => array(
						array(
							"variant_id" => 'tyutyu',
							"title" => $this->title,
							"price" => $this->price,
							"quantity"    => $this->quantity
						)
					),
					"customer" => array(
						"first_name"   =>  $this->firstName,
						"last_name"    =>  $this->lastName,
						"email"        =>  $this->email
					),
					"transactions" => array(
						array(
							"kind" => "sale",
							"status" => "success",
							"amount" => $this->amount
						)
					),
					"shipping_address" => array(
						"company"  => $this->company,
						"address1" => $this->address,
						"suite"    => $this->suite,
						"city"     => $this->city,
						"country"  => $this->country,
						"province" => $this->state,
						"zip"      => $this->zipCode
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

	public function getUrlProducts()
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

	public function getUrlCustomers()
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

	public function getProducttype(){
		return $this->productType;
	}

	public function setProducttype($productType){
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

	public function getAddress(){
		return $this->address;
	}

	public function setAddress($address){
		$this->address = $address;
	}

	public function getSuite(){
		return $this->suite;
	}

	public function setSuite($suite){
		$this->suite = $suite;
	}

	public function getCity(){
		return $this->city;
	}

	public function setCity($city){
		$this->city = $city;
	}

	public function getCountry(){
		return $this->country;
	}

	public function setCountry($country){
		$this->country = $country;
	}

	public function getState(){
		return $this->state;
	}

	public function setState($state){
		$this->state = $state;
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

