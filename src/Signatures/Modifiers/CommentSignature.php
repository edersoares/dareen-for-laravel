<?php

namespace Dareen\Signatures\Modifiers;

use Dareen\Signatures\ModifierSignature;

class CommentSignature extends ModifierSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'comment';

    /**
     * CommentSignature constructor.
     *
     * @param string $comment
     */
    public function __construct($comment)
    {
        $this->addArgument($comment);
    }
}
