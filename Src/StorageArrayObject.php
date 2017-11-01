<?php
/**
 * MIT License
 *
 * Copyright (c) 2017, Pentagonal
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace Pentagonal\ArrayStore;

/**
 * Class StorageArrayObject
 * @package Pentagonal\ArrayStore
 */
class StorageArrayObject extends \ArrayObject implements StorageInterface
{
    /**
     * StorageArrayObject constructor.
     *
     * @param array $input
     */
    public function __construct($input = [])
    {
        parent::__construct($input);
    }

    /**
     * {@inheritdoc}
     */
    public function exist($offset) : bool
    {
        return array_key_exists($offset, $this->toArray());
    }

    /**
     * {@inheritdoc}
     * @return mixed|null null of offset does not exists
     */
    public function get($offset)
    {
        return array_key_exists($offset, $this->toArray())
            ? $this->toArray()[$offset]
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function set($offset, $value)
    {
        $this[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($offset)
    {
        unset($this[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function merge(array $values)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @param bool $strict [optional] If the third parameter strict is set to true
     *                     then the array_search function will also check the types of the
     *                     given data
     * {@inheritdoc}
     */
    public function indexOf($toSearch, bool $strict = null)
    {
        $args = [
            $toSearch,
            $this->toArray()
        ];
        if (is_bool($strict)) {
            $args[] = $strict;
        }

        return call_user_func_array('array_search', $args);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return (array) $this;
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function jsonSerialize() : array
    {
        return $this->toArray();
    }
}
