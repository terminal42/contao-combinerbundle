<?php

namespace Terminal42\CombinerBundle\EventListener;

use Contao\Combiner;
use Contao\LayoutModel;
use Contao\PageModel;
use Terminal42\CombinerBundle\FileManager;

class DynamicScriptTagsListener
{
    /**
     * @var FileManager
     */
    private $combiner;

    /**
     * Constructor.
     *
     * @param FileManager $combiner
     */
    public function __construct(FileManager $combiner)
    {
        $this->combiner = $combiner;
    }

    public function replaceGlobals()
    {
        $this->removeFiles($GLOBALS['TL_JAVASCRIPT']);
        $this->removeFiles($GLOBALS['TL_CSS']);

        $this->addCombinedFiles();
    }

    private function addCombinedFiles()
    {
        $ids = $this->getCombinersInLayout();

        foreach ($ids as $id) {
            $file = $this->combiner->getCombinedFile($id);
            $type = strrchr($file, '.');

            if (Combiner::CSS === $type) {
                $GLOBALS['TL_CSS'][] = $file;
            } elseif (Combiner::JS === $type) {
                $GLOBALS['TL_JAVASCRIPT'][] = $file;
            }
        }
    }

    private function removeFiles(&$files)
    {
        if (empty($files) || !is_array($files)) {
            return;
        }

        $ids = $this->getCombinersInLayout();

        foreach ($ids as $id) {
            $files = array_diff($files, $this->combiner->getFilesInCombiner($id));
        }
    }

    private function getCombinersInLayout()
    {
        static $ids;

        if (null === $ids) {
            /** @var PageModel $objPage */
            global $objPage;

            if (null === $objPage) {
                return [];
            }

            /** @var LayoutModel|object $layout */
            $layout = $objPage->getRelated('layout');

            $ids = deserialize($layout->combiners);

            if (!is_array($ids)) {
                $ids = [];
            }
        }

        return $ids;
    }
}
