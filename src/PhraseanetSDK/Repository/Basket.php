<?php

/*
 * This file is part of Phraseanet SDK.
 *
 * (c) Alchemy <info@alchemy.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhraseanetSDK\Repository;

use PhraseanetSDK\AbstractRepository;
use PhraseanetSDK\Exception\BadResponseException;
use Doctrine\Common\Collections\ArrayCollection;

class Basket extends AbstractRepository
{
    /**
     * Find all baskets that contains the provided record
     *
     * @param  integer $databoxId The record databox id
     * @param  integer $recordId The record id
     * @return ArrayCollection
     */
    public function findByRecord($databoxId, $recordId)
    {
        $response = $this->query('GET', sprintf('v1/records/%d/%d/related/', $databoxId, $recordId));

        if (true !== $response->hasProperty('baskets')) {
            throw new BadResponseException('Missing "baskets" property in response content');
        }

        return new ArrayCollection(\PhraseanetSDK\Entity\Basket::fromList($response->getProperty('baskets')));
    }

    /**
     * Find all baskets
     *
     * @return ArrayCollection
     */
    public function findAll()
    {
        $response = $this->query('GET', 'v1/baskets/list/');

        if (true !== $response->hasProperty('baskets')) {
            throw new BadResponseException('Missing "baskets" property in response content');
        }

        return new ArrayCollection(\PhraseanetSDK\Entity\Basket::fromList($response->getProperty('baskets')));
    }
}
