<?php
class xmlSafra {
    function getConfig($chave) {
        //$xml = simplexml_load_file('./_apisafra/webconfig.xml');
        $xml = simplexml_load_file('safra.xml');
        $webconfig = "";
        foreach ($xml as $key => $value) {
            if ($key==$chave) {
                $webconfig = $value;
            }
        }
        return base64_decode($webconfig);
    }
}