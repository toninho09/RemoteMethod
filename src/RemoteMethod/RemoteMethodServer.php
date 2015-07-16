<?php

namespace RemoteMethod;

class RemoteMethodServer {

    private function runNameFunction($function, $match) {
        preg_match("/(\w+)@(\w+)/", $function, $funcParams);
        unset($funcParams[0]);
        if (count($funcParams) != 2) {
            throw new \Exception("Method call is not 'CLASS@METHOD' ");
        }
        if (class_exists($funcParams[1])) {
            $class = new $funcParams[1]();
            if (method_exists($class, $funcParams[2])) {
                return call_user_func_array([$class, $funcParams[2]], $match);
            } else {
                throw new \Exception('Method ' . $funcParams[2] . ' Not Found');
            }
        } else {
            throw new \Exception('Class ' . $funcParams[1] . ' Not Found');
        }
    }

    private function runFunction($function, $match = []) {
        if (is_callable($function)) {
            return call_user_func_array($function, $match);
        } elseif (is_string($function)) {
            return $this->runNameFunction($function, $match);
        } else {
            throw new \Exception("The method not is callable or a valid function name.");
        }
    }

    public function run() {
        $content = file_get_contents('php://input');
        $content = unserialize($content);
        $function = array_shift($content);
        echo serialize($this->runFunction($function,$content));
    }

}
