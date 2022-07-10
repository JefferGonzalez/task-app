<?php

namespace App\Models;
require(__DIR__.'/../../vendor/autoload.php');

use Dotenv\Dotenv;
use Dotenv\Environment\DotenvFactory;
use Dotenv\Environment\Adapter\EnvConstAdapter;
use Dotenv\Environment\Adapter\ServerConstAdapter;
use Exception;

final class GeneralFunctions
{
    /**
     * @param array $requiredVars
     * @param array $integerVars
     */
    static function loadEnv (array $requiredVars = [], array $integerVars = []){
        try {
            $factory = new DotenvFactory([new EnvConstAdapter(), new ServerConstAdapter()]);
            $dotenv = Dotenv::create(__DIR__ ."/../../",null,$factory);
            $dotenv->load();
            $dotenv->required($requiredVars)->notEmpty();
            $dotenv->required($integerVars)->isInteger();
            return true;
        }catch (Exception $re){
            throw new \RuntimeException($re->getMessage());
        }
    }
}