<?php


namespace JigDoc\Cli;


use JigDoc\Cli\Cmd\BuildCmd;
use JigDoc\Cli\Cmd\CloneCmd;
use JigDoc\Config\Config;
use Phore\CliTools\Helper\GetOptResult;
use Phore\CliTools\PhoreAbstractCli;

class JigDocCli extends PhoreAbstractCli
{
    public function __construct()
    {
        parent::__construct("JigDoc", __DIR__ . "/../src/helpfile.txt", "h");
    }

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

            case "build":
                $c = new BuildCmd($config, $this->log);
                $c->parseAll();
                break;


        }

    }
}
