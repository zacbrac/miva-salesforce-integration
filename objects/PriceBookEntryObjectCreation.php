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
$product_codes_count = count($product_codes);

for ($i = 0; $i < $product_codes_count; $i++) {
    
    $product = array();

    $product['Pricebook2Id'] = '01s500000001hs2AAA';

    $query = "SELECT Id from PricebookEntry WHERE Product_Code_c__c = '$product_codes[$i]'";
    $response = $client->query($query);
    $response = $response->getQueryResult();
    $response = $response->getRecord(0);

    if ($response == null) {

        $query = "SELECT Id from Product2 WHERE Product_Code__c = '$product_codes[$i]'";
        $response = $client->query($query);
        $response = $response->getQueryResult();
        $response = $response->getRecord(0);

        $product['Product2Id'] = $response->Id;

    }

    $product['Product_Code_c__c'] = $product_codes[$i];
    $product['UnitPrice'] = $product_price[$i];
    $product['IsActive'] = true;
    $products[] = (object) $product;

}

$createResponse = $client->upsert( 'Product_Code_c__c' , $products, 'PricebookEntry');

foreach ($createResponse as $product) {
    
    $product_id = $product->getId();
    var_dump($product_id);

}
