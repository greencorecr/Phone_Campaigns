<?php

/****************************
const LOG_EMERG = 0;
const LOG_ALERT = 1;
const LOG_CRIT = 2;
const LOG_ERR = 3;
const LOG_WARNING = 4;
const LOG_NOTICE = 5;
const LOG_INFO = 6;
const LOG_DEBUG = 7;
******************************/

function logEmerg($data){
    if (DEVELOPMENT) echo ($data."\n");
    else System_Daemon::emerg($data);
}

function logCrit($data){
    if (DEVELOPMENT) echo ($data."\n");
    else System_Daemon::crit($data);
}

function logErr($data){
    if (DEVELOPMENT) echo ($data."\n");
    else System_Daemon::err($data);
}

function logWarning($data){
    if (DEVELOPMENT) echo ($data."\n");
    else System_Daemon::warning($data);
}

function logNotice($data){
    if (DEVELOPMENT) echo ($data."\n");
    else System_Daemon::notice($data);
}

function logInfo($data){
    if (DEVELOPMENT) echo ($data."\n");
    else System_Daemon::info($data);
}

function logDebug($data){
    if (DEVELOPMENT) echo ($data."\n");
    else System_Daemon::debug($data);
}
