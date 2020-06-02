<?php


namespace JigDoc\Parser;


use JigDoc\Parser\Func\IncludeFn;
use JigDoc\Parser\Func\JigDocFn;
use Leuffen\TextTemplate\TextTemplate;
use Phore\FileSystem\PhoreFile;

class Template extends TextTemplate
{

    /**
     * @var PhoreFile
     */
    public $fileName;

    /**
     * The layout to use to render this page
     *
     * @var null|string
     */
    public $layout = null;

    public function __construct($text = "")
    {
        parent::__construct($text);
        $this->setOpenCloseTagChars("<!--", "-->");
        $this->setDefaultFilter("raw");
        $this->addFunction("include", new IncludeFn());
        $this->addFunction("jigdoc", new JigDocFn());
    }

    /**
     * Parse a single file and return the content
     *
     * @param PhoreFile $file
     * @return string
     * @throws \Leuffen\TextTemplate\TemplateParsingException
     * @throws \Phore\FileSystem\Exception\FileAccessException
     * @throws \Phore\FileSystem\Exception\FileNotFoundException
     */
    public function parse(PhoreFile $file) : string {
        $this->fileName = $file;
        $this->loadTemplate($file->get_contents());
        return $this->apply([]);
    }

}
