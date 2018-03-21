<?php
//update your voluum username & password on line 21

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");

require_once('vendor/autoload.php');

use PapoMS\VoluumApiWrapper\ConversionClient;

function datetimeFormat($datetime) {
  $strtime = strtotime($datetime);
  $newDT = date('n/d/Y H:i:s', $strtime);
  return $newDT;
}

//voluum query
$vrc = new ConversionClient();
$vrc->login('<<<username>>>', '<<<password>>>');
$conversions = $vrc->getCampaignConversionData($_GET['cid'], 'last-two-days');

$conversionArray = array();
echo 'Parameters:TimeZone=Asia/Bangkok;'."\n";
echo 'Google Click ID,Conversion Name,Conversion Time,Conversion Value,Conversion Currency'."\n";

foreach($conversions['rows'] as $val) {
  $google_click_id = $val['externalId'];
  $conversion_name = "Conversion";
  $conversion_time = datetimeFormat($val['postbackTimestamp']);
  $conversion_val = $val['revenue'];
  $conversion_currency = "USD";
  echo $google_click_id.','.$conversion_name.','.$conversion_time.','.$conversion_val.','.$conversion_currency."\n";
}
