<?php

namespace OkkunSh\PhpJsonParser;

use Exception;

class Parser {
    /**
     * @var array<int, array<string, string>> $tokens
     */
    private array $tokens;

    /**
     * @var int $position
     */
    private int $position = 0;


    /**
     * @param array<int, array<string, string>> $tokens
     */
    public function __construct(array $tokens) {
        $this->tokens = $tokens;
    }

    /**
     * @return array
     */
    public function parse() {
        $result = $this->parseValue();
        if ($this->currentToken()['type'] !== 'EOF') {
            throw new Exception("unexpected token after parsing complete");
        }

        return $result;
    }

    private function parseValue() {
        $token = $this->currentToken();

        switch ($token['type']) {
        case "LBRACE":
            return $this->parseObject();
        case "LBRACKET":
            return $this->parseArray();
        case "STRING":
            $this->advance();
            return $token['value'];
        case "NUMBER":
            $this->advance();
            return (float) $token['value'];
        case "TRUE":
            $this->advance();
            return true;
        case "FALSE":
            $this->advance();
            return false;
        case "NULL":
            $this->advance();
            return null;
        case "EOF":
            return null;
        default:
            throw new Exception("unexpected token: {$token['type']}");
        }
    }

    private function parseObject() {
        $this->expect('LBRACE');

        $object = [];

        while ($this->currentToken()['type'] !== 'RBRACE') {
            $key = $this->expect('STRING')['value'];
            $this->expect('COLON');

            $value = $this->parseValue();
            $object[$key] = $value;

            if ($this->currentToken()['type'] === 'COMMA') {
                $this->advance();
            }
        }

        $this->expect('RBRACE');

        return $object;
    }

    private function parseArray() {
        $this->expect('LBRACKET');

        $ary = [];

        while ($this->currentToken()['type'] !== 'RBRACKET') {
            $ary[] = $this->parseValue();

            if ($this->currentToken()['type'] === 'COMMA') {
                $this->advance();
            }
        }

        $this->expect('RBRACKET');

        return $ary;
    }

    // TODO: throw exception
    private function expect(string $type) :array {
        $token = $this->currentToken();
        $this->advance();

        return $token;
    }

    private function advance() {
        $this->position++;
    }

    private function currentToken() :array {
        return $this->tokens[$this->position] ?? ['type' => 'EOF', 'value' => null];
    }
}

