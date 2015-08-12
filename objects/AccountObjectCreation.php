<?php

$Billing_Obj = array();

$Billing_Obj['FirstName'] = (isset($_POST['settings:order:bill_fname']) ? $_POST['settings:order:bill_fname'] : '');
$Billing_Obj['LastName'] = (isset($_POST['settings:order:bill_lname']) ? $_POST['settings:order:bill_lname'] : '');
$Billing_Obj['Email'] = (isset($_POST['settings:order:bill_email']) ? $_POST['settings:order:bill_email'] : '');
$Billing_Obj['Phone'] = (isset($_POST['settings:order:bill_phone']) ? $_POST['settings:order:bill_phone'] : '');
$Billing_Obj['Fax'] = (isset($_POST['settings:order:bill_fax']) ? $_POST['settings:order:bill_fax'] : '');
$Billing_Obj['BillingStreet'] = (isset($_POST['settings:order:bill_addr']) ? $_POST['settings:order:bill_addr'] : '');
$Billing_Obj['BillingCity'] = (isset($_POST['settings:order:bill_city']) ? $_POST['settings:order:bill_city'] : '');
$Billing_Obj['BillingState'] = (isset($_POST['settings:order:bill_state']) ? $_POST['settings:order:bill_state'] : '');
$Billing_Obj['BillingPostalCode'] = (isset($_POST['settings:order:bill_zip']) ? $_POST['settings:order:bill_zip'] : '');
$Billing_Obj['BillingCountry'] = (isset($_POST['settings:order:bill_cntry']) ? $_POST['settings:order:bill_cntry'] : '');

$Billing_Obj['Name'] = $Billing_Obj['Company'] = (isset($_POST['settings:order:bill_comp']) && $_POST['settings:order:bill_comp'] !== '' ? $_POST['settings:order:bill_comp'] : $_POST['settings:order:bill_fname'] . ' ' . $_POST['settings:order:bill_lname'] );

$Billing_Obj['Company_Id__c'] = hash('sha256', $Billing_Obj['Company'] .
    ' ' . $Billing_Obj['BillingStreet'] .
    ' ' . $Billing_Obj['BillingStreet'] .
    ' ' . $Billing_Obj['BillingCity'] .
    ' ' . $Billing_Obj['BillingState'] .
    ' ' . $Billing_Obj['BillingCountry'] .
    ' ' . $Billing_Obj['BillingPostalCode']
);

$Billing_Obj['API_Generated__c'] = true;

if (isset($logged_in)) {
    
    try {
        
        $createResponse = $client->upsert('Company_Id__c', array((object) $Billing_Obj), 'Account');

    } catch (Exception $e) {

        reportError('Caught exception: AccountObjectCreation: Upsert: ' . $e->getMessage() . "\n information that was trying to submit: " . var_export($Billing_Obj, true));

    }

} else {
    
    try {

        $createResponse = $client->create(array((object) $Billing_Obj), 'Account');
        
    } catch (Exception $e) {

        reportError('Caught exception: AccountObjectCreation: Create: ' . $e->getMessage() . "\n information that was trying to submit: " . var_export($Billing_Obj, true));
        
    }

}

foreach ($createResponse as $account) {
    
    $Account_Id = $account->getId();
    
}
