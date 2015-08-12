<?php
require_once dirname(__FILE__) . '/bootstrap.php';
include 'functions.php';

use Phpforce\SoapClient\ClientBuilder;

$builder = new ClientBuilder(SF_WSDL, SF_USERNAME, SF_PASSWORD, SF_SECURITY_TOKEN);
$client = $builder->build();

$logged_in = (isset($_POST['settings:logged_in']) ? true : false );

$order_number = ( isset($_POST['settings:order:id']) ? $_POST['settings:order:id'] : false );

$Shipping_Obj = $Billing_Obj = array();

$different_info = false;

//CREATE LEAD
include 'objects/LeadObjectCreation.php';

//IF BILL TO INFO AND SHIP TO INFO ARE ALL THE SAME
//THEN CONVERT THE LEAD USING THE BILL TO INFO

$CloseDate = new DateTime('America/New_York');

if (isset($Lead_Id)) {
    
    $leadConvert = new stdClass;
    $leadConvert->convertedStatus = 'Converted';
    $leadConvert->doNotCreateOpportunity = false;
    $leadConvert->leadId = $Lead_Id;
    $leadConvert->CloseDate = $CloseDate->format('m/d/Y H:i:s');
    $leadConvert->overwriteLeadSource = false;
    $leadConvert->sendNotificationEmail = true;

    if ($different_info === true) {
        
        //CREATE AN ACCOUNT AND A CONTACT
        include 'objects/AccountObjectCreation.php';
        include 'objects/ContactObjectCreation.php';

        if (isset($Account_Id)) {$leadConvert->accountId = $Account_Id;}
        if (isset($Contact_Id)) {$leadConvert->contactId = $Contact_Id;}

    }

}

//THEN CONVERT THE LEAD THAT WAS CREATED WHILE REFERENCING THE CREATED ACCOUNT AND CONTACT
$leadConvertArray = array($leadConvert);

try {

    $leadConvertResponse = $client->convertLead($leadConvertArray);

} catch (Exception $e) {

    reportError('Caught exception: total_process: $leadConvertResponse ' . $e->getMessage() . "\n information that was trying to submit: " . var_export($leadConvertResponse, true));

}

//GET OPPORTUNITY ID FROM LEAD CONVERT

foreach ($leadConvertResponse as $key => $convertedLead) {

    $Opportunity_Id = $convertedLead->opportunityId;

}

$OpportunityUpdate_Obj = new stdClass();
$OpportunityUpdate_Obj->Id = $Opportunity_Id;
$OpportunityUpdate_Obj->API_Generated__c = true;

if ($order_number != false) {
    $OpportunityUpdate_Obj->fishbookspro__Customer_PO__c = $order_number;
}

//CREATE/UPDATE PRODUCTS AND REFERENCE THEM TO CREATED OPPORTUNITY
include 'objects/ProductObjectCreation.php';
include 'objects/PriceBookEntryObjectCreation.php';

//CREATE OpportunityLineItem AND REFERENCE THEM TO CREATED OPPORTUNITY
include 'objects/OpportunityLineItemObjectCreation.php';

//CREATE/UPDATE Shipping Carrier and Payment Terms AND REFERENCE THEM TO CREATED OPPORTUNITY
include 'objects/TermObjectCreation.php';

$OpportunityUpdateResponse = $client->update(array($OpportunityUpdate_Obj), 'Opportunity');
