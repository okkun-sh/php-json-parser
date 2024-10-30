<?php

use OkkunSh\PhpJsonParser\Lexer;
use PHPUnit\Framework\TestCase;

class LexerTest extends TestCase
{
    public function testLexerValidJsonObject()
    {
        $input = '{"aaa": "AA"}';
        $lexer = new Lexer($input);
        $expected = [
            [
                "type" => "LBRACE",
                "value" => "{",
            ],
            [
                "type" => "STRING",
                "value" => "aaa",
            ],
            [
                "type" => "COLON",
                "value" => ":",
            ],
            [
                "type" => "STRING",
                "value" => "AA",
            ],
            [
                "type" => "RBRACE",
                "value" => "}",
            ],
        ];
        $lexer->tokenize();

        $this->assertEquals($expected, $lexer->tokens());
    }
}
