<?php
/*
 -SCENARIO
    The server provides HTTP access to trace/log files of the previous day following the structure:
    http://server/traces/2016-04-18/file001.trace
    The file names range from 001 to 999, but not all may exist.
    The directory contains other files with different extensions.

 -TO DO
    Create a script to crawl the trace files of the previous day, save them inside a local directory, rename all files to .log extension and compress all files inside a zip file. The other files available in the server may have huge size(1GB+), so they MUST not be downloaded to save bandwidth.
    Errors must be logged.

 -TOOLS
    CLient: Linux machine without CURL or wget, only PHP 5.3+ available.

 */


use LogCrawler\Tracer\Tracer as Tracer;
use LogCrawler\Crawler\Crawler as Crawler;

require_once 'app/start.php';

//$tracer = new Tracer();
$crawler = new Crawler();
