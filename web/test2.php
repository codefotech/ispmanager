<?php
$oltIp = '103.190.85.1:7171';
$oltCommunity = 'public';
$oltOID = '1.3.6.1.2.1.1.1.0'; // Example OID to retrieve system description

// Create a new SNMP session
$session = new SNMP(SNMP::VERSION_2C, $oltIp, $oltCommunity);

// Retrieve system description using SNMP get
$systemDescription = $session->get($oltOID);

// Print the retrieved information
echo "System Description: $systemDescription\n";

// Close the SNMP session
$session->close();
?>
