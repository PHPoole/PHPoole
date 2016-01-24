<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Test;

use PHPoole\PHPoole;
use PHPoole\Plugin\Example;
use Symfony\Component\Filesystem\Filesystem;

class PHPooleBuild extends \PHPUnit_Framework_TestCase
{
    protected $wsSourceDir;
    protected $wsDestinationDir;

    public function setUp()
    {
        $this->wsSourceDir = __DIR__.'/fixtures/website';
        $this->wsDestinationDir = $this->wsSourceDir;
    }

    public function tearDown()
    {
        $fs = new Filesystem();
        $fs->remove($this->wsDestinationDir.'/_site');
        $fs->remove($this->wsDestinationDir.'/layouts/_cache');
    }

    public function testBuid()
    {
        PHPoole::create(
            $this->wsSourceDir,
            null,
            [
                'site' => [
                    'menu' => [
                        'main' => [
                            'about' => [
                                'id'        => 'about',
                                'disabled'  => true,
                            ],
                            'test' => [
                                'id'        => 'test',
                                'name'      => 'Test',
                                'url'       => 'test',
                                'weight'    => 999,
                            ],
                        ],
                    ],
                ],
                'paginate' => 'disabled', // disable pagination
            ]
        )->addPlugin(new Example()) // add a plugin
        ->build();
    }
}
