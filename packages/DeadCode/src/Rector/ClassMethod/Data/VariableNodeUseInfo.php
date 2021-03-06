<?php declare(strict_types=1);

namespace Rector\DeadCode\Rector\ClassMethod\Data;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use Rector\Exception\ShouldNotHappenException;
use Rector\NodeTypeResolver\Node\Attribute;

final class VariableNodeUseInfo
{
    /**
     * @var string
     */
    public const TYPE_USE = 'use';

    /**
     * @var string
     */
    public const TYPE_ASSIGN = 'assign';

    /**
     * @var int
     */
    private $startTokenPosition;

    /**
     * @var string
     */
    private $variableName;

    /**
     * @var string
     */
    private $type;

    /**
     * @var Variable
     */
    private $variable;

    /**
     * @var string|null
     */
    private $nestingHash;

    public function __construct(
        int $startTokenPosition,
        string $variableName,
        string $type,
        Variable $variable,
        ?string $nestingHash = null
    ) {
        $this->startTokenPosition = $startTokenPosition;
        $this->variableName = $variableName;
        $this->type = $type;
        $this->variable = $variable;
        $this->nestingHash = $nestingHash;
    }

    public function isName(string $name): bool
    {
        return $this->variableName === $name;
    }

    public function getStartTokenPosition(): int
    {
        return $this->startTokenPosition;
    }

    public function isType(string $type): bool
    {
        return $this->type === $type;
    }

    public function getVariableNode(): Node
    {
        return $this->variable;
    }

    public function getParentNode(): Node
    {
        $parentNode = $this->variable->getAttribute(Attribute::PARENT_NODE);
        if ($parentNode === null) {
            throw new ShouldNotHappenException();
        }

        return $parentNode;
    }

    public function getNestingHash(): ?string
    {
        return $this->nestingHash;
    }
}
