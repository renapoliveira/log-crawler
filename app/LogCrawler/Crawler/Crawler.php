<?php namespace LogCrawler\Crawler;

class Crawler
{
    private $url;
    private $dir;
    private $yesterday;
    private $dirFull;
    private $filesToDownload;

    public function __construct($url, $dir)
    {
        $this->url = $url;
        $this->dir = $dir;
        $this->yesterday = date("Y-m-d", time() - 60 * 60 * 24);
        $this->dirFull = $this->dir.$this->yesterday. "/";
        $this->filesToDownload = array();
    }

    private function checkUrlExists( $file )
    {
        $headers = get_headers( $this->url.$this->yesterday."/".$file );
        return stripos($headers[0], "200 OK") ? true : false;
    }

    private function setLocalName($name)
    {
        return str_replace("trace","log",$name);
    }

    public function checkPermission()
    {
        if( ! is_writable($this->dir)){
        }
    }

    public function createDir()
    {
        if( ! file_exists($this->dirFull) ){
            mkdir($this->dirFull);
        }
    }

    public function checkFiles()
    {
        for($i = 1; $i <= 999; $i++){
            if($this->checkUrlExists("file".str_pad($i, 3, 0, STR_PAD_LEFT).".trace")){
                $this->filesToDownload[] = "file".str_pad($i, 3, 0, STR_PAD_LEFT).".trace";
            }
        }
    }

    public function downloadFiles()
    {
        foreach($this->filesToDownload as $f){
            $url = $this->url.$this->yesterday."/".$f;
            file_put_contents($this->dirFull.$this->setLocalName($f), fopen($url, 'r'));
        }
    }

    /**
     *
     *  To access global class ZipArchive, use \ZipArchive
     */
    public function compressFiles()
    {
        $zip = new \ZipArchive;
        if ($zip->open($this->dirFull."compressed_logs.zip", \ZIPARCHIVE::CREATE) === TRUE) {
            foreach($this->filesToDownload as $f){
                $zip->addFile($this->dirFull.$this->setLocalName($f));
            }
            $zip->close();
        }
    }
}
