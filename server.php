<?php
var_dump($_SERVER);
$i = 100;
while ($i--) {
\SeasLog::debug('this is a  debug',array('jhg' => 'neeke'));
}
\Lib\Vendor\SeasLog\Log::debug('fkdjfdfkf');