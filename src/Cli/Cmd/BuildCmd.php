<?php


namespace JigDoc\Cli\Cmd;


use JigDoc\Config\Config;
use JigDoc\Parser\Template;
use Leuffen\TextTemplate\TextTemplate;
use Phore\Core\Exception\InvalidDataException;
use Phore\FileSystem\PhoreUri;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class BuildCmd
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var TextTemplate
     */
    private $template;

    public function __construct(Config $config, LoggerInterface $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->template = new Template();
    }



    public function applyLayout($input, $layout)
    {
        $tpl = phore_file("_layout/" . $layout);
        $p = clone ($this->template);
        $p->loadTemplate($tpl->get_contents());
        return $p->apply(["content" => $input]);
    }



    public function parseFile(PhoreUri $filename)
    {
        $outfile = "{$this->config->data["out_dir"]}/$filename";
        $inFile = $filename->asFile();

        $tpl = clone ($this->template);

        $this->logger->notice("Parsing '$inFile' -> '$outfile'...");
        $parsed = $tpl->parse($inFile);

        if ($tpl->layout !== null) {
            $pd = new \Parsedown();
            $parsed = $this->applyLayout($pd->parse($parsed), $tpl->layout);
            phore_file($outfile)->mkdir()->set_contents($parsed);
        }
        // Ignore other files

    }

    public function parseAll() {
        foreach (phore_dir(".")->genWalk() as $uri) {
            if ( ! $uri->fnmatch("*.md"))
                continue;
            if ( ! $uri->isFile())
                continue;
            if ($uri->isSubpathOf($this->config->data["out_dir"]))
                continue;
            $this->parseFile($uri);
        }
    }
}
