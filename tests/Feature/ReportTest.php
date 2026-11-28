<?php

use App\Models\Activity;
use App\Models\Berita;
use App\Models\User;
use OpenSpout\Reader\XLSX\Reader;

function readXlsxRows(string $filePath): array
{
    $reader = new Reader;
    $reader->open($filePath);

    $rows = [];
    foreach ($reader->getSheetIterator() as $sheet) {
        foreach ($sheet->getRowIterator() as $row) {
            $rows[] = $row->toArray();
        }
        break;
    }

    $reader->close();

    return $rows;
}

test('guests are redirected to login when accessing report pages or exports', function () {
    $this->get(route('admin.reports.index'))->assertRedirect(route('login'));
    $this->get(route('admin.reports.export'))->assertRedirect(route('login'));
    $this->get(route('staff.reports.index'))->assertRedirect(route('login'));
    $this->get(route('penulis.reports.index'))->assertRedirect(route('login'));
});

test('roles cannot access report routes belonging to other roles', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $staff = User::factory()->create(['role' => 'staff']);
    $penulis = User::factory()->create(['role' => 'penulis']);

    $this->actingAs($admin)->get(route('admin.reports.index'))->assertOk();
    $this->actingAs($admin)->get(route('staff.reports.index'))->assertForbidden();
    $this->actingAs($admin)->get(route('penulis.reports.index'))->assertForbidden();

    $this->actingAs($staff)->get(route('staff.reports.index'))->assertOk();
    $this->actingAs($staff)->get(route('admin.reports.index'))->assertForbidden();
    $this->actingAs($staff)->get(route('penulis.reports.index'))->assertForbidden();

    $this->actingAs($penulis)->get(route('penulis.reports.index'))->assertOk();
    $this->actingAs($penulis)->get(route('admin.reports.index'))->assertForbidden();
    $this->actingAs($penulis)->get(route('staff.reports.index'))->assertForbidden();
});

test('admin and staff reports filter by date range, content type, and status while hiding private drafts', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $penulis = User::factory()->create(['role' => 'penulis', 'name' => 'Rimba Penulis']);

    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Ekspedisi November Published',
        'event_date' => '2026-11-10',
        'status' => 'published',
        'is_active' => true,
    ]);
    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Ekspedisi Oktober Archived',
        'event_date' => '2026-10-05',
        'status' => 'archived',
        'is_active' => false,
    ]);
    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Draft Rahasia',
        'event_date' => '2026-11-12',
        'status' => 'draft',
        'is_active' => false,
    ]);

    Berita::factory()->create([
        'user_id' => $penulis->id,
        'judul' => 'Berita Review November',
        'tanggal_terbit' => '2026-11-15',
        'status' => 'review',
        'is_published' => false,
    ]);
    Berita::factory()->draft()->create([
        'user_id' => $penulis->id,
        'judul' => 'Berita Draft Rahasia',
        'tanggal_terbit' => '2026-11-16',
    ]);

    // Default admin report hides drafts
    $this->actingAs($admin)
        ->get(route('admin.reports.index'))
        ->assertOk()
        ->assertSee('Ekspedisi November Published')
        ->assertSee('Ekspedisi Oktober Archived')
        ->assertSee('Berita Review November')
        ->assertDontSee('Kegiatan Draft Rahasia')
        ->assertDontSee('Berita Draft Rahasia');

    // Filter date range + type
    $this->actingAs($admin)
        ->get(route('admin.reports.index', [
            'start_date' => '2026-11-01',
            'end_date' => '2026-11-30',
            'type' => 'activity',
        ]))
        ->assertOk()
        ->assertSee('Ekspedisi November Published')
        ->assertDontSee('Ekspedisi Oktober Archived')
        ->assertDontSee('Berita Review November');

    // Filter status
    $this->actingAs($admin)
        ->get(route('admin.reports.index', ['status' => 'review']))
        ->assertOk()
        ->assertSee('Berita Review November')
        ->assertDontSee('Ekspedisi November Published');
});

