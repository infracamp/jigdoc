<?php


namespace JigDoc\Parser\Func;


use JigDoc\Parser\Template;

class JigDocFn
{
    public function __invoke($paramArr, $command, $context, $cmdParam, Template $template)
    {
        if (isset ($paramArr["layout"]))
            $template->layout = $paramArr["layout"];
    }
}
