<?php


namespace JigDoc\Cli;


use JigDoc\Cli\Cmd\CloneCmd;
use JigDoc\Config\Config;
use Phore\CliTools\Helper\GetOptResult;
use Phore\CliTools\PhoreAbstractCli;

class JigDocCli extends PhoreAbstractCli
{

    protected function main(array $argv, int $argc, GetOptResult $opts)
    {
        $config = new Config();

        if (empty($opts->argv())) {
            $this->printHelp();
            exit;
        }

        switch ($opts->argv()[0]) {
            case "update":
                $c = new CloneCmd($config);
                $c->cloneAll();
                break;



        }

    }
}
