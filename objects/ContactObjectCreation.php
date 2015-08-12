<?php

$Shipping_Obj = array();

$Shipping_Obj['FirstName'] = ( isset($_POST['settings:order:ship_fname']) ? $_POST['settings:order:ship_fname'] : '' );
$Shipping_Obj['LastName'] = ( isset($_POST['settings:order:ship_lname']) ? $_POST['settings:order:ship_lname'] : '' );
$Shipping_Obj['Email'] = ( isset($_POST['settings:order:ship_email']) ? $_POST['settings:order:ship_email'] : '' );
$Shipping_Obj['Phone'] = ( isset($_POST['settings:order:ship_phone']) ? $_POST['settings:order:ship_phone'] : '' );
$Shipping_Obj['Fax'] = ( isset($_POST['settings:order:ship_fax']) ? $_POST['settings:order:ship_fax'] : '' );
$Shipping_Obj['Company'] = ( isset($_POST['settings:order:ship_comp']) ? $_POST['settings:order:ship_comp'] : '' );
$Shipping_Obj['MailingStreet'] = ( isset($_POST['settings:order:ship_addr']) ? $_POST['settings:order:ship_addr'] : '' );
$Shipping_Obj['MailingCity'] = ( isset($_POST['settings:order:ship_city']) ? $_POST['settings:order:ship_city'] : '' );
$Shipping_Obj['MailingState'] = ( isset($_POST['settings:order:ship_state']) ? $_POST['settings:order:ship_state'] : '' );
$Shipping_Obj['MailingPostalCode'] = ( isset($_POST['settings:order:ship_zip']) ? $_POST['settings:order:ship_zip'] : '' );
$Shipping_Obj['MailingCountry'] = ( isset($_POST['settings:order:ship_cntry']) ? $_POST['settings:order:ship_cntry'] : '' );


$Shipping_Obj['AccountId'] = ( isset($Account_Id) ? $Account_Id : '' );

$Shipping_Obj['Contact_Id__c'] = ( isset($_POST['settings:order:ship_comp']) ? $_POST['settings:order:ship_email'] : '' );

$Shipping_Obj['API_Generated__c'] = true;


if (isset($logged_in) && $logged_in == true) {

    try {

        $createResponse = $client->upsert('Contact_Id__c', array((object) $Shipping_Obj), 'Contact');

    } catch (Exception $e) {

        reportError('Caught exception: ContactObjectCreation: ' . $e->getMessage() . "\n information that was trying to submit: " . var_export($Shipping_Obj, true));

    }

} else {

    try {

        $createResponse = $client->create(array((object) $Shipping_Obj), 'Contact');

    } catch (Exception $e) {

        reportError('Caught exception: ContactObjectCreation: ' . $e->getMessage() . "\n information that was trying to submit: " . var_export($Shipping_Obj, true));
        
    }

}

foreach ($createResponse as $response) {
    
    $Contact_Id = $response->getId();
    
}
