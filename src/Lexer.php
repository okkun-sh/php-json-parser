<?php

namespace OkkunSh\PhpJsonParser;

class Lexer {
    /**
     * @var string $json
     */
    private string $json;

    /**
     * @var int $position
     */
    private int $position;

    /**
     * @var array<int, array<string, string>> $tokens
     */
    private array $tokens;

    /**
     * @param string $json
     */
    public function __construct(string $json)
    {
        $this->json = $json;
        $this->position = 0;
        $this->tokens = [];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function tokens() {
        return $this->tokens;
    }

    /**
     * @return void
     */
    public function tokenize() : void {
        $len = strlen($this->json);
        while ($this->position < $len) {
            $char = $this->json[$this->position];
            switch ($char) {
            case '{':
                $this->tokens[] = ['type' => 'LBRACE', 'value' => '{'];
                $this->position++;
                break;
            case '}':
                $this->tokens[] = ['type' => 'RBRACE', 'value' => '}'];
                $this->position++;
                break;
            case '[':
                $this->tokens[] = ['type' => 'LBRACKET', 'value' => '['];
                $this->position++;
                break;
            case ']':
                $this->tokens[] = ['type' => 'RBRACKET', 'value' => ']'];
                $this->position++;
                break;
            case ':':
                $this->tokens[] = ['type' => 'COLON', 'value' => ':'];
                $this->position++;
                break;
            case ',':
                $this->tokens[] = ['type' => 'COMMA', 'value' => ','];
                $this->position++;
                break;
            case '\n':
            case '\t':
            case ' ':
                $this->position++;
                break;
            case '"':
                $this->position++;
                $s = $this->position;
                while ($this->json[$this->position] !== '"') {
                    $this->position++;
                }
                $v = substr($this->json, $s, $this->position - $s);
                $this->position++;

                $this->tokens[] = ['type' => 'STRING', 'value' => $v];
                break;
            default:
                if(ctype_digit($char) || $char === '-') {
                    $s = $this->position;
                    while(ctype_digit($this->json[$this->position]) ||
                        $this->json[$this->position] === '.' ||
                        $this->json[$this->position] === '-' ||
                        $this->json[$this->position] === 'e' ||
                        $this->json[$this->position] === 'E') {
                        $this->position++;
                    }
                    $v = substr($this->json, $s, $this->position - $s);
                    $this->tokens[] = ['type' => 'NUMBER', 'value' => $v];
                } elseif(ctype_alpha($char)) {
                    $s = $this->position;
                    while(ctype_alpha($this->json[$this->position])) {
                        $this->position++;
                    }
                    $v = substr($this->json, $s, $this->position - $s);
                    $this->tokens[] = ['type' => strtoupper($v), 'value' => $v];
                }
            }
        }
    }
}

