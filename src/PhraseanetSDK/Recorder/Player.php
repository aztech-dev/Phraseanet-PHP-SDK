<?php

/*
 * This file is part of Phraseanet SDK.
 *
 * (c) Alchemy <info@alchemy.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhraseanetSDK\Recorder;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use PhraseanetSDK\ApplicationInterface;
use PhraseanetSDK\Client\Client;
use PhraseanetSDK\Recorder\Storage\StorageInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Player
{
    const USER_AGENT = 'Phraseanet SDK Player';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var StorageInterface
     */
    private $storage;

    public function __construct(Client $client, StorageInterface $storage)
    {
        $this->client = $client;
        $this->storage = $storage;
    }

    public function play(OutputInterface $output = null)
    {
        $data = $this->storage->fetch();

        foreach ($data as $request) {
            $this->output(sprintf(
                "--> Executing request %s %s",
                $request['method'],
                $request['path']
            ), $output);

            $start = microtime(true);
            $error = null;

            try {
                $this->client->call($this->buildRequest($request));
            } catch (TransferException $e) {
                $error = $e;
            }

            $duration = microtime(true) - $start;

            if (null !== $error) {
                $this->output(sprintf(
                    "    Query <error>failed</error> : %s.\n",
                    $error->getMessage()
                ), $output);
            } else {
                $this->output(sprintf(
                    "    Query took <comment>%f</comment>.\n",
                    $duration
                ), $output);
            }
        }
    }

    private function buildRequest($requestData)
    {
        $uri = new Uri($requestData['path']);

        foreach($requestData['query'] as $name => $query) {
            $uri = Uri::withQueryValue($uri, $name, $query);
        }

        return new Request(
            $requestData['method'],
            $uri,
            ['User-Agent' => sprintf('%s/%s', self::USER_AGENT, ApplicationInterface::VERSION)],
            $requestData['post-fields']
        );
    }

    private function output($message, OutputInterface $output = null)
    {
        if (null !== $output) {
            $output->writeln($message);
        }
    }
}
