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
 * Class StorageArray
 * @package Pentagonal\ArrayStore
 */
class StorageArray implements StorageInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * StorageArrayObject constructor.
     *
     * @param array $input
    */
    public function __construct($input = [])
    {
        $this->merge($input);
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
        $this->data[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($offset)
    {
        unset($this->data[$offset]);
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
        return $this->data;
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function jsonSerialize() : array
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function serialize() : string
    {
        return serialize($this->data);
    }

    /**
     * @param string $serialized
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        if (!is_string($serialized)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%1$s::%2$s() expects parameter 1 to be string, %3$s given',
                    get_class($this),
                    __METHOD__,
                    gettype($serialized)
                ),
                E_WARNING
            );
        }

        $unSerialized = @unserialize($serialized);
        if (!is_array($unSerialized)) {
            throw new \UnexpectedValueException(
                'Serialized values is not a valid array',
                E_ERROR
            );
        }

        if (is_array($unSerialized)) {
            $this->data = $unSerialized;
        }
    }

    /**
     * {@inheritdoc}
     * @return \Traversable
     */
    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset) : bool
    {
        return isset($this->toArray()[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function count() : int
    {
        return count($this->toArray());
    }
}
