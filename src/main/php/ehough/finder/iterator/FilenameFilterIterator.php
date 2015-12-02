<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ehough_finder_iterator_FilenameFilterIterator filters files by patterns (a regexp, a glob, or a string).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ehough_finder_iterator_FilenameFilterIterator extends ehough_finder_iterator_MultiplePcreFilterIterator
{
    /**
     * Filters the iterator values.
     *
     * @return bool true if the value should be kept, false otherwise
     */
    public function accept()
    {
        return $this->isAccepted($this->current()->getFilename());
    }

    /**
     * Converts glob to regexp.
     *
     * PCRE patterns are left unchanged.
     * ehough_finder_expression_Glob strings are transformed with ehough_finder_expression_Glob::toRegex().
     *
     * @param string $str Pattern: glob or regexp
     *
     * @return string regexp corresponding to a given glob or regexp
     */
    protected function toRegex($str)
    {
        return $this->isRegex($str) ? $str : ehough_finder_Glob::toRegex($str);
    }
}
