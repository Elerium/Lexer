<?php

/**
 * Part of Elerium Framework
 * Copyright (c) 2013
 */
 
namespace EleriumTests\Lexer;

use Elerium;
use EleriumTests\Mocks;
use Tester\Assert;
use Elerium\Lexer;

require_once __DIR__ . '/../../bootstrap.php';

$lexer = new Lexer\lexer(array());
$types = $lexer->getTypes();
Assert::true(empty($types));