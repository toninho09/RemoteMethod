<?php
namespace RemoteMethod\Request;
class MakeRequest{

    public function runRequest($url, $body = '',$header = false) {
        if (ini_get('allow_url_fopen')) {
            return $this->streamRequest($url, $body,$header);
        } else {
            return $this->curlRequest($url, $body,$header);
        }
    }

    private function streamRequest($url, $body,$headers) {
        $header = "Content-Length: " . strlen($body) . "\r\n"
                ."Content-Type: text/plain\r\n";
        if(!empty($headers)){
            foreach ($headers as $value) {
                $header .= $value ."\r\n";
            }
        }
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header'=> $header,
                'content' => $body
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    private function curlRequest($url, $body,$headers = false) {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$body);
        if(!empty($headers)){
            if(is_array($headers)){
                curl_setopt($curl, CURLOPT_HTTPHEADER,$headers ); 
            }
        }
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
    
}