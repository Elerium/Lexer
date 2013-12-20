<?php

/**
 * Part of Elerium Framework
 * Copyright (c) 2013
 */
 
namespace EleriumTest\Lexer;

use Elerium;
use Tester;
use Tester\Assert,
	Elerium\Lexer;

require_once '../../bootstrap.php';

const CT_STRING = 0;
const CT_COLON = 1;
const CT_TELEPHONE = 2;
const CT_NUMBER = 4;
const CT_TABS = 'tabs';
const CT_SPACE = 'space';
const CT_WHITESPACE = 'whitespace';

$patterns = array(
	CT_TELEPHONE => '(?P<area>[0-9]{3})\-([0-9]{4})',
	CT_NUMBER => '[0-9]+',
	CT_COLON => '\:',
	CT_STRING => '[a-zA-Z0-9][a-zA-Z0-9 ]+',
	CT_TABS => '\t',
	CT_SPACE => '?: ',
	CT_WHITESPACE => '\s'
);

$lexer = new Lexer\Lexer($patterns);

Assert::throws(function() use ($lexer) {
	$lexer->getLexemes('foo & bar');
}, 'Elerium\Lexer\LexerException', "Invalid lexeme near '& bar' at line 1.");

Assert::same(array(2, 4, 1, 0, 'tabs', 'whitespace'), $lexer->getTypes());

$input = file_get_contents(__DIR__ . '/tokenize.that');
$lexemes = $lexer->getLexemes($input);

$expected = array(
	array(
		'type' => CT_STRING,
		'value' => 'Foo',
		'offset' => 0,
		'lineOffset' => 0,
		'line' => 1
	),
	array(
		'type' => CT_COLON,
		'value' => ':',
		'offset' => 3,
		'lineOffset' => 3,
		'line' => 1
	),
	array(
		'type' => CT_STRING,
		'value' => 'Bar',
		'offset' => 5,
		'lineOffset' => 5,
		'line' => 1
	),
	array(
		'type' => CT_WHITESPACE,
		'value' => "\n",
		'offset' => 8,
		'lineOffset' => 8,
		'line' => 1
	),
	array(
		'type' => CT_WHITESPACE,
		'value' => "\n",
		'offset' => 9,
		'lineOffset' => 0,
		'line' => 2
	),
	array(
		'type' => CT_STRING,
		'value' => 'Jenny',
		'offset' => 10,
		'lineOffset' => 0,
		'line' => 3
	),
	array(
		'type' => CT_COLON,
		'value' => ':',
		'offset' => 15,
		'lineOffset' => 5,
		'line' => 3
	),
	array(
		'type' => CT_WHITESPACE,
		'value' => "\n",
		'offset' => 16,
		'lineOffset' => 6,
		'line' => 3
	),
	array(
		'type' => CT_TABS,
		'value' => "\t",
		'offset' => 17,
		'lineOffset' => 0,
		'line' => 4
	),
	array(
		'type' => CT_TELEPHONE,
		'value' => array('867-5309', 'area' => '867', '867', '5309'),
		'offset' => 18,
		'lineOffset' => 1,
		'line' => 4
	)
);

Assert::false(empty($lexemes));
foreach($lexemes as $key => $lexeme)
{
	Assert::same($expected[$key]['type'], $lexeme->getType());
	Assert::same($expected[$key]['value'], $lexeme->getValue());
	Assert::same($expected[$key]['offset'], $lexeme->getOffset());
	Assert::same($expected[$key]['lineOffset'], $lexeme->getLineOffset());
	Assert::same($expected[$key]['line'], $lexeme->getLine());
}