<?php


namespace JigDoc\Cli\Cmd;


use JigDoc\Config\Config;
use JigDoc\Config\Env;
use Phore\Core\Exception\InvalidDataException;

class CloneCmd
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Env
     */
    private $env;

    public function __construct(Env $env)
    {
        $this->env = $env;
        $this->config = $env->config;
    }


    private function cloneRepo($repo) {
        if (preg_match ("/^git@([a-z0-9.-]+):(.*)$/", $repo, $matches)) {
            $repoName = phore_uri($matches[2])->getFilename();
            $httpsCloneUrl = "https://{$matches[1]}/{$matches[2]}";
            $gitCloneUrl = $repo;
        } else {
            throw new InvalidDataException("Invalid repository: '$repo'");
        }

        $path = $this->env->workDir->join($this->config->repo_dir, $repoName);


        if ($path->isDirectory()) {
            phore_exec("git -C ? pull", [$path]);
        } else {
            phore_exec("git clone ? ?", [$httpsCloneUrl, (string)$path]);
            phore_exec("git -C ? remote set-url --add --push origin ?", [$path, $gitCloneUrl]);
        }
    }


    public function cloneAll()
    {
        foreach ($this->config->repos as $repo) {
            $this->cloneRepo($repo);
        }
    }
}
