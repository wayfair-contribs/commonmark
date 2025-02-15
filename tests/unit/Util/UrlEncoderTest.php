<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (https://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Tests\Unit\Util;

use League\CommonMark\Util\UrlEncoder;
use PHPUnit\Framework\TestCase;

class UrlEncoderTest extends TestCase
{
    /**
     * @dataProvider unescapeAndEncodeTestProvider
     */
    public function testUnescapeAndEncode($input, $expected)
    {
        $this->assertEquals($expected, UrlEncoder::unescapeAndEncode($input));
    }

    public function unescapeAndEncodeTestProvider()
    {
        return [
            ['(foo)', '(foo)'],
            ['/my uri', '/my%20uri'],
            ['`', '%60'],
            ['~', '~'],
            ['!', '!'],
            ['@', '@'],
            ['#', '#'],
            ['$', '$'],
            ['%', '%25'],
            ['^', '%5E'],
            ['&', '&'],
            ['*', '*'],
            ['(', '('],
            [')', ')'],
            ['-', '-'],
            ['_', '_'],
            ['=', '='],
            ['+', '+'],
            ['{', '%7B'],
            ['}', '%7D'],
            ['[', '%5B'],
            [']', '%5D'],
            ['\\', '%5C'],
            ['|', '%7C'],
            [';', ';'],
            ['\'', '\''],
            [':', ':'],
            ['"', '%22'],
            [',', ','],
            ['.', '.'],
            ['/', '/'],
            ['<', '%3C'],
            ['>', '%3E'],
            ['?', '?'],
            ['%21', '!'],
            ['%23', '%23'],
            ['%24', '%24'],
            ['%26', '%26'],
            ['%27', "'"],
            ['%2A', '*'],
            ['%2B', '%2B'],
            ['%2C', '%2C'],
            ['%2D', '-'],
            ['%2E', '.'],
            ['%2F', '%2F'],
            ['%3A', '%3A'],
            ['%3B', '%3B'],
            ['%3D', '%3D'],
            ['%3F', '%3F'],
            ['%40', '%40'],
            ['%5F', '_'],
            ['%7E', '~'],
            ['java%0ascript:alert("XSS")', 'java%0Ascript:alert(%22XSS%22)'],
            ['java%0Ascript:alert("XSS")', 'java%0Ascript:alert(%22XSS%22)'],
            ["java\nscript:alert('XSS')", "java%0Ascript:alert('XSS')"],
            // Note that the following test does decode '&amp;colon;' to '&colon', but this does not impact rendering, which re-encodes that '&' elsewhere
            ['javascript&amp;colon;alert%28&#039;XSS&#039;%29', 'javascript&colon;alert(&#039;XSS&#039;)'],
            ['https://en.wikipedia.org/wiki/Markdown#CommonMark', 'https://en.wikipedia.org/wiki/Markdown#CommonMark'],
            ['https://img.shields.io/badge/help-%23hoaproject-ff0066.svg', 'https://img.shields.io/badge/help-%23hoaproject-ff0066.svg'],
            ['http://example.com/a%62%63%2fd%3Fe', 'http://example.com/abc%2Fd%3Fe'],
            ['http://ko.wikipedia.org/wiki/위키백과:대문', 'http://ko.wikipedia.org/wiki/%EC%9C%84%ED%82%A4%EB%B0%B1%EA%B3%BC:%EB%8C%80%EB%AC%B8'],
            ['http://ko.wikipedia.org/wiki/%EC%9C%84%ED%82%A4%EB%B0%B1%EA%B3%BC:%EB%8C%80%EB%AC%B8', 'http://ko.wikipedia.org/wiki/%EC%9C%84%ED%82%A4%EB%B0%B1%EA%B3%BC:%EB%8C%80%EB%AC%B8'],
        ];
    }
}
