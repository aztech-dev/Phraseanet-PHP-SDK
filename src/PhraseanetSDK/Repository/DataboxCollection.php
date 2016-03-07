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
use Doctrine\Common\Collections\ArrayCollection;
use PhraseanetSDK\Exception\BadResponseException;

class DataboxCollection extends AbstractRepository
{
    /**
     * Find all collection in the provided databox
     *
     * @param  integer $databoxId the databox id
     * @return ArrayCollection|\PhraseanetSDK\Entity\DataboxCollection[]
     */
    public function findByDatabox($databoxId)
    {
        $response = $this->query('GET', sprintf('v1/databoxes/%d/collections/', $databoxId));

        if (true !== $response->hasProperty('collections')) {
            throw new BadResponseException('Missing "collections" property in response content');
        }

        return new ArrayCollection(\PhraseanetSDK\Entity\DataboxCollection::fromList(
            $response->getProperty('collections')
        ));
    }

    /**
     * Finds a collection in all available databoxes
     *
     * @param integer $baseId The base ID of the collection
     * @return DataboxCollection
     */
    public function find($baseId)
    {
        $response = $this->query('GET', sprintf('v1/collections/%d/', $baseId));

        if ($response->hasProperty(('collection')) !== true) {
            throw new BadResponseException('Missing "collection" property in response content');
        }

        return \PhraseanetSDK\Entity\DataboxCollection::fromValue($response->getProperty('collection'));
    }
}
