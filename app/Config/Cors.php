<?php

namespace Config;

class Cors
{
    public $allowedOrigins = ['*'];
    public $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];
    public $allowedHeaders = ['Content-Type', 'Authorization', 'X-API-Key'];
    public $maxAge = 86400;
    public $allowCredentials = false;
}