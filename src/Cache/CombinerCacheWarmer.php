<?php

namespace Terminal42\CombinerBundle\Cache;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Terminal42\CombinerBundle\FileManager;

class CombinerCacheWarmer implements CacheWarmerInterface
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * @var FileManager
     */
    private $combiner;

    /**
     * Constructor.
     *
     * @param Connection  $db The Doctrine connection
     * @param FileManager $combiner
     */
    public function __construct(Connection $db, FileManager $combiner)
    {
        $this->db       = $db;
        $this->combiner = $combiner;
    }

    /**
     * {@inheritdoc}
     */
    public function warmUp($cacheDir)
    {
        $ids = $this->db
            ->executeQuery("SELECT id FROM tl_combiner")
            ->fetchAll(\PDO::FETCH_COLUMN)
        ;

        foreach ($ids as $id) {
            $this->db->update(
                'tl_combiner',
                [
                    'cacheFile' => $this->combiner->getCombinedFile($id, false)
                ],
                [
                    'id' => $id
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isOptional()
    {
        return true;
    }
}
