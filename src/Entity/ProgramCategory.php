<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class ProgramCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $name;

    private ProgramCategory $parentCategory;

    private array $childCategories;

}
