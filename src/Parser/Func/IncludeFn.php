<?php


namespace JigDoc\Parser\Func;


use JigDoc\Parser\Template;
use Leuffen\TextTemplate\TextTemplate;
use Phore\FileSystem\Exception\FileNotFoundException;

class IncludeFn
{


    public function __invoke($paramArr, $command, $context, $cmdParam, Template $template)
    {
        $path = $template->fileName->getDirname()->withRelativePath($paramArr["file"])->asFile();

        if ( ! $path->isFile())
            throw new FileNotFoundException("Include file '$path' not found. (Referenced by '{$template->fileName}')");
        $tpl = clone $template;
        $tpl->fileName = $path;
        return $tpl->parse($path);


    }
}
