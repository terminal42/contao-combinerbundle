<?php

namespace Terminal42\CombinerBundle;

use Contao\CoreBundle\ContaoFrameworkInterface;
use Terminal42\CombinerBundle\Entity\CombinerEntity;

class FileManager
{
    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;

    /**
     * Combiner constructor.
     *
     * @param ContaoFrameworkInterface $framework
     */
    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
    }

    /**
     * Returns files in the given combiner.
     *
     * @param $id
     *
     * @return array
     */
    public function getFilesInCombiner($id)
    {
        $this->framework->initialize();

        /** @var CombinerEntity $model */
        $model = CombinerEntity::findByPk($id);

        if (null === $model) {
            throw new \UnderflowException(sprintf('Combiner ID %s not found', $id));
        }

        $files = deserialize($model->files);

        if (empty($files) || !is_array($files)) {
            throw new \UnderflowException(sprintf('Combiner ID %s does not have files.', $id));
        }

        return $files;
    }

    /**
     * Returns path to combined file, creating it if necessary.
     *
     * @param int  $id
     * @param bool $useCache
     *
     * @return string
     */
    public function getCombinedFile($id, $useCache = true)
    {
        $this->framework->initialize();

        /** @var CombinerEntity $model */
        $model = CombinerEntity::findByPk($id);

        if (null === $model) {
            throw new \UnderflowException(sprintf('Combiner ID %s not found', $id));
        }

        if ($useCache && !empty($model->cacheFile)) {
            return $model->cacheFile;
        }

        $files = deserialize($model->files);

        if (empty($files) || !is_array($files)) {
            throw new \UnderflowException(sprintf('Combiner ID %s does not have files.', $id));
        }

        return $this->combineFiles($files);
    }

    private function combineFiles(array $files)
    {
        $combiner = new \Contao\Combiner();

        foreach ($files as $file) {
            $combiner->add($file, filemtime(TL_ROOT . '/' . $file));
        }

        $debugMode = \Config::get('debugMode');
        \Config::set('debugMode', false);

        $result = $combiner->getCombinedFile('');

        \Config::set('debugMode', $debugMode);

        return $result;
    }
}
