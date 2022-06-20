<?php

namespace Devpaulopaixao\LaravelTools\Helpers;

class Domain
{

    protected $url;
    protected $domain;
    protected $schema;

    public function __construct()
    {
        $this->url    = $this->getUrl();
        $this->domain = $this->getDomain();
        $this->schema = $this->getSchema();
    }

    private function getUrl()
    {
        return env('APP_URL');
    }

    private function getSchema()
    {
        return preg_replace('/:.*$/', '', $this->url);
    }

    private function getDomain()
    {
		return env('APP_DOMAIN');
		
		// return env('APP_DOMAIN');
        // return preg_replace('/^http[s]?:\/\/[\w]{3}\./', '', $this->url);
    }

    public function prefixDomain($prefix)
    {
		return 'http://'.$prefix.'.'.$this->domain;
		
        //return $this->schema.'://'.$prefix.'.'.$this->domain;
    }

}