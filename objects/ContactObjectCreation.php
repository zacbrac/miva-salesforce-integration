<?php

$Shipping_Obj = array();

if (isset($_POST['settings:order:ship_fname']) && $_POST['settings:order:ship_fname'] !== '') {$Shipping_Obj['FirstName'] = $_POST['settings:order:ship_fname'];}
if (isset($_POST['settings:order:ship_lname']) && $_POST['settings:order:ship_lname'] !== '') {$Shipping_Obj['LastName'] = $_POST['settings:order:ship_lname'];}
if (isset($_POST['settings:order:ship_email']) && $_POST['settings:order:ship_email'] !== '') {$Shipping_Obj['Email'] = $_POST['settings:order:ship_email'];}
if (isset($_POST['settings:order:ship_phone']) && $_POST['settings:order:ship_phone'] !== '') {$Shipping_Obj['Phone'] = $_POST['settings:order:ship_phone'];}
if (isset($_POST['settings:order:ship_fax']) && $_POST['settings:order:ship_fax'] !== '') {$Shipping_Obj['Fax'] = $_POST['settings:order:ship_fax'];}
if (isset($_POST['settings:order:ship_comp']) && $_POST['settings:order:ship_comp'] !== '') {$Shipping_Obj['Company'] = $_POST['settings:order:ship_comp'];}
if (isset($_POST['settings:order:ship_addr']) && $_POST['settings:order:ship_addr'] !== '') {$Shipping_Obj['MailingStreet'] = $_POST['settings:order:ship_addr'];}
if (isset($_POST['settings:order:ship_city']) && $_POST['settings:order:ship_city'] !== '') {$Shipping_Obj['MailingCity'] = $_POST['settings:order:ship_city'];}
if (isset($_POST['settings:order:ship_state']) && $_POST['settings:order:ship_state'] !== '') {$Shipping_Obj['MailingState'] = $_POST['settings:order:ship_state'];}
if (isset($_POST['settings:order:ship_zip']) && $_POST['settings:order:ship_zip'] !== '') {$Shipping_Obj['MailingPostalCode'] = $_POST['settings:order:ship_zip'];}
if (isset($_POST['settings:order:ship_cntry']) && $_POST['settings:order:ship_cntry'] !== '') {$Shipping_Obj['MailingCountry'] = $_POST['settings:order:ship_cntry'];}
if (isset($Account_Id)) {$Shipping_Obj['AccountId'] = $Account_Id;}

$createResponse = $client->create(array((object) $Shipping_Obj), 'Contact');

foreach ($createResponse as $response) {
	$Contact_Id = $response->getId();
}