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

namespace Pentagonal\ArrayStore\PhpUnit;

use Pentagonal\ArrayStore\StorageArray;
use PHPUnit\Framework\TestCase;

/**
 * Class StorageArrayTest
 * @package Pentagonal\ArrayStore\PhpUnit
 */
class StorageArrayTest extends TestCase
{
    /**
     * @var array
     */
    protected $dataArray = [
        'offsetIndex 0',
        'KeyStored' => 'offsetIndex KeyStored',
        'KeyStoredArray' => [
            'offsetIndex KeyStored'
        ],
    ];

    public function testImplementationStorageFromStorageInterface()
    {
        $storage = new StorageArray($this->dataArray);

        $this->assertNotEmpty(
            $storage->toArray()
        );

        $this->assertEquals(
            $this->dataArray,
            $storage->toArray()
        );

        $this->assertEquals(
            $storage->jsonSerialize(),
            $storage->toArray()
        );

        $this->assertEquals(
            $this->dataArray[0],
            $storage->get(0)
        );

        $this->assertEquals(
            $storage->get('KeyStored'),
            $storage['KeyStored']
        );
        /**
         * Countable
         */
        $this->assertCount(
            count($storage->toArray()),
            $storage
        );

        $this->assertFalse(
            $storage->exist('unknownKey')
        );

        $this->assertFalse(
            isset($storage['unknownKey'])
        );

        $this->assertTrue(
            $storage->exist('KeyStored')
        );

        $this->assertNull(
            $storage->get('unknownKey'),
            null
        );

        $this->assertNotEquals(
            serialize($storage->toArray()),
            serialize($storage)
        );

        $this->assertEquals(
            unserialize(serialize($storage)),
            $storage
        );

        $this->assertEquals(
            json_encode($storage),
            json_encode($storage->toArray())
        );

        $this->assertEquals(
            'KeyStoredArray',
            $storage->indexOf(
                $this->dataArray['KeyStoredArray'],
                true
            )
        );

        $this->assertNull(
            $storage->remove('KeyStored')
        );
        $this->assertNull(
            $storage->set('KeyStored', 'New Value')
        );
        $storage['KeyStored'] = $this->dataArray['KeyStored'];
        $this->assertEquals(
            $storage->get('KeyStored'),
            $this->dataArray['KeyStored']
        );

        unset($storage['KeyStored']);
        $this->assertFalse(
            $storage->exist('KeyStored')
        );

        $this->assertInstanceOf(
            \ArrayIterator::class,
            $storage->getIterator()
        );

        $array = $storage->toArray();
        // add inheritance
        $storage[] = 'Inheritance';
        $this->assertNotEquals(
            $array,
            $storage->toArray()
        );
    }

    public function testExceptionsFromArrayStorageSerialize()
    {
        $storage = new StorageArray($this->dataArray);
        try {
            // test invalid unserialize argument
            $storage->unserialize(['invalid data type']);
        } catch (\Throwable $e) {
            $this->assertInstanceOf(
                \InvalidArgumentException::class,
                $e
            );
        }
        try {
            $storage->unserialize(serialize(new \stdClass()));
        } catch (\Throwable $e) {
            $this->assertInstanceOf(
                \UnexpectedValueException::class,
                $e
            );
        }
    }
}
