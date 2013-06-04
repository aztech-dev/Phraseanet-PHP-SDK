<?php

/*
 * This file is part of Phraseanet SDK.
 *
 * (c) Alchemy <info@alchemy.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhraseanetSDK\Entity;

use PhraseanetSDK\EntityManager;

abstract class AbstractEntity
{
    /**
     *
     * @var EntityManager
     */
    protected $em;

    final public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
