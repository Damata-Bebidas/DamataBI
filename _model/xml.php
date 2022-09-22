<?php
class xml {
    function getConfig() {
        $xml = simplexml_load_file('webconfig.xml');
        $webconfig = array();

        foreach ($xml as $value) {
            foreach ($value as $value2) {
                foreach ($value2 as $key => $value3) {
                    $webconfig[] = $value3;
                }
            }
        }
        return $webconfig;
    }
}