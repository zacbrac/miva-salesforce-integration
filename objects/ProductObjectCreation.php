<?php
$product_names = explode(',', $_POST['settings:products_names']);
$product_codes = explode(',', $_POST['settings:products_codes']);
$product_descriptions = explode(',', $_POST['settings:products_descriptions']);
$product_inv_available = explode(',', $_POST['settings:products_inv_available']);
$product_inv_instock = explode(',', $_POST['settings:products_inv_instock']);
$product_cost = explode(',', $_POST['settings:products_cost']);

//Product Construct
$products = array();
for ($i = 0; $i < count($product_codes); $i++) {
	$product = array();

	$product['Name'] = $product_names[$i];
	$product['ProductCode'] = $product_codes[$i];
	$product['fishbookspro__Last_Cost__c'] = $product_cost[$i];
	$product['Description'] = $product_descriptions[$i];
	$product['fishbookspro__TotalAvailableForSale__c'] = $product_inv_available[$i];
	$product['fishbookspro__TotalInStock__c'] = $product_inv_instock[$i];
	$product['IsActive'] = true;

	$products[] = (object) $product;
}

$createResponse = $client->create($products, 'Product2');

foreach ($createResponse as $product) {
	$product_id = $product->getId();
	echo $product_id . "\n";
}