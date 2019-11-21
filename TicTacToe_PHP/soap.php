<?php

    $wsdl = "http://localhost:8080/TTTWebApplication/TTTWebService?WSDL";

    try {

        // create connection with web services
        $proxy = new SoapClient($wsdl, 
                array(
                    'trace' => true,
                    'exceptions' => true
                ));

    } catch (Exception $ex) {

        echo $ex->getMessage();
    }