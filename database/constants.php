<?php

define('ROOT_URL', 'http://localhost/dutrack/');


            
            
            
            
            $base_dir= __DIR__; 

            $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';

            $domain = $_SERVER['SERVER_NAME'];

            $url = "{$protocol}://{$domain}";
            
            
            
            ?>