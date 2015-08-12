<?php

// SHIP TO INFO
$Shipping_Obj['FirstName'] = ( isset($_POST['settings:order:ship_fname']) ? $_POST['settings:order:ship_fname'] : '' );
$Shipping_Obj['LastName'] = ( isset($_POST['settings:order:ship_lname']) ? $_POST['settings:order:ship_lname'] : '' );
$Shipping_Obj['Email'] = ( isset($_POST['settings:order:ship_email']) ? $_POST['settings:order:ship_email'] : '' );
$Shipping_Obj['Phone'] = ( isset($_POST['settings:order:ship_phone']) ? $_POST['settings:order:ship_phone'] : '' );
$Shipping_Obj['Fax'] = ( isset($_POST['settings:order:ship_fax']) ? $_POST['settings:order:ship_fax'] : '' );
$Shipping_Obj['Street'] = ( isset($_POST['settings:order:ship_addr']) ? $_POST['settings:order:ship_addr'] : '' );
$Shipping_Obj['City'] = ( isset($_POST['settings:order:ship_city']) ? $_POST['settings:order:ship_city'] : '' );
$Shipping_Obj['State'] = ( isset($_POST['settings:order:ship_state']) ? $_POST['settings:order:ship_state'] : '' );
$Shipping_Obj['PostalCode'] = ( isset($_POST['settings:order:ship_zip']) ? $_POST['settings:order:ship_zip'] : '' );
$Shipping_Obj['Country'] = ( isset($_POST['settings:order:ship_cntry']) ? $_POST['settings:order:ship_cntry'] : '' );

$Shipping_Obj['Company'] = (isset($_POST['settings:order:ship_comp']) ? $_POST['settings:order:ship_comp'] : $_POST['settings:order:ship_fname'] . ' ' . $_POST['settings:order:ship_lname'] );

$Shipping_Obj['Company_Id__c'] = hash('sha256', $Shipping_Obj['Company'] .
    ' ' . $Shipping_Obj['Street'] .
    ' ' . $Shipping_Obj['City'] .
    ' ' . $Shipping_Obj['State'] .
    ' ' . $Shipping_Obj['Country'] .
    ' ' . $Shipping_Obj['PostalCode']
);


// BILL TO INFO
$Billing_Obj['FirstName'] = (isset($_POST['settings:order:bill_fname']) ? $_POST['settings:order:bill_fname'] : '');
$Billing_Obj['LastName'] = (isset($_POST['settings:order:bill_lname']) ? $_POST['settings:order:bill_lname'] : '');
$Billing_Obj['Email'] = (isset($_POST['settings:order:bill_email']) ? $_POST['settings:order:bill_email'] : '');
$Billing_Obj['Phone'] = (isset($_POST['settings:order:bill_phone']) ? $_POST['settings:order:bill_phone'] : '');
$Billing_Obj['Fax'] = (isset($_POST['settings:order:bill_fax']) ? $_POST['settings:order:bill_fax'] : '');
$Billing_Obj['Street'] = (isset($_POST['settings:order:bill_addr']) ? $_POST['settings:order:bill_addr'] : '');
$Billing_Obj['City'] = (isset($_POST['settings:order:bill_city']) ? $_POST['settings:order:bill_city'] : '');
$Billing_Obj['State'] = (isset($_POST['settings:order:bill_state']) ? $_POST['settings:order:bill_state'] : '');
$Billing_Obj['PostalCode'] = (isset($_POST['settings:order:bill_zip']) ? $_POST['settings:order:bill_zip'] : '');
$Billing_Obj['Country'] = (isset($_POST['settings:order:bill_cntry']) ? $_POST['settings:order:bill_cntry'] : '');

$Billing_Obj['Company'] = (isset($_POST['settings:order:bill_comp']) && trim($_POST['settings:order:bill_comp']) != '' ? $_POST['settings:order:bill_comp'] : $_POST['settings:order:bill_fname'] . ' ' . $_POST['settings:order:bill_lname'] );

$Billing_Obj['Company_Id__c'] = hash('sha256', $Billing_Obj['Company'] .
    ' ' . $Billing_Obj['Street'] .
    ' ' . $Billing_Obj['City'] .
    ' ' . $Billing_Obj['State'] .
    ' ' . $Billing_Obj['Country'] .
    ' ' . $Billing_Obj['PostalCode']
);

$Billing_Obj['LeadSource'] = 'Miva';

$Billing_Obj['API_Generated__c'] = true;


if (
        $Billing_Obj['FirstName'] != $Shipping_Obj['FirstName'] || 
        $Billing_Obj['LastName'] != $Shipping_Obj['LastName'] || 
        $Billing_Obj['Email'] != $Shipping_Obj['Email'] || 
        $Billing_Obj['Phone'] != $Shipping_Obj['Phone'] || 
        $Billing_Obj['Company'] != $Shipping_Obj['Company'] || 
        $Billing_Obj['Street'] != $Shipping_Obj['Street'] || 
        $Billing_Obj['City'] != $Shipping_Obj['City'] || 
        $Billing_Obj['State'] != $Shipping_Obj['State'] || 
        $Billing_Obj['PostalCode'] != $Shipping_Obj['PostalCode'] || 
        $Billing_Obj['Country'] != $Shipping_Obj['Country']
    ) {
    
    $different_info = true;

}

if ($logged_in === true) {

    try {
        
        $createResponse = $client->upsert('Company_Id__c', array((object) $Billing_Obj), 'Lead');

    } catch (Exception $e) {
    
        reportError('Caught exception: LeadObjectCreation: Upsert: ' . $e->getMessage() . "\n information that was trying to submit: " . var_export($Billing_Obj, true));

    }

} else {

    try {

        $createResponse = $client->create(array((object) $Billing_Obj), 'Lead');

    } catch (Exception $e) {

        if (preg_match('/SFSSDupeCatcher/',$e->getMessage())) {

            reportError('Caught exception: LeadObjectCreation: Create: Duplicate record: ' . var_export($createResponse, true));

        } else { 

            reportError('Lead Conversion Failed: Caught Fatal Exception: LeadObjectCreation: Create: ' . $e->getMessage() . "\n information that was trying to submit: " . var_export($Billing_Obj, true));
            
            die;

        }

    }

}

foreach ($createResponse as $lead) {
 
    $Lead_Id = $lead->getId();

}
