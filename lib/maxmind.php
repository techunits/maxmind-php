<?php

class MaxMind {
  private $mmConfig;
  public function __construct($licenseKey, $mode = 'standard') {
    $this->mmConfig->licenseKey = $licenseKey;
    $this->mmConfig->serviceType = $mode;
  }
  
  public function setIp($ip) {
    $this->mmConfig->ip = $ip;
    return $this;
  }
  
  public function setLocation($postalCode, $city, $region, $country) {
    $this->mmConfig->postalCode = $postalCode;
    $this->mmConfig->city = urlencode($city);
    $this->mmConfig->region = urlencode($region);
    $this->mmConfig->country = urlencode($country);
    return $this;
  }
  
  private function __executeRequest() {
    $this->response = array();
    $finalResponse = array();
    
    $url = 'https://minfraud.maxmind.com/app/ccv2r?i='.$this->mmConfig->ip.'&postal='.$this->mmConfig->postalCode.'&city='.$this->mmConfig->city.'&region='.$this->mmConfig->region.'&country='.$this->mmConfig->country.'&license_key='.$this->mmConfig->licenseKey.'&requested_type='.$this->mmConfig->serviceType;
    $response = file_get_contents($url);
    if(!empty($response)) {
      $tmpList = explode(';', $response);
      foreach($tmpList as $tmp) {
        $tmp = explode('=', $tmp);
        $finalResponse[$tmp[0]] = $tmp[1];
      }
      $this->response = $finalResponse;
    }
  }
  
  public function execute() {
    $this->__executeRequest();
    return $this;
  }
  
  public function getRiskScore() {
    return $this->response['riskScore'];
  }
}


