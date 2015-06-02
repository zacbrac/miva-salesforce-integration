<?php
if (isset($_POST['settings:order:payment_type']) && $_POST['settings:order:payment_type'] !== '') {$PaymentTerm_Obj['Name'] = $_POST['settings:order:payment_type'];}
if (isset($_POST['settings:order:shipment_carrier']) && $_POST['settings:order:shipment_carrier'] !== '') {$ShipmentCarrier_Obj['Name'] = $_POST['settings:order:shipment_carrier'];}


$createResponse = $client->upsert( 'Name', array((object) $PaymentTerm_Obj), 'fishbookspro__Payment_Term__c');

foreach ($createResponse as $PaymentTerm) {
	$PaymentTerm_Id = $PaymentTerm->getId();
}

$OpportunityUpdate_Obj->fishbookspro__Payment_Terms__c = $PaymentTerm_Id;


$createResponse = $client->upsert( 'Name', array((object) $ShipmentCarrier_Obj), 'fishbookspro__Carrier__c');

foreach ($createResponse as $ShipmentCarrier) {
	$ShipmentCarrier_Id = $ShipmentCarrier->getId();
}

$OpportunityUpdate_Obj->fishbookspro__Carrier__c = $ShipmentCarrier_Id;