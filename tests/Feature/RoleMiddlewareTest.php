<?php

use App\Models\User;

test('admin can access admin routes but is forbidden from staff and penulis routes', function () {
    $admin = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'admin',
    ]);

    $this->actingAs($admin)->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
    $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    $this->actingAs($admin)->get(route('admin.beritas.index'))->assertOk();
    $this->actingAs($admin)->get(route('staff.dashboard'))->assertForbidden();
    $this->actingAs($admin)->get(route('penulis.dashboard'))->assertForbidden();
    $this->actingAs($admin)->get(route('penulis.beritas.index'))->assertForbidden();
});

test('staff can access staff routes but is forbidden from admin and penulis routes', function () {
    $staff = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'staff',
    ]);

    $this->actingAs($staff)->get(route('dashboard'))->assertRedirect(route('staff.dashboard'));
    $this->actingAs($staff)->get(route('staff.dashboard'))->assertOk();
    $this->actingAs($staff)->get(route('staff.beritas.index'))->assertOk();
    $this->actingAs($staff)->get(route('staff.galleries.index'))->assertOk();
    $this->actingAs($staff)->get(route('admin.dashboard'))->assertForbidden();
    $this->actingAs($staff)->get(route('penulis.dashboard'))->assertForbidden();
    $this->actingAs($staff)->get(route('penulis.beritas.index'))->assertForbidden();
});

test('penulis can access penulis routes but is forbidden from admin and staff routes', function () {
    $penulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $this->actingAs($penulis)->get(route('dashboard'))->assertRedirect(route('penulis.dashboard'));
    $this->actingAs($penulis)->get(route('penulis.dashboard'))->assertOk();
    $this->actingAs($penulis)->get(route('penulis.beritas.index'))->assertOk();
    $this->actingAs($penulis)->get(route('penulis.activities.index'))->assertOk();
    $this->actingAs($penulis)->get(route('admin.dashboard'))->assertForbidden();
    $this->actingAs($penulis)->get(route('staff.dashboard'))->assertForbidden();
    $this->actingAs($penulis)->get(route('staff.galleries.index'))->assertForbidden();
});
