# MYMParser

[![Build Status](https://travis-ci.org/ninjabachelor/mym-parser.svg?branch=master)](https://travis-ci.org/ninjabachelor/mym-parser)
[![Latest Stable Version](https://poser.pugx.org/ninjabachelor/mym-parser/v/stable)](https://packagist.org/packages/ninjabachelor/mym-parser)

Markdown YAML metadata parser. Parse YAML metadata from a markdown document.

## Installation

Install the latest version with:

```bash
$ composer require ninjabachelor/mym-parser
```

## Usage

In order to be parsed, metadata must be placed at the beginning of the markdown document between two triple dashes. Example:

    ---
    title: Lorem ipsum dolor sit amet
    author: Marcus Antonius
    keywords: latin, ipsum
    ---

    Vestibulum tortor quam, *feugiat vitae*, ultricies eget, tempor sit amet, ante.

Here's how to parse the metadata:

```php
<?php

use Ninjabachelor\MYMParser\Parser;

// Load document source.
$source = file_get_contents('document.md');

// Parse source. Result is a two-element associative array
$result = Parser::parse($source);

// The first element, 'metadata', is the array of parsed metadata. Example:
//
// array(
//     'title'     =>  'Lorem ipsum dolor sit amet',
//     'author'    =>  'Marcus Antonius',
//     'keywords'  =>  'latin, ipsum'
// );
$result['metadata'];

// The second element, 'content', is the document source without metadata. Example:
//
// Vestibulum tortor quam, *feugiat vitae*, ultricies eget, tempor sit amet, ante.
$result['content'];
```

## License

MYMParser is licensed under the MIT License. See the `LICENSE` file for details.

## Credits

This library is inspired by daylerees' [Kurenai](https://github.com/daylerees/kurenai).