<?php
class xmlSicoob {
    function getConfig($chave) {
        //$xml = simplexml_load_file('./_apisafra/webconfig.xml');
        $xml = simplexml_load_file('sicoob.xml');
        $webconfig = "";
        foreach ($xml as $key => $value) {
            if ($key==$chave) {
                $webconfig = $value;
            }
        }
        return base64_decode($webconfig);
    }
}