<?php

namespace Terminal42\CombinerBundle\Cache;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

class CombinerCacheClearer implements CacheClearerInterface
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * Constructor.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function clear($cacheDir)
    {
        $this->db->query("UPDATE tl_combiner SET cacheFile=''");
    }
}
