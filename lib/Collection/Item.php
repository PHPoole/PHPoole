<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Collection;

/**
 * Class Item
 * @package PHPoole\Collection
 */
abstract class Item implements ItemInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * Constructor
     *
     * @param null $id
     */
    public function __construct($id = null)
    {
        if (empty($id)) {
            $this->id = spl_object_hash($this);
        } else {
            $this->id = $id;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }
}