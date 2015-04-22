<?php

$Billing_Obj = array();

if (isset($_POST['settings:order:bill_fname']) && $_POST['settings:order:bill_fname'] !== '') {$Billing_Obj['FirstName'] = $_POST['settings:order:bill_fname'];}
if (isset($_POST['settings:order:bill_lname']) && $_POST['settings:order:bill_lname'] !== '') {$Billing_Obj['LastName'] = $_POST['settings:order:bill_lname'];}
if (isset($_POST['settings:order:bill_email']) && $_POST['settings:order:bill_email'] !== '') {$Billing_Obj['Email'] = $_POST['settings:order:bill_email'];}
if (isset($_POST['settings:order:bill_phone']) && $_POST['settings:order:bill_phone'] !== '') {$Billing_Obj['Phone'] = $_POST['settings:order:bill_phone'];}
if (isset($_POST['settings:order:bill_fax']) && $_POST['settings:order:bill_fax'] !== '') {$Billing_Obj['Fax'] = $_POST['settings:order:bill_fax'];}
if (isset($_POST['settings:order:bill_comp']) && $_POST['settings:order:bill_comp'] !== '') {$Billing_Obj['Company'] = $_POST['settings:order:bill_comp'];}
if (isset($_POST['settings:order:bill_comp']) && $_POST['settings:order:bill_comp'] !== '') {$Billing_Obj['Name'] = $_POST['settings:order:bill_comp'];}
if (isset($_POST['settings:order:bill_addr']) && $_POST['settings:order:bill_addr'] !== '') {$Billing_Obj['BillingStreet'] = $_POST['settings:order:bill_addr'];}
if (isset($_POST['settings:order:bill_city']) && $_POST['settings:order:bill_city'] !== '') {$Billing_Obj['BillingCity'] = $_POST['settings:order:bill_city'];}
if (isset($_POST['settings:order:bill_state']) && $_POST['settings:order:bill_state'] !== '') {$Billing_Obj['BillingState'] = $_POST['settings:order:bill_state'];}
if (isset($_POST['settings:order:bill_zip']) && $_POST['settings:order:bill_zip'] !== '') {$Billing_Obj['BillingPostalCode'] = $_POST['settings:order:bill_zip'];}
if (isset($_POST['settings:order:bill_cntry']) && $_POST['settings:order:bill_cntry'] !== '') {$Billing_Obj['BillingCountry'] = $_POST['settings:order:bill_cntry'];}

$createResponse = $client->create(array((object) $Billing_Obj), 'Account');

foreach ($createResponse as $account) {
	$Account_Id = $account->getId();
}