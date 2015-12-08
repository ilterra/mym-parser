<?php

/*
 * This file is part of the MYMParser package.
 *
 * (c) Alberto Terragni <alberto.terragni@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ninjabachelor\MYMParser;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Parse YAML metadata from a markdown document
 *
 * @author Alberto Terragni <alberto.terragni@gmail.com>
 */
class Parser
{
    const METADATA_START = '/^---\n/';
    const METADATA_END = '/\n---\n/';

    /**
     * Parse a markdown document looking for metadata in YAML format
     *
     * In order to be parsed, metadata must be placed at the beginning of the document between two triple dashes.
     * Example:
     * ---
     * title: Lorem ipsum
     * author: Marcus Antonius
     * keywords: latin, ipsum
     * ---
     *
     * @param string $source Markdown source document
     *
     * @return array Two-element associative array. 'metadata': array of parsed metadata, 'content': document source without metadata
     *
     * @throws \InvalidArgumentException If the markdown source document is not a string
     * @throws ParseException If the YAML is not valid
     */
    public static function parse($source)
    {
        if (!is_string($source)) {
            throw new \InvalidArgumentException('Parser::parse() function accepts only string as source parameter. Input was of type: '.gettype($source));
        }

        $document = [
            'metadata'=>[],
            'content'=>$source
        ];

        if (preg_match(self::METADATA_START, $source)) {
            $sections = preg_split(self::METADATA_END, preg_replace(self::METADATA_START, '', $source), 2);

            if (count($sections) === 2) {

                if (!empty(trim($sections[0]))) {
                    $document['metadata'] = Yaml::parse(trim($sections[0]));
                }

                $document['content'] = $sections[1];
            }
        }

        return $document;
    }
}