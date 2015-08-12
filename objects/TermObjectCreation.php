<?php

if (isset($_POST['settings:order:payment_type']) && $_POST['settings:order:payment_type'] != '') {

    if (strpos($_POST['settings:order:payment_type'], ':') !== false) {

        $methodData = explode(':',$_POST['settings:order:payment_type']);

        if (strtolower($methodData[1]) == 'amex') {

            $PaymentTerm_Obj['Name'] = 'American Express';

        } else {

            $PaymentTerm_Obj['Name'] = trim(ucfirst(strtolower($methodData[1])));

        }

    } else {

        $PaymentTerm_Obj['Name'] = trim(ucfirst($_POST['settings:order:payment_type']));

    }

}


//Removes typical "Shipping:" Prefix from the shipping method and assigns it to the Shipment Carrier Name
$ShipmentCarrier_Obj['Name'] = (isset($_POST['settings:order:shipment_carrier']) ? trim(str_replace('Shipping:', '', html_entity_decode($_POST['settings:order:shipment_carrier'], ENT_COMPAT, "UTF-8"))) : '' );

if (isset($PaymentTerm_Obj)) {
    
    try {

        $createResponse = $client->upsert( 'Name', array((object) $PaymentTerm_Obj), 'fishbookspro__Payment_Term__c');

    } catch (Exception $e) {

        reportError('Caught exception: TermObjectCreation: ' . $e->getMessage() . "\n information that was trying to submit: " . var_export($PaymentTerm_Obj, true));

    }

    foreach ($createResponse as $PaymentTerm) {
        
        $PaymentTerm_Id = $PaymentTerm->getId();
        
    }

    $OpportunityUpdate_Obj->fishbookspro__Payment_Terms__c = $PaymentTerm_Id;

}

if (isset($ShipmentCarrier_Obj)) {

    try {

        $createResponse = $client->upsert( 'Name', array((object) $ShipmentCarrier_Obj), 'fishbookspro__Carrier__c');

    } catch (Exception $e) {

        reportError('Caught exception: TermObjectCreation: ' . $e->getMessage() . "\n information that was trying to submit: " . var_export($ShipmentCarrier_Obj, true));

    }

    foreach ($createResponse as $ShipmentCarrier) {
        
        $ShipmentCarrier_Id = $ShipmentCarrier->getId();

    }

    $OpportunityUpdate_Obj->fishbookspro__Carrier__c = $ShipmentCarrier_Id;

}
