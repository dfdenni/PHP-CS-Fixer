<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\CS\DocBlock;

/**
 * This represents a line of a docblock.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class Line
{
    /**
     * The content of this line.
     *
     * @var string
     */
    private $content;

    /**
     * Create a new line instance.
     *
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Get the content of this line.
     *
     * @return int
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Does this line contain useful content?
     *
     * If the line contains text or tags, then this is true.
     *
     * @return bool
     */
    public function containsUsefulContent()
    {
        return 0 !== preg_match('/\\*\s*\S+/', $this->content) && !$this->isTheStart() && !$this->isTheEnd();
    }

    /**
     * Does the line contain a tag?
     *
     * If this is true, then it must be the first line of an annotation.
     *
     * @return bool
     */
    public function containsATag()
    {
        return 0 !== preg_match('/\\*\s*@/', $this->content);
    }

    /**
     * Is the line the start of a docblock?
     *
     * @return bool
     */
    public function isTheStart()
    {
        return false !== strpos($this->content, '/**');
    }

    /**
     * Is the line the end of a docblock?
     *
     * @return bool
     */
    public function isTheEnd()
    {
        return false !== strpos($this->content, '*/');
    }

    /**
     * Set the content of this line.
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Remove this line by clearing its contents.
     *
     * Note that this method technically brakes the internal state of the
     * docblock, but is useful when we need to retain the indexes of lines
     * during the execution of an algorithm.
     */
    public function remove()
    {
        $this->content = '';
    }

    /**
     * Append a blank docblock line to this line's contents.
     *
     * Note that this method technically brakes the internal state of the
     * docblock, but is useful when we need to retain the indexes of lines
     * during the execution of an algorithm.
     */
    public function addBlank()
    {
        preg_match_all('/\ *\*/', $this->content, $matches);

        $this->content .= $matches[0][0]."\n";
    }

    /**
     * Get the string representation of object.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->content;
    }
}
