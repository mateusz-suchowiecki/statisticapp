<?php

$appId = 'xaxa';


$message = new StatisticApp\StatisticMessage($appId);
$message->prepare("userKKKK")->send();