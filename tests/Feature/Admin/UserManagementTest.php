<?php

use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'name' => 'Admin Utama',
        'email' => 'admin@semarrimba.test',
        'email_verified_at' => now(),
        'role' => 'admin',
    ]);
});

test('guests are redirected to login when accessing kelola pengguna', function () {
    $this->get(route('admin.users-management.index'))
        ->assertRedirect(route('login'));
});

test('non admin users cannot access kelola pengguna', function () {
    $staff = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'staff',
    ]);

    $this->actingAs($staff)
        ->get(route('admin.users-management.index'))
        ->assertForbidden();
});

test('admin can view kelola pengguna page with user details', function () {
    $penulis = User::factory()->create([
        'name' => 'Budi Penulis',
        'email' => 'budi@semarrimba.test',
        'role' => 'penulis',
        'status' => true,
    ]);

    $inactiveStaff = User::factory()->create([
        'name' => 'Dina Nonaktif',
        'email' => 'dina@semarrimba.test',
        'role' => 'staff',
        'status' => false,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users-management.index'));

    $response->assertOk()
        ->assertSee('Kelola Pengguna')
        ->assertSee('Tambah Pengguna')
        ->assertSee('Status')
        ->assertSee('Aktif')
        ->assertSee('Nonaktif')
        ->assertSee('Aksi')
        ->assertSee('Edit')
        ->assertSee('Nonaktifkan')
        ->assertSee('Aktifkan')
        ->assertSee($penulis->name)
        ->assertSee($penulis->email)
        ->assertSee('penulis')
        ->assertSee($penulis->created_at->format('d M Y H:i'))
        ->assertSee($inactiveStaff->name);
});

test('admin can search users by name or email', function () {
    User::factory()->create([
        'name' => 'Siti Staff',
        'email' => 'siti@semarrimba.test',
        'role' => 'staff',
    ]);

    User::factory()->create([
        'name' => 'Andi Penulis',
        'email' => 'andi@semarrimba.test',
        'role' => 'penulis',
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.users-management.index', ['search' => 'Siti']))
        ->assertOk()
        ->assertSee('Siti Staff')
        ->assertDontSee('Andi Penulis');

    $this->actingAs($this->admin)
        ->get(route('admin.users-management.index', ['search' => 'andi@semarrimba.test']))
        ->assertOk()
        ->assertSee('Andi Penulis')
        ->assertDontSee('Siti Staff');
});

test('admin can add a new user', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.users-management.add'), [
            'name' => 'Rina Penulis',
            'email' => 'rina@semarrimba.test',
            'role' => 'penulis',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

    $response->assertRedirect(route('admin.users-management.index'))
        ->assertSessionHas('status');

    $this->assertDatabaseHas('users', [
        'name' => 'Rina Penulis',
        'email' => 'rina@semarrimba.test',
        'role' => 'penulis',
        'status' => 1,
    ]);
});

test('admin can edit an existing user', function () {
    $user = User::factory()->create([
        'name' => 'Lama',
        'email' => 'lama@semarrimba.test',
        'role' => 'staff',
        'status' => false,
    ]);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.users-management.edit', $user), [
            'name' => 'Baru',
            'email' => 'baru@semarrimba.test',
            'role' => 'penulis',
        ]);

    $response->assertRedirect(route('admin.users-management.index'))
        ->assertSessionHas('status');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Baru',
        'email' => 'baru@semarrimba.test',
        'role' => 'penulis',
        'status' => 0,
    ]);
});

test('add and edit user validate input into their respective error bags', function () {
    $user = User::factory()->create([
        'email' => 'existing@semarrimba.test',
    ]);

    $this->actingAs($this->admin)
        ->post(route('admin.users-management.add'), [
            'name' => '',
            'email' => 'existing@semarrimba.test',
            'role' => 'invalid',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ])
        ->assertSessionHasErrors(['name', 'email', 'role', 'password'], null, 'addUser');

    $this->actingAs($this->admin)
        ->put(route('admin.users-management.edit', $user), [
            'name' => '',
            'email' => $this->admin->email,
            'role' => 'invalid',
        ])
        ->assertSessionHasErrors(['name', 'email', 'role'], null, 'editUser'.$user->id);
});

test('admin can filter users by role and status', function () {
    User::factory()->create([
        'name' => 'Staff Aktif',
        'email' => 'staff-aktif@semarrimba.test',
        'role' => 'staff',
        'status' => true,
    ]);

    User::factory()->create([
        'name' => 'Staff Nonaktif',
        'email' => 'staff-nonaktif@semarrimba.test',
        'role' => 'staff',
        'status' => false,
    ]);

    User::factory()->create([
        'name' => 'Penulis Aktif',
        'email' => 'penulis-aktif@semarrimba.test',
        'role' => 'penulis',
        'status' => true,
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.users-management.index', ['role' => 'penulis']))
        ->assertOk()
        ->assertSee('Penulis Aktif')
        ->assertDontSee('Staff Aktif')
        ->assertDontSee('Staff Nonaktif');

    $this->actingAs($this->admin)
        ->get(route('admin.users-management.index', ['status' => '0']))
        ->assertOk()
        ->assertSee('Staff Nonaktif')
        ->assertDontSee('Staff Aktif')
        ->assertDontSee('Penulis Aktif');

    $this->actingAs($this->admin)
        ->get(route('admin.users-management.index', ['role' => 'staff', 'status' => '1']))
        ->assertOk()
        ->assertSee('Staff Aktif')
        ->assertDontSee('Staff Nonaktif')
        ->assertDontSee('Penulis Aktif');
});

test('admin can toggle user status and cannot deactivate own account', function () {
    $user = User::factory()->create([
        'status' => true,
    ]);

    $this->actingAs($this->admin)
        ->patch(route('admin.users-management.toggle-status', $user))
        ->assertRedirect(route('admin.users-management.index'))
        ->assertSessionHas('status', 'Pengguna berhasil dinonaktifkan.');

    expect($user->fresh()->status)->toBeFalse();

    $this->actingAs($this->admin)
        ->patch(route('admin.users-management.toggle-status', $user))
        ->assertRedirect(route('admin.users-management.index'))
        ->assertSessionHas('status', 'Pengguna berhasil diaktifkan.');

    expect($user->fresh()->status)->toBeTrue();

    $this->actingAs($this->admin)
        ->patch(route('admin.users-management.toggle-status', $this->admin))
        ->assertRedirect(route('admin.users-management.index'))
        ->assertSessionHas('error');

    expect($this->admin->fresh()->status)->toBeTrue();
});

test('active users are displayed before inactive users in the table', function () {
    $active = User::factory()->create([
        'name' => 'Pengguna Aktif Lama',
        'status' => true,
        'created_at' => now()->subDay(),
    ]);

    $inactive = User::factory()->create([
        'name' => 'Pengguna Nonaktif Baru',
        'status' => false,
        'created_at' => now(),
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.users-management.index'))
        ->assertOk()
        ->assertSeeInOrder([$active->name, $inactive->name]);
});
