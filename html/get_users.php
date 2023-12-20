<?php
/*Security-Level PRIO HIGH*/
//https://stackoverflow.com/questions/7120586/soap-request-in-php-with-curl
//https://www.w3schools.com/php/func_xml_parse_into_struct.asp
$alertnumbers = [];
include("get_access.php");
$soap_action = "http://tempuri.org/IServiceCenterConnectManagerPool/QueryAlertDevices";
$url = "https://service.leitstellenverbund.de/CenterConnectManagerPool/ServiceCenterConnectManagerPool.svc";
$post_string = "";
$post_string = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
                        <s:Body>
				<QueryAlertDevices xmlns="http://tempuri.org/">
            				<session xmlns:a="http://schemas.datacontract.org/2004/07/Cloud.Center.Connect.Essentials.UserManagement" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
                				<a:identity>' . $identity . '</a:identity>
            				</session>
        			</QueryAlertDevices>
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
	 	if($value["tag"] == "A:ALERTADDRESS") {
			array_push($alertnumbers, $value["value"]);
		}
        }
?>
