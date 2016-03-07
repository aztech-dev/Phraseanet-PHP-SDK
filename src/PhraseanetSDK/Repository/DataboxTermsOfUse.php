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

class DataboxTermsOfUse extends AbstractRepository
{

    /**
     * Find All the cgus for the choosen databox
     *
     * @param  integer $databoxId The databox id
     * @return ArrayCollection
     */
    public function findByDatabox($databoxId)
    {
        $response = $this->query('GET', sprintf('v1/databoxes/%d/termsOfUse/', $databoxId));

        if (true !== $response->hasProperty('termsOfUse')) {
            throw new BadResponseException('Missing "termsOfuse" property in response content');
        }

        return new ArrayCollection(\PhraseanetSDK\Entity\DataboxTermsOfUse::fromList(
            $response->getProperty('termsOfUse')
        ));
    }
}
