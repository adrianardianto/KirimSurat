<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLogTest extends TestCase
{
    /** @test */
    public function attributes_are_fillable()
    {
        $log = new AuditLog();
        $expected = ['user_id', 'action', 'description', 'ip_address'];
        
        $this->assertEquals($expected, $log->getFillable());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $log = new AuditLog();
        $this->assertInstanceOf(BelongsTo::class, $log->user());
        $this->assertEquals('user_id', $log->user()->getForeignKeyName());
    }
}
