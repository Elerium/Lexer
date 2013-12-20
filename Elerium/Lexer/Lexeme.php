<?php

/**
 * Part of Elerium Framework
 * Copyright (c) 2013
 */
 
namespace Elerium\Lexer;

use Elerium;

class Lexeme
{
	/** @var mixed */
	private $type;

	/** @var mixed */
	private $value;

	/** @var int */
	private $offset;

	/** @var int */
	private $lineOffset;

	/** @var int */
	private $line;

	/**
	 * @param mixed $type
	 * @param mixed $value
	 * @param int $offset
	 * @param int $lineOffset
	 * @param int $line
	 */
	public function __construct($type, $value, $offset, $lineOffset, $line)
	{
		$this->type = $type;
		$this->value = $value;
		$this->offset = $offset;
		$this->lineOffset = $lineOffset;
		$this->line = $line;
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return int
	 */
	public function getOffset()
	{
		return $this->offset;
	}

	/**
	 * @return int
	 */
	public function getLineOffset()
	{
		return $this->lineOffset;
	}

	/**
	 * @return int
	 */
	public function getLine()
	{
		return $this->line;
	}
}