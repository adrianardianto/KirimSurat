<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTest extends TestCase
{
    /** @test */
    public function attributes_are_fillable()
    {
        $user = new User();
        $expected = ['name', 'email', 'password', 'role'];
        
        $this->assertEquals($expected, $user->getFillable());
    }

    /** @test */
    public function attributes_are_hidden()
    {
        $user = new User();
        $expected = ['password', 'remember_token'];
        
        $this->assertEquals($expected, $user->getHidden());
    }

    /** @test */
    public function it_casts_attributes()
    {
        $user = new User();
        $casts = $user->getCasts();
        
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertEquals('hashed', $casts['password']);
    }

    /** @test */
    public function it_checks_admin_role()
    {
        $user = new User(['role' => 'admin']);
        $this->assertTrue($user->isAdmin());

        $user = new User(['role' => 'user']);
        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function it_has_many_surats()
    {
        $user = new User();
        $this->assertInstanceOf(HasMany::class, $user->surats());
        $this->assertEquals('surats.user_id', $user->surats()->getQualifiedForeignKeyName());
    }

    /** @test */
    public function it_has_many_approved_surats()
    {
        $user = new User();
        $this->assertInstanceOf(HasMany::class, $user->approvedSurats());
        $this->assertEquals('surats.approved_by', $user->approvedSurats()->getQualifiedForeignKeyName());
    }
}
