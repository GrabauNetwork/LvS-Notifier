<?php
/*Security-Level PRIO HIGH*/
//https://stackoverflow.com/questions/7120586/soap-request-in-php-with-curl
include("get_users.php");

$post_string = "";
$soap_action = "http://tempuri.org/IServiceCenterConnectMobileAlertDevicePool/SessionSendAlertToDevice";
$url = "https://service.leitstellenverbund.de/CenterConnectMobileAlertDevicePool/ServiceCenterConnectMobileAlertDevicePool.svc";

$mobilestring = "";
$mobilestring = $mobilestring . "<a:MobileAlertDeviceIdentitySender>
                                        <a:alertAddress>" . $single_number . "</a:alertAddress>
                                        <a:clientIdentity>" . $mandant . "</a:clientIdentity>
                                </a:MobileAlertDeviceIdentitySender>";


$post_string = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
			<s:Body>
		<SessionSendAlertToDevice xmlns="http://tempuri.org/">
			<session xmlns:a="http://schemas.datacontract.org/2004/07/Cloud.Center.Connect.Essentials.UserManagement"
				xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
				<a:identity>' . $identity . '</a:identity>
			</session>
			<identities
				xmlns:a="http://schemas.datacontract.org/2004/07/Cloud.Center.Connect.Essentials.MobileAlertDevice"
				xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
				'. $mobilestring .'
			</identities>
			<telegram
				xmlns:a="http://schemas.datacontract.org/2004/07/Cloud.Center.Connect.Essentials.MobileAlertDevice"
				xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
				<a:alertColor xmlns:b="http://schemas.datacontract.org/2004/07/Cloud.Center.Connect.Essentials">
					<b:blue>0</b:blue>
					<b:green>1</b:green>
					<b:opacity>1</b:opacity>
					<b:red>0</b:red>
				</a:alertColor>
				<a:alertText>Probealarmierung</a:alertText>
				<a:alertTimeUtc>' . $datact . '</a:alertTimeUtc>
				<a:caption>' . $ueberschrift .'</a:caption>
				<a:catchwordName>' . $stichwort . '</a:catchwordName>
				<a:description>' . $beschreibung . '</a:description>
				<a:expiryTimestampUtc>' . $datact . '</a:expiryTimestampUtc>
				<a:identity>
					<a:alarmContextIdentity>' . generateRandom(16) . '</a:alarmContextIdentity>
					<a:alarmJobIdentity>' . generateRandom(16) . '</a:alarmJobIdentity>
				</a:identity>
				<a:incidentTypeName />
				<a:isIncidentFinished>false</a:isIncidentFinished>
				<a:isTrigger>true</a:isTrigger>
				<a:notificationType>PracticeAlert</a:notificationType>
				<a:telegramType>None</a:telegramType>
				<a:telegramWayModification>None</a:telegramWayModification>
				<a:whereAddress i:nil="true" />
				<a:wherePosition i:nil="true" />
			</telegram>
		</SessionSendAlertToDevice>
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

     echo $response;

?>
