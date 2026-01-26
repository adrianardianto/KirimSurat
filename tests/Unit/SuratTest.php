<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Surat;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratTest extends TestCase
{
    /** @test */
    public function attributes_are_fillable()
    {
        $surat = new Surat();
        
        $expected = [
            'type', 'reference_number', 'date', 'sender', 'recipient',
            'subject', 'content', 'status', 'file_path',
            'category_id', 'user_id', 'approved_by', 'approved_at'
        ];
        
        $this->assertEquals($expected, $surat->getFillable());
    }

    /** @test */
    public function it_casts_attributes()
    {
        $surat = new Surat();
        $casts = $surat->getCasts();
        
        $this->assertEquals('date', $casts['date']);
        $this->assertEquals('datetime', $casts['approved_at']);
    }

    /** @test */
    public function it_belongs_to_category()
    {
        $surat = new Surat();
        $this->assertInstanceOf(BelongsTo::class, $surat->category());
        $this->assertEquals('category_id', $surat->category()->getForeignKeyName());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $surat = new Surat();
        $this->assertInstanceOf(BelongsTo::class, $surat->user());
        $this->assertEquals('user_id', $surat->user()->getForeignKeyName());
    }

    /** @test */
    public function it_belongs_to_approver()
    {
        $surat = new Surat();
        $this->assertInstanceOf(BelongsTo::class, $surat->approver());
        $this->assertEquals('approved_by', $surat->approver()->getForeignKeyName());
    }
}
