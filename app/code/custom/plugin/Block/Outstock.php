<?php 

namespace Namespace\Module\Block;

class Outstock extends \Magento\Swatches\Block\Product\Renderer\Configurable
{

    public function getAllowProducts()
    {
        $YourAPIKey='1c3c98a2-ace2-11e7-94da-0200cd936042';
$From="RKHOME";
$To="9629344731";
$TemplateName="OrderSuccess";
$VAR1="uba";
$VAR2="123456";

### DO NOT Change anything below this line
$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
$url = "https://2factor.in/API/V1/$YourAPIKey/ADDON_SERVICES/SEND/TSMS"; 
$ch = curl_init(); 
curl_setopt($ch,CURLOPT_URL,$url); 
curl_setopt($ch,CURLOPT_POST,true); 
curl_setopt($ch,CURLOPT_POSTFIELDS,"TemplateName=$TemplateName&From=$From&To=$To&VAR1=$VAR1&VAR2=$VAR2&VAR3=$VAR3&VAR4=$VAR4&VAR5=$VAR5"); 
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
echo curl_exec($ch); 
curl_close($ch);
    }


}