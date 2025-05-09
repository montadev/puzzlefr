<?php

declare (strict_types=1);
namespace Rector\Php80\ValueObject;

use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
final class NestedDoctrineTagAndAnnotationToAttribute
{
    /**
     * @readonly
     */
    private DoctrineAnnotationTagValueNode $doctrineAnnotationTagValueNode;
    /**
     * @readonly
     */
    private \Rector\Php80\ValueObject\NestedAnnotationToAttribute $nestedAnnotationToAttribute;
    public function __construct(DoctrineAnnotationTagValueNode $doctrineAnnotationTagValueNode, \Rector\Php80\ValueObject\NestedAnnotationToAttribute $nestedAnnotationToAttribute)
    {
        $this->doctrineAnnotationTagValueNode = $doctrineAnnotationTagValueNode;
        $this->nestedAnnotationToAttribute = $nestedAnnotationToAttribute;
    }
    public function getDoctrineAnnotationTagValueNode() : DoctrineAnnotationTagValueNode
    {
        return $this->doctrineAnnotationTagValueNode;
    }
    public function getNestedAnnotationToAttribute() : \Rector\Php80\ValueObject\NestedAnnotationToAttribute
    {
        return $this->nestedAnnotationToAttribute;
    }
}
