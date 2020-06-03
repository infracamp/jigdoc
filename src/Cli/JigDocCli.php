<?php


namespace JigDoc\Cli;


use JigDoc\Cli\Cmd\BuildCmd;
use JigDoc\Cli\Cmd\CloneCmd;
use JigDoc\Config\Config;
use JigDoc\Config\Env;
use Phore\CliTools\Helper\GetOptResult;
use Phore\CliTools\PhoreAbstractCli;

class JigDocCli extends PhoreAbstractCli
{
    public function __construct()
    {
        parent::__construct("JigDoc", __DIR__ . "/../src/helpfile.txt", "hC:");
    }

    protected function main(array $argv, int $argc, GetOptResult $opts)
    {

        if (empty($opts->argv())) {
            $this->printHelp();
            exit;
        }

        $workDir = $opts->getPathAbs("C", getcwd());
        $env = new Env($workDir);
        $env->parseConfig();

        switch ($opts->argv()[0]) {
            case "update":
                $c = new CloneCmd($env);
                $c->cloneAll();
                break;

            case "build":
                $c = new BuildCmd($env, $this->log);
                $c->parseAll();
                break;


        }

    }
}
