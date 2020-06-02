<?php


namespace JigDoc\Config;


class Config
{

    public $path = "";

    public $data = [
        "repo_dir" => "jigdoc_repos",
        "repos" => []
    ];


    public function __construct($filename="jigdoc.yml")
    {
        $this->data = array_merge($this->data, phore_file($filename)->get_yaml());

    }


}
