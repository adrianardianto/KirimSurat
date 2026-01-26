<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTest extends TestCase
{
    /** @test */
    public function attributes_are_fillable()
    {
        $category = new Category();
        
        $expected = ['name', 'code', 'format_code', 'description'];
        
        $this->assertEquals($expected, $category->getFillable());
    }

    /** @test */
    public function it_has_surats_relation()
    {
        $category = new Category();
        
        $this->assertInstanceOf(HasMany::class, $category->surats());
        $this->assertEquals('surats.category_id', $category->surats()->getQualifiedForeignKeyName());
    }
}
