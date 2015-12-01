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
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ehough_finder_expression_Glob implements ehough_finder_expression_ValueInterface
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function renderPattern()
    {
        return $this->pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return ehough_finder_expression_Expression::TYPE_GLOB;
    }

    /**
     * {@inheritdoc}
     */
    public function isCaseSensitive()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function prepend($expr)
    {
        $this->pattern = $expr.$this->pattern;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function append($expr)
    {
        $this->pattern .= $expr;

        return $this;
    }

    /**
     * Tests if glob is expandable ("*.{a,b}" syntax).
     *
     * @return bool
     */
    public function isExpandable()
    {
        return false !== strpos($this->pattern, '{')
            && false !== strpos($this->pattern, '}');
    }

    /**
     * @param bool $strictLeadingDot
     * @param bool $strictWildcardSlash
     *
     * @return ehough_finder_expression_Regex
     */
    public function toRegex($strictLeadingDot = true, $strictWildcardSlash = true)
    {
        $regex = ehough_finder_Glob::toRegex($this->pattern, $strictLeadingDot, $strictWildcardSlash, '');

        return new ehough_finder_expression_Regex($regex);
    }
}
