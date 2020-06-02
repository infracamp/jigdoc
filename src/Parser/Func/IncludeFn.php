<?php


namespace JigDoc\Parser\Func;


use JigDoc\Parser\Template;
use Leuffen\TextTemplate\TextTemplate;

class IncludeFn
{


    public function __invoke($paramArr, $command, $context, $cmdParam, Template $template)
    {
        print_r ($paramArr);
        $path = $template->fileName->getDirname()->withRelativePath($paramArr["file"])->asFile();

        $tpl = clone $template;
        return $tpl->parse($path);


    }
}
