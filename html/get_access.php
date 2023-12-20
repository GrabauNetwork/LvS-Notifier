<?php
/*Security-Level PRIO HIGH*/
//https://stackoverflow.com/questions/7120586/soap-request-in-php-with-curl
include("external.php");
include("config.php");
$soap_action = "http://tempuri.org/IServiceCenterConnectControllerPool/SessionLogOn";
$url = "https://service.leitstellenverbund.de/CenterConnectControllerPool/ServiceCenterConnectControllerPool.svc";

$identity = "";


$post_string = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
			<s:Body>
			<SessionLogOn xmlns="http://tempuri.org/">
				<logOnData xmlns:a="http://schemas.datacontract.org/2004/07/Cloud.Center.Connect.Essentials.UserManagement"
					xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
					<a:clientIdentity>' . $mandant . '</a:clientIdentity>
					<a:sessionLifetimeInMinutes>30</a:sessionLifetimeInMinutes>
					<a:userLogOnName>' . $username . '</a:userLogOnName>
					<a:userPassword>' . $password . '</a:userPassword>
				</logOnData>
			</SessionLogOn>
			</s:Body>
		</s:Envelope>';

$header = array(
                 "Content-type: text/xml;charset=\"utf-8\"",
                 "Accept: text/xml",
                 "Cache-Control: no-cache",
                 "Pragma: no-cache",
                 "SOAPAction: " . $soap_action,
                 "Content-length: " . strlen($post_string),
);


 // PHP cURL  for https connection with auth
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_TIMEOUT, 10);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string); // the SOAP request
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

     // converting
     $response = curl_exec($ch); 
     curl_close($ch);

	$xmlparser = xml_parser_create();
	// Parse XML data into an array
	xml_parse_into_struct($xmlparser,$response,$values);

	xml_parser_free($xmlparser);
	foreach($values as $value) {
	if($value["tag"] == "A:IDENTITY") {
		$identity = $value["value"];
	}
	}

echo $identity;

?>

