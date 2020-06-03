<?php


namespace JigDoc\Cli\Cmd;


use JigDoc\Config\Config;
use JigDoc\Config\Env;
use JigDoc\Parser\Template;
use Leuffen\TextTemplate\TextTemplate;
use Phore\Core\Exception\InvalidDataException;
use Phore\FileSystem\PhoreUri;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class BuildCmd
{

    /**
     * @var Env
     */
    private $env;

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

    public function __construct(Env $env, LoggerInterface $logger)
    {
        $this->env = $env;
        $this->config = $env->config;
        $this->logger = $logger;
        $this->template = new Template();
    }



    public function applyLayout($input, $layout)
    {
        $tpl = $this->env->layoutDir->join($layout)->asFile();
        $p = clone ($this->template);
        $p->loadTemplate($tpl->get_contents());
        $p->fileName = $tpl;
        return $p->apply(["content" => $input]);
    }



    public function parseFile(PhoreUri $filename)
    {
        $relFileName = $filename->rel($this->env->workDir)->asFile();


        $outfile = $this->env->workDir->join($this->config->out_dir, $relFileName);
        if ($outfile->getExtension() === "md")
            $outfile = $outfile->getDirname()->withFileName($outfile->getFilename(), "html");

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
        foreach ($this->env->workDir->genWalk() as $uri) {
            if ( ! $uri->fnmatch("*.md"))
                continue;
            if ( ! $uri->isFile())
                continue;
            if ($uri->isSubpathOf($this->env->outDir))
                continue;
            $this->parseFile($uri);
        }
    }
}
