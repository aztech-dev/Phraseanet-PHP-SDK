<?php

namespace PhraseanetSDK\Repository;

use PhraseanetSDK\Tools\Repository\RepositoryAbstract;
use PhraseanetSDK\Exception\ApiRequestException;
use Doctrine\Common\Collections\ArrayCollection;

class Feed extends RepositoryAbstract
{

    public function findById($id)
    {
        $collection = $this->findAll()->filter(function($el)
                {
                    if ($el->getId() == $id)
                    {
                        return true;
                    }
                });

        if ($collection->count() === 0)
        {
            
        }
    }

    public function findAll()
    {
        $response = $this->getClient()->call('/feeds/list/', array(), 'GET');

        $feedCollection = new ArrayCollection();

        if ($response->isOk())
        {
            foreach ($response->getResult()->feeds as $feedDatas)
            {
                $feed = Hydrator::hydrate($this->em->getEntity('feed'), $feedDatas);

                $feedCollection->add($feed);
            }
        }
        return $feedCollection;
    }

}
