<?php


namespace JigDoc\Parser;


use Leuffen\TextTemplate\TextTemplate;

class ParsableFile extends TextTemplate
{

    public function __construct($text = "")
    {
        parent::__construct($text);
        $this->setOpenCloseTagChars("<!--", "-->");
    }

}
