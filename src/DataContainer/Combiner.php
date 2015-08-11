<?php

namespace Terminal42\CombinerBundle\DataContainer;

class Combiner
{
    /**
     * @param array $row
     *
     * @return string
     */
    public function listRecord($row)
    {
        return $row['name'];
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function validateFiles($value)
    {
        $files = deserialize($value);

        if (!empty($files) && is_array($files)) {
            $combiner = new \Contao\Combiner();

            foreach ($files as $file) {
                $combiner->add($file);
            }
        }

        return $value;
    }
}
