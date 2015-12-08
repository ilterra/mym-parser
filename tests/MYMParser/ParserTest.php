<?php

/*
 * This file is part of the MYMParser package.
 *
 * (c) Alberto Terragni <alberto.terragni@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ninjabachelor\MYMParser\Tests;

use Ninjabachelor\MYMParser\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Ninjabachelor\MYMParser\Parser::parse
     * @expectedException \InvalidArgumentException
     */
    public function testParseThrowsExceptionIfSourceIsNotAString()
    {
        Parser::parse(123);
    }

    /**
     * @param string $source Markdown source document
     * @param array $expectedParseResult Expected result after parsing
     *
     * @covers Ninjabachelor\MYMParser\Parser::parse
     * @dataProvider providerParse
     */
    public function testGetMetadataReturnsCorrectMetadata($source, $expectedParseResult)
    {
        $this->assertEquals($expectedParseResult, Parser::parse($source));
    }

    /**
     * @covers Ninjabachelor\MYMParser\Parser::parse
     * @expectedException \Symfony\Component\Yaml\Exception\ParseException
     */
    public function testGetMetadataThrowsExceptionIfWrongYAMLSyntax()
    {
        $source = file_get_contents(__DIR__.'/fixtures/document-07.markdown');
        Parser::parse($source);
    }

    /**
     * @return array Each element is a two-element array with source from markdown document and relative expected parsing result
     */
    public function providerParse()
    {
        $source01 = file_get_contents(__DIR__.'/fixtures/document-01.markdown');
        $source02 = file_get_contents(__DIR__.'/fixtures/document-02.markdown');
        $source03 = file_get_contents(__DIR__.'/fixtures/document-03.markdown');
        $source04 = file_get_contents(__DIR__.'/fixtures/document-04.markdown');
        $source05 = file_get_contents(__DIR__.'/fixtures/document-05.markdown');
        $source06 = file_get_contents(__DIR__.'/fixtures/document-06.markdown');

        return array(
            array($source01, [
                'metadata' => [
                    'title'=>'Lorem ipsum dolor sit amet, consectetur adipiscing',
                    'author'=>'Marcus Antonius',
                    'keywords'=>'latin, ipsum'
                ],
                'content' => '
Correct markdown document. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.'
            ]),
            array($source02, [
                'metadata' => [],
                'content' => $source02
            ]),
            array($source03, [
                'metadata' => [],
                'content' => $source03
            ]),
            array($source04, [
                'metadata' => [],
                'content' => '
Empty metadata. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.'
            ]),
            array($source05, [
                'metadata' => [],
                'content' => $source05
            ]),
            array($source06, [
                'metadata' => [],
                'content' => $source06
            ])
        );
    }
}