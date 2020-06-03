<?php


namespace JigDoc\Config;


use Phore\Core\Exception\InvalidDataException;
use Phore\FileSystem\PhoreDirectory;
use Phore\FileSystem\PhoreFile;

class Config
{

    /**
     * The subdirectory jigdoc stores foreign repositories
     *
     * @var string
     */
    public $repo_dir = "jigdoc_repos";

    /**
     * Directory where the output should go
     *
     * @var string
     */
    public $out_dir = "docs";

    /**
     * List of repos to clone
     *
     * @var array
     */
    public $repos = [];



    public function __construct(PhoreFile $configFile)
    {
        foreach ($configFile->get_yaml() as $key => $value) {
            if ( ! isset($this->$key)) {
                throw new InvalidDataException("Unknown section '$key' in '$configFile'");
            }
            $this->$key = $value;
        }

    }


}
