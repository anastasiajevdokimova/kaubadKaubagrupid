<?php
$parool='123456';
$sool='tavalinetext';
$krypt=crypt($parool, $sool);
echo $krypt;