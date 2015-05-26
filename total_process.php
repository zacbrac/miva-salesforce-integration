<?php
require_once dirname(__FILE__) . '/bootstrap.php';
use Phpforce\SoapClient\ClientBuilder;

$builder = new ClientBuilder(SF_WSDL, SF_USERNAME, SF_PASSWORD, SF_SECURITY_TOKEN);

$client = $builder->build();

$Billing_Obj = array();
$Shipping_Obj = array();
$different_info = false;
// TESTING
include 'post_vars.php';

// CREATE LEAD
include 'objects/LeadObjectCreation.php';

// IF BILL TO INFO AND SHIP TO INFO ARE ALL THE SAME
// THEN CONVERT THE LEAD USING THE BILL TO INFO

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
		//CREATE AN ACCOUNT AND A CONTACT, THEN CONVERT THE LEAD THAT WAS CREATED WHILE REFERENCING THE CREATED ACCOUNT AND CONTACT
		include 'objects/AccountObjectCreation.php';
		include 'objects/ContactObjectCreation.php';

		if (isset($Account_Id)) {$leadConvert->accountId = $Account_Id;}
		if (isset($Contact_Id)) {$leadConvert->contactId = $Contact_Id;}
	}

}

$leadConvertArray = array($leadConvert);
$leadConvertResponse = $client->convertLead($leadConvertArray);
var_dump($leadConvertResponse);

include 'objects/ProductObjectCreation.php';

//GET Opportunity id from lead convert
$OpportunityUpdateObj = new stdClass();
foreach ($leadConvertResponse as $key => $convertedLead) {
	$opportunityId = $convertedLead->opportunityId;
}

$OpportunityUpdateObj->Id = $opportunityId;
$OpportunityUpdateObj->API_Generated__c = true;
$OpportunityUpdateResponse = $client->update(array($OpportunityUpdateObj), 'Opportunity');

// var_dump($OpportunityUpdateResponse);
