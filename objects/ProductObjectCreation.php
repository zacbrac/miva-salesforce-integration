<?php

$product_names = explode(',', $_POST['settings:products_names']);
$product_codes = explode(',', $_POST['settings:products_codes']);
$product_ids = explode(',', $_POST['settings:products_ids']);
$product_quantities = explode(',', $_POST['settings:products_quantities']);
$product_descriptions = explode(',', $_POST['settings:products_descriptions']);
$product_inv_available = explode(',', $_POST['settings:products_inv_available']);
$product_inv_instock = explode(',', $_POST['settings:products_inv_instock']);
$product_cost = explode(',', $_POST['settings:products_cost']);
$product_line_price = explode(',', $_POST['settings:products_line_prices']);
$product_price = explode(',', $_POST['settings:products_unit_prices']);

//Product Construct
$products = array();
for ($i = 0; $i < count($product_codes); $i++) {
	
	$product = array();

	$product['Name'] = $product_names[$i];
	$product['ProductCode'] = $product_codes[$i];
	$product['Product2Id'] = $product_ids[$i];
	$product['Product_Code__c'] = $product_codes[$i];
	$product['fishbookspro__Last_Cost__c'] = $product_cost[$i];
	$product['TotalPrice'] = $product_line_price[$i];
	$product['UnitPrice'] = $product_price[$i];
	$product['Description'] = $product_descriptions[$i];
	$product['Quantity'] = $product_quantities[$i];
	$product['fishbookspro__TotalAvailableForSale__c'] = $product_inv_available[$i];
	$product['fishbookspro__TotalInStock__c'] = $product_inv_instock[$i];
	$product['IsActive'] = true;
	$product['OpportunityId'] = $Opportunity_Id;
	$products[] = (object) $product;

}

$createResponse = $client->upsert( 'Product_Code__c' , $products, 'Product2');

foreach ($createResponse as $product) {
	
	$product_id = $product->getId();
	var_dump($product_id);

}

