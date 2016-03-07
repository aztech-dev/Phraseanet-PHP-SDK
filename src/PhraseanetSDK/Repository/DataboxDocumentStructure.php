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

class DataboxDocumentStructure extends AbstractRepository
{
    /**
     * Find All structure document of the desired databox
     *
     * @param  integer $databoxId The databox id
     * @return ArrayCollection
     */
    public function findByDatabox($databoxId)
    {
        $response = $this->query('GET', sprintf('v1/databoxes/%d/metadatas/', $databoxId));

        if (true !== $response->hasProperty('document_metadatas')) {
            throw new BadResponseException('Missing "document_metadatas_structure" property in response content');
        }

        return new ArrayCollection(\PhraseanetSDK\Entity\DataboxDocumentStructure::fromList(
            $response->getProperty('document_metadatas')
        ));
    }
}
