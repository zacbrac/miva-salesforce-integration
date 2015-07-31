<?php

$product_names = str_getcsv($_POST['settings:products_names'], ',', '"');
$product_codes = explode(',', $_POST['settings:products_codes']);
$product_ids = explode(',', $_POST['settings:products_ids']);
$product_quantities = explode(',', $_POST['settings:products_quantities']);
$product_descriptions = str_getcsv($_POST['settings:products_descriptions'], ',', '"');
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

    $product['Description'] = $product_descriptions[$i];
    $product['OpportunityId'] = $Opportunity_Id;
    $product['TotalPrice'] = $product_line_price[$i];
    $product['Description'] = $product_descriptions[$i];
    $product['Quantity'] = $product_quantities[$i];

    $query = "SELECT Id from PricebookEntry WHERE Product_Code__c = '$product_codes[$i]'";
    $response = $client->query($query);
    $response = $response->getQueryResult();
    $response = $response->getRecord(0);
    $product['PricebookEntryId'] = $response->Id;

    $products[] = (object) $product;

}

$createResponse = $client->create( $products, 'OpportunityLineItem');

foreach ($createResponse as $product) {
    
    $product_id = $product->getId();

}
