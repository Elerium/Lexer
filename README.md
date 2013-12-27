# Elerium\Lexer [![Build Status](https://travis-ci.org/Elerium/Lexer.png)](https://travis-ci.org/Elerium/Lexer) #
Lexical analysis tool for PHP.

## Usage ##

Here is an example usage:
```
$patterns = array(
    'number' => '[0-9]',
);

$lexer = new \Elerium\Lexer\Lexer($patterns);
$lexemes = $lexer->getLexemes('12'); // Returns two lexemes
```

## Patterns ##
Pattern name should be numeric or non-numeric value. Pattern name should contains named sub patterns, marked with **?P<name>** on beginning of pattern or sub pattern, but it's important that the patterns and sub patterns names must be unique. Ignored patterns are marked with **?:**. 

Named patterns:
```
$namedPattern = array(
    'address' => '(?P<city>[a-zA-Z]+) (?P<street>[a-zA-Z0-9]+)',
    'name' => '(?P<name>[a-zA-Z]+) (?P<surname>[a-zA-Z]+)' // error: repeating name!
);
```

Ignored patterns:
```
$ignoredPatterns = array(
    'whitespace' => '?:\s', // lexeme won't be added to list
);
```

## Errors ##
If there is no pattern exist for input, then Lexer throw **Elerium\Lexer\LexerException**.

```
$lexer = new \Elerium\Lexer\Lexer(array(
    'foo' => 'foo'
));
$lexer->getLexemes('bar'); // Invalid lexeme near 'bar' at line 1.
```
