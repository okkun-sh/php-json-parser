<?php

namespace Tests;

use OkkunSh\PhpJsonParser\Lexer;
use PHPUnit\Framework\TestCase;

class LexerTest extends TestCase
{
    public function testLexerValidObject(): void
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

    public function testLexerValidArray(): void
    {

        $input = '[123, "abc", true, null, {"key": "value"}]';
        $lexer = new Lexer($input);

        $expected = [
            [
                "type" => "LBRACKET",
                "value" => "[",
            ],
            [
                "type" => "NUMBER",
                "value" => "123",
            ],
            [
                "type" => "COMMA",
                "value" => ",",
            ],
            [
                "type" => "STRING",
                "value" => "abc",
            ],
            [
                "type" => "COMMA",
                "value" => ",",
            ],
            [
                "type" => "TRUE",
                "value" => "true",
            ],
            [
                "type" => "COMMA",
                "value" => ",",
            ],
            [
                "type" => "NULL",
                "value" => "null",
            ],
            [
                "type" => "COMMA",
                "value" => ",",
            ],
            [
                "type" => "LBRACE",
                "value" => "{",
            ],
            [
                "type" => "STRING",
                "value" => "key",
            ],
            [
                "type" => "COLON",
                "value" => ":",
            ],
            [
                "type" => "STRING",
                "value" => "value",
            ],
            [
                "type" => "RBRACE",
                "value" => "}",
            ],
            [
                "type" => "RBRACKET",
                "value" => "]",
            ],
        ];
        $lexer->tokenize();

        $this->assertEquals($expected, $lexer->tokens());
    }
}
