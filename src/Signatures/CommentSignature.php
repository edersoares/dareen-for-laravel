<?php

namespace Dareen\Signatures;

class CommentSignature extends AbstractSignature
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
