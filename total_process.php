<?php
require_once dirname(__FILE__) . '/bootstrap.php';
use Phpforce\SoapClient\ClientBuilder;

include "TotalProcess.php";

$builder = new ClientBuilder(SF_WSDL, SF_USERNAME, SF_PASSWORD, SF_SECURITY_TOKEN);
$client = $builder->build();

$process = new TotalProcess($client);