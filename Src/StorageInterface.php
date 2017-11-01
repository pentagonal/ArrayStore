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

namespace Pentagonal\ArrayStore;

/**
 * Interface StorageInterface
 * @package Pentagonal\ArrayStore
 */
interface StorageInterface extends \ArrayAccess, \JsonSerializable, \Serializable, \Countable, \IteratorAggregate
{
    /**
     * Check if offset exists @uses array_key_exists()
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function exist($offset) : bool;

    /**
     * Get value by offset
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function get($offset);

    /**
     * Set offset value
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function set($offset, $value);

    /**
     * Remove value by offset
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function remove($offset);

    /**
     * Merge data
     *
     * @param array $values
     *
     * @return void
     */
    public function merge(array $values);

    /**
     * Search offset by values @uses array_search()
     *
     * @param mixed $toSearch
     *
     * @return int|string|false the key for needle if it is found in the array record
     */
    public function indexOf($toSearch);

    /**
     * Get all data
     *
     * @return array
     */
    public function toArray() : array;
}