test('penulis report only shows own content and rejects cross-author exposure', function () {
    $penulis = User::factory()->create(['role' => 'penulis']);
    $otherPenulis = User::factory()->create(['role' => 'penulis']);

    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Draft Kegiatan Milik Penulis',
        'event_date' => '2026-11-05',
        'status' => 'draft',
        'is_active' => false,
    ]);
    Berita::factory()->create([
        'user_id' => $penulis->id,
        'judul' => 'Berita Published Milik Penulis',
        'tanggal_terbit' => '2026-11-06',
        'status' => 'published',
        'is_published' => true,
    ]);

    Activity::factory()->create([
        'user_id' => $otherPenulis->id,
        'title' => 'Kegiatan Milik Penulis Lain',
        'event_date' => '2026-11-05',
        'status' => 'published',
        'is_active' => true,
    ]);

    $this->actingAs($penulis)
        ->get(route('penulis.reports.index'))
        ->assertOk()
        ->assertSee('Draft Kegiatan Milik Penulis')
        ->assertSee('Berita Published Milik Penulis')
        ->assertDontSee('Kegiatan Milik Penulis Lain');
});

test('report handles empty results and validates invalid filter parameters', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    // Empty state
    $this->actingAs($admin)
        ->get(route('admin.reports.index', [
            'start_date' => '2025-01-01',
            'end_date' => '2025-01-31',
        ]))
        ->assertOk()
        ->assertSee('Tidak Ada Data Laporan');

    // Invalid date order & disallowed draft status for admin
    $this->actingAs($admin)
        ->from(route('admin.reports.index'))
        ->get(route('admin.reports.index', [
            'start_date' => '2026-11-20',
            'end_date' => '2026-11-01',
            'type' => 'invalid-type',
            'status' => 'draft',
        ]))
        ->assertRedirect(route('admin.reports.index'))
        ->assertSessionHasErrors(['end_date', 'type', 'status']);
});

test('excel export downloads a valid xlsx workbook matching active filters and role scope', function () {
    $staff = User::factory()->create(['role' => 'staff', 'name' => 'Siti Staff']);
    $penulis = User::factory()->create(['role' => 'penulis', 'name' => 'Budi Penulis']);

    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Ekspedisi Export Match',
        'category' => 'Ekspedisi',
        'location' => 'Gunung Gede',
        'event_date' => '2026-11-12',
        'status' => 'published',
        'is_active' => true,
    ]);
    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Ekspedisi Draft Hidden',
        'event_date' => '2026-11-12',
        'status' => 'draft',
        'is_active' => false,
    ]);
    Berita::factory()->create([
        'user_id' => $penulis->id,
        'judul' => 'Berita Outside Filter',
        'tanggal_terbit' => '2026-10-01',
        'status' => 'published',
        'is_published' => true,
    ]);

    $response = $this->actingAs($staff)->get(route('staff.reports.export', [
        'start_date' => '2026-11-01',
        'end_date' => '2026-11-30',
        'type' => 'activity',
        'status' => 'published',
    ]));

    $response->assertOk()->assertDownload();

    $file = $response->getFile();
    $rows = readXlsxRows($file->getPathname());

    // Header metadata + 1 blank + table header + 1 matching row
    $flattened = collect($rows)->flatten()->implode(' | ');
    expect($flattened)->toContain('LAPORAN KONTEN CMS SEMAR RIMBA')
        ->toContain('Ekspedisi Export Match')
        ->toContain('Gunung Gede')
        ->not->toContain('Ekspedisi Draft Hidden')
        ->not->toContain('Berita Outside Filter');

    $headerIndex = collect($rows)->search(fn (array $row): bool => ($row[0] ?? null) === 'No' && ($row[1] ?? null) === 'Jenis Konten');
    expect($headerIndex)->not->toBeFalse();

    $dataRows = array_values(array_slice($rows, (int) $headerIndex + 1));
    expect($dataRows)->toHaveCount(1);
    expect($dataRows[0][1])->toBe('Kegiatan');
    expect($dataRows[0][2])->toBe('Ekspedisi Export Match');

    // Clean up temp file if still present after test
    if (file_exists($file->getPathname())) {
        @unlink($file->getPathname());
    }
});
