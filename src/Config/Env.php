<?php


namespace JigDoc\Config;


class Env
{
    /**
     * @var \Phore\FileSystem\PhoreDirectory
     */
    public $workDir;

    /**
     * @var \Phore\FileSystem\PhoreDirectory
     */
    public $outDir;

    /**
     * @var \Phore\FileSystem\PhoreDirectory
     */
    public $layoutDir;

    /**
     * @var \Phore\FileSystem\PhoreFile
     */
    public $configFile;


    /**
     * The config data
     *
     * @var Config
     */
    public $config;

    public function __construct($rootDir=null, $outDir=null)
    {
        if ($rootDir === null)
            $rootDir = getcwd();
        $this->workDir = phore_dir($rootDir);
        $this->configFile = $this->workDir->join("jigdoc.yml")->asFile();
        $this->layoutDir = $this->workDir->join("_layouts")->asDirectory();

        if ($outDir === null)
            $outDir = phore_dir(getcwd())->join("docs")->asDirectory();

        $this->outDir = $outDir;

    }


    public function parseConfig() {
        $this->config = new Config($this->configFile);
    }
}
