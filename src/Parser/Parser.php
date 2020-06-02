<?php


namespace JigDoc\Parser;


use Phore\FileSystem\PhoreUri;

class Parser
{

    /**
     * @var Template
     */
    private $template;

    private $layouts = [];

    public function __construct()
    {
        $this->template = new Template();
    }



}
