<?php

namespace PHPoole\Renderer;

use MatthiasMullie\Minify;

/**
 * Class TwigExtensionMinify.
 */
class TwigExtensionMinify extends \Twig_Extension
{
    /* @var string */
    protected $destPath;

    /**
     * Constructor.
     *
     * @param string $destPath
     */
    public function __construct($destPath)
    {
        $this->destPath = $destPath;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'minify';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('minify', [$this, 'minify']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        $filters = [
            new \Twig_SimpleFilter('minifyCSS', [$this, 'minifyCss']),
            new \Twig_SimpleFilter('minifyJS', [$this, 'minifyJs']),
        ];

        return $filters;
    }

    /**
     * Minify a CSS or a JS file.
     *
     * @param string $path
     *
     * @throws \Exception
     *
     * @return string
     */
    public function minify($path)
    {
        $filePath = $this->destPath.'/'.$path;
        if (is_file($filePath)) {
            $extension = (new \SplFileInfo($filePath))->getExtension();
            switch ($extension) {
                case 'css':
                    $minifier = new Minify\CSS($filePath);
                    break;
                case 'js':
                    $minifier = new Minify\JS($filePath);
                    break;
                default:
                    throw new \Exception(sprintf("File '%s' should be a '.css' or a '.js'!", $path));
            }
            $minifier->minify($filePath);

            return $path;
        }
        throw new \Exception(sprintf("File '%s' doesn't exist!", $path));
    }

    public function minifyCss($value)
    {
        $minifier = new Minify\CSS($value);

        return $minifier->minify();
    }

    public function minifyJs($value)
    {
        $minifier = new Minify\JS($value);

        return $minifier->minify();
    }
}
