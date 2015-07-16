<?php
namespace RemoteMethod;
class RemoteMethodClient {
    
    private $url = '';
    private $header = false;
     
    function getUrl() {
        return $this->url;
    }

    function setUrl($url) {
        $this->url = $url;
    }
    
    function getHeader() {
        return $this->header;
    }

    function setHeader($header) {
        $this->header = $header;
    }

    public function callRemoteMethod($methodName){
        $args = func_get_args();
        $params = serialize($args);
        $mr = new Request\MakeRequest();
        return unserialize($mr->runRequest($this->url, $params, $this->header));
    }
}
