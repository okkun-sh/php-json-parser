<?php

namespace Tests;

use OkkunSh\PhpJsonParser\Parser;
use OkkunSh\PhpJsonParser\Lexer;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParserValidJson()
    {
        $input = '{"stringKey":"stringValue","numberKey":12345,"floatKey":123.45,"booleanTrue":true,"booleanFalse":false,"nullKey":null,"nestedObject":{"nestedString":"nestedValue","nestedNumber":678,"nestedArray":[1,2,3,{"innerKey":"innerValue"}]}}';
        $lexer = new Lexer($input);
        $lexer->tokenize();
        $parser = new Parser($lexer->tokens());

        $this->assertEquals($input, json_encode($parser->parse()));
    }
}
