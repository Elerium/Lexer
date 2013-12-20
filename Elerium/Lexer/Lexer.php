<?php

/**
 * Part of Elerium Framework
 * Copyright (c) 2013
 */

namespace Elerium\Lexer;

use Elerium;

class Lexer
{
	/** @var string */
	private $pattern;

	/** @var array */
	private $types;

	/**
	 * @param array $patterns
	 */
	public function __construct(array $patterns)
	{
		$types = array();
		$this->pattern = '/(' . implode(')|(', array_map(function($type, $pattern) use (&$types) {
			if(substr($pattern, 0, 2) !== '?:')
			{
				$hash = "_$type";
				$types[$hash] = $type;
				return "?P<$hash>$pattern";
			}

			return $pattern;
		}, array_keys($patterns), $patterns)) . ')/';
		$this->types = $types;
	}

	/**
	 * @param string $input
	 * @return array
	 * @throws \Elerium\Lexer\LexerException
	 */
	public function getLexemes($input)
	{
		$expectedOffset = 0;
		$lineOffset = 0;
		$line = 1;

		preg_match_all($this->pattern, $input, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

		$tokens = array();
		foreach($matches as $match)
		{
			$type = NULL;
			$values = NULL;
			foreach($match as $key => $value)
			{
				if(empty($match[0]))
				{
					break;
				}

				if($type === NULL && isset($this->types[$key]) && !empty($value[0]))
				{
					$type = $this->types[$key];
				}

				if(!empty($value[0]) && !isset($this->types[$key]) && $key !== 0)
				{
					if(is_string($key))
					{
						$values[$key] = $value[0];
					}
					else
					{
						$values[] = $value[0];
					}
				}
			}

			$offset = array_pop($match[0]);
			if($expectedOffset != $offset)
			{
				throw new LexerException("Invalid lexeme near '" . substr($input, $expectedOffset, 10) . "' at line $line.");
			}

			$expectedOffset += strlen($match[0][0]);

			if($type !== NULL)
			{
				$tokens[] = new Lexeme($type, count($values) > 1 ? $values : $values[0], $offset, $lineOffset, $line);
			}

			$lines = substr_count($match[0][0], "\n");
			$lineOffset = $lines > 0 ? strlen(substr($match[0][0], strrpos($match[0][0], "\n") + 1)) : $lineOffset + strlen($match[0][0]);
			$line += $lines;
		}

		return $tokens;
	}

	/**
	 * @return array
	 */
	public function getTypes()
	{
		return array_values($this->types);
	}
}