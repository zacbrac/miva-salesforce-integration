<?php
// BILL TO INFO
if (isset($_POST['settings:order:bill_fname']) && $_POST['settings:order:bill_fname'] !== '') {$Billing_Obj['FirstName'] = $_POST['settings:order:bill_fname'];}
if (isset($_POST['settings:order:bill_lname']) && $_POST['settings:order:bill_lname'] !== '') {$Billing_Obj['LastName'] = $_POST['settings:order:bill_lname'];}
if (isset($_POST['settings:order:bill_email']) && $_POST['settings:order:bill_email'] !== '') {$Billing_Obj['Email'] = $_POST['settings:order:bill_email'];}
if (isset($_POST['settings:order:bill_phone']) && $_POST['settings:order:bill_phone'] !== '') {$Billing_Obj['Phone'] = $_POST['settings:order:bill_phone'];}
if (isset($_POST['settings:order:bill_fax']) && $_POST['settings:order:bill_fax'] !== '') {$Billing_Obj['Fax'] = $_POST['settings:order:bill_fax'];}
if (isset($_POST['settings:order:bill_comp']) && $_POST['settings:order:bill_comp'] !== '') {$Billing_Obj['Company'] = $_POST['settings:order:bill_comp'];}
if (isset($_POST['settings:order:bill_addr']) && $_POST['settings:order:bill_addr'] !== '') {$Billing_Obj['Street'] = $_POST['settings:order:bill_addr'];}
if (isset($_POST['settings:order:bill_city']) && $_POST['settings:order:bill_city'] !== '') {$Billing_Obj['City'] = $_POST['settings:order:bill_city'];}
if (isset($_POST['settings:order:bill_state']) && $_POST['settings:order:bill_state'] !== '') {$Billing_Obj['State'] = $_POST['settings:order:bill_state'];}
if (isset($_POST['settings:order:bill_zip']) && $_POST['settings:order:bill_zip'] !== '') {$Billing_Obj['PostalCode'] = $_POST['settings:order:bill_zip'];}
if (isset($_POST['settings:order:bill_cntry']) && $_POST['settings:order:bill_cntry'] !== '') {$Billing_Obj['Country'] = $_POST['settings:order:bill_cntry'];}


// SHIP TO INFO
if (isset($_POST['settings:order:ship_fname']) && $_POST['settings:order:ship_fname'] !== '') {$Shipping_Obj['FirstName'] = $_POST['settings:order:ship_fname'];}
if (isset($_POST['settings:order:ship_lname']) && $_POST['settings:order:ship_lname'] !== '') {$Shipping_Obj['LastName'] = $_POST['settings:order:ship_lname'];}
if (isset($_POST['settings:order:ship_email']) && $_POST['settings:order:ship_email'] !== '') {$Shipping_Obj['Email'] = $_POST['settings:order:ship_email'];}
if (isset($_POST['settings:order:ship_phone']) && $_POST['settings:order:ship_phone'] !== '') {$Shipping_Obj['Phone'] = $_POST['settings:order:ship_phone'];}
if (isset($_POST['settings:order:ship_fax']) && $_POST['settings:order:ship_fax'] !== '') {$Shipping_Obj['Fax'] = $_POST['settings:order:ship_fax'];}
if (isset($_POST['settings:order:ship_comp']) && $_POST['settings:order:ship_comp'] !== '') {$Shipping_Obj['Company'] = $_POST['settings:order:ship_comp'];}
if (isset($_POST['settings:order:ship_addr']) && $_POST['settings:order:ship_addr'] !== '') {$Shipping_Obj['Street'] = $_POST['settings:order:ship_addr'];}
if (isset($_POST['settings:order:ship_city']) && $_POST['settings:order:ship_city'] !== '') {$Shipping_Obj['City'] = $_POST['settings:order:ship_city'];}
if (isset($_POST['settings:order:ship_state']) && $_POST['settings:order:ship_state'] !== '') {$Shipping_Obj['State'] = $_POST['settings:order:ship_state'];}
if (isset($_POST['settings:order:ship_zip']) && $_POST['settings:order:ship_zip'] !== '') {$Shipping_Obj['PostalCode'] = $_POST['settings:order:ship_zip'];}
if (isset($_POST['settings:order:ship_cntry']) && $_POST['settings:order:ship_cntry'] !== '') {$Shipping_Obj['Country'] = $_POST['settings:order:ship_cntry'];}


if (isset($_POST['settings:order:bill_comp']) && $_POST['settings:order:bill_comp'] !== '') {$Billing_Obj['Company_Id__c'] = $_POST['settings:order:bill_comp'];}
if (isset($_POST['settings:order:ship_comp']) && $_POST['settings:order:ship_comp'] !== '') {$Shipping_Obj['Company_Id__c'] = $_POST['settings:order:ship_comp'];}
$Billing_Obj['LeadSource'] = "Miva";

if ($Billing_Obj['FirstName'] != $Shipping_Obj['FirstName'] || $Billing_Obj['LastName'] != $Shipping_Obj['LastName'] || $Billing_Obj['Email'] != $Shipping_Obj['Email'] || $Billing_Obj['Phone'] != $Shipping_Obj['Phone'] || $Billing_Obj['Company'] != $Shipping_Obj['Company'] || $Billing_Obj['Street'] != $Shipping_Obj['Street'] || $Billing_Obj['City'] != $Shipping_Obj['City'] || $Billing_Obj['State'] != $Shipping_Obj['State'] || $Billing_Obj['PostalCode'] != $Shipping_Obj['PostalCode'] || $Billing_Obj['Country'] != $Shipping_Obj['Country']) {
	$different_info = true;
}

if ( isset($logged_in) && $logged_in === true ) {
	$createResponse = $client->upsert( 'Company_Id__c', array((object) $Billing_Obj), 'Lead');
} else {
	$createResponse = $client->create(array((object) $Billing_Obj), 'Lead');	
}

foreach ($createResponse as $lead) {
	$Lead_Id = $lead->getId();
}