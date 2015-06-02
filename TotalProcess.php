<?php
/**
 * TotalProcess
 */
class TotalProcess {

	function __construct($client) {
		
		if ( isset($_POST['settings:logged_in']) && $_POST['settings:logged_in'] === 'true' ) {
			$logged_in = true;
		}

		$Billing_Obj = array();
		$Shipping_Obj = array();
		$different_info = false;
		//TESTING
		include 'post_vars.php';

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
		$leadConvertResponse = $client->convertLead($leadConvertArray);

		//GET OPPORTUNITY ID FROM LEAD CONVERT
		$OpportunityUpdate_Obj = new stdClass();
		
		foreach ($leadConvertResponse as $key => $convertedLead) {
			$Opportunity_Id = $convertedLead->opportunityId;
		}

		$OpportunityUpdate_Obj->Id = $Opportunity_Id;
		$OpportunityUpdate_Obj->API_Generated__c = true;
		

		//CREATE/UPDATE PRODUCTS AND REFERENCE THEM TO CREATED OPPORTUNITY
		include 'objects/ProductObjectCreation.php';

		//CREATE/UPDATE Shipping Carrier and Payment Terms AND REFERENCE THEM TO CREATED OPPORTUNITY
		include 'objects/TermObjectCreation.php';

		$OpportunityUpdateResponse = $client->update(array($OpportunityUpdate_Obj), 'Opportunity');
		
		var_dump($OpportunityUpdateResponse);
	}
}