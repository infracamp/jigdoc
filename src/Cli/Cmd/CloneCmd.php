<?php


namespace JigDoc\Cli\Cmd;


use JigDoc\Config\Config;
use Phore\Core\Exception\InvalidDataException;

class CloneCmd
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }


    private function cloneRepo($repo) {
        if (preg_match ("/^git@([a-z0-9.-]+):(.*)$/", $repo, $matches)) {
            $repoName = phore_uri($matches[2])->getFilename();
            $httpsCloneUrl = "https://{$matches[1]}/{$matches[2]}";
            $gitCloneUrl = $repo;
        } else {
            throw new InvalidDataException("Invalid repository: '$repo'");
        }

        $path = phore_dir($this->config->data["repo_dir"] . "/" . $repoName);


        if ($path->isDirectory()) {
            phore_exec("git -C ? pull", [$path]);
        } else {
            phore_exec("git clone ? ?", [$httpsCloneUrl, (string)$path]);
            phore_exec("git -C ? remote set-url --add --push origin ?", [$path, $gitCloneUrl]);
        }
    }


    public function cloneAll()
    {
        foreach ($this->config->data["repos"] as $repo) {
            $this->cloneRepo($repo);
        }
    }
}
