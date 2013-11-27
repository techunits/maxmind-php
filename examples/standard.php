<?php

    $mmObj = new MaxMind ( MAXMIND_LICENSE_KEY, 'standard' );
    $mmObj->setIp ( $_SERVER ['REMOTE_ADDR'] )
            ->setLocation ( $_POST ['zipcode'], $_POST ['city'], $_POST ['city'], $_POST ['country'] )
            ->execute ();
    
    $riskScore = $mmObj->getRiskScore ();

    print $riskScore;
    exit();