<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Complaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('lifecare-home', false)
            ->assertSee('Layanan Pengaduan Wi-Fi Lifemedia');
    }

    public function test_login_page_uses_lifemedia_brand_theme_for_all_roles(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('lifecare-auth', false)
            ->assertSee('teknisi Lifemedia')
            ->assertSee('pelanggan');
    }

    public function test_registration_page_uses_lifemedia_brand_theme(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('lifecare-auth', false)
            ->assertSee('Daftar sebagai Pelanggan');
    }

    public function test_customer_dashboard_uses_the_admin_brand_palette(): void
    {
        $customer = User::factory()->create(['role' => 'warga']);

        $this->actingAs($customer)
            ->get(route('warga.dashboard'))
            ->assertOk()
            ->assertSee('dashboard-shell admin-dashboard', false)
            ->assertSee('Portal Pelanggan')
            ->assertSee('images/lifemedia-logo.png');
    }

    public function test_customer_dashboard_sections_have_separate_routes(): void
    {
        $customer = User::factory()->create(['role' => 'warga']);
        $ticket = $this->createComplaint($customer);
        $this->actingAs($customer);

        $this->get(route('warga.dashboard'))
            ->assertOk()
            ->assertSee(route('warga.aktivitas'))
            ->assertSee(route('warga.progress'))
            ->assertSee(route('warga.laporan.index'))
            ->assertDontSee('Tiket Pengaduan Terbaru');

        $this->get(route('warga.aktivitas'))
            ->assertOk()
            ->assertSee('Aktivitas Pengaduan')
            ->assertSee('Riwayat Tiket');

        $this->get(route('warga.progress'))
            ->assertOk()
            ->assertSee('Progres Tiket')
            ->assertSee('Progres per Tiket')
            ->assertSee('customer-ticket-link', false)
            ->assertSee('Lihat detail tiket')
            ->assertSee(route('warga.pengaduan.show', $ticket));

        $this->get(route('warga.laporan.index'))
            ->assertOk()
            ->assertSee('Laporan Pengaduan')
            ->assertSee(route('warga.laporan.pdf'))
            ->assertDontSee('report-badge', false);
    }

    public function test_customer_can_download_their_report_pdf(): void
    {
        $customer = User::factory()->create(['role' => 'warga']);

        $response = $this->actingAs($customer)->get(route('warga.laporan.pdf'));

        $response->assertOk()
            ->assertHeader('content-type', 'application/pdf')
            ->assertHeader('content-disposition', 'attachment; filename=laporan-pengaduan-pelanggan-lifecare.pdf')
            ->assertSee('%PDF', false);
    }

    public function test_new_complaint_page_uses_customer_dashboard_theme(): void
    {
        $customer = User::factory()->create(['role' => 'warga']);

        $this->actingAs($customer)
            ->get(route('warga.pengaduan.create'))
            ->assertOk()
            ->assertSee('dashboard-shell admin-dashboard', false)
            ->assertSee('Buat Pengaduan Internet')
            ->assertSee('complaint-form-panel', false)
            ->assertSee('Kirim Pengaduan');
    }

    public function test_admin_can_download_report_pdf(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Lifemedia',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/laporan/pdf');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_admin_navigation_sections_have_separate_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Pengaduan');

        $this->get(route('admin.pengaduan.index'))
            ->assertOk()
            ->assertSee('Pengaduan Pelanggan');

        $this->get(route('admin.analitik'))
            ->assertOk()
            ->assertSee('Analitik Pengaduan');

        $this->get(route('admin.laporan.index'))
            ->assertOk()
            ->assertSee('Laporan Pengaduan');
    }

    public function test_admin_ticket_detail_uses_the_lifemedia_dashboard_theme(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'warga']);
        $ticket = $this->createComplaint($customer);

        $this->actingAs($admin)
            ->get(route('admin.pengaduan.show', $ticket))
            ->assertOk()
            ->assertSee('dashboard-shell admin-dashboard', false)
            ->assertSee('admin-ticket-tracker', false)
            ->assertSee('Detail E-Tiket')
            ->assertSee('Tugaskan Teknisi');
    }

    public function test_admin_can_open_only_unassigned_tickets_from_sidebar_menu(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'warga']);
        $technician = User::factory()->create(['role' => 'teknisi']);
        $unassignedTicket = $this->createComplaint($customer);
        $assignedTicket = $this->createComplaint($customer, $technician);

        $this->actingAs($admin)
            ->get(route('admin.pengaduan.unassigned'))
            ->assertOk()
            ->assertSee('Tiket Belum Ditugaskan')
            ->assertSee('Belum Ditugaskan')
            ->assertSee(route('admin.pengaduan.show', $unassignedTicket))
            ->assertDontSee(route('admin.pengaduan.show', $assignedTicket));
    }

    public function test_admin_category_pages_use_the_lifemedia_dashboard_theme(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->get(route('admin.kategori.index'))
            ->assertOk()
            ->assertSee('admin-dashboard', false)
            ->assertSee('images/lifemedia-logo.png')
            ->assertSee('Jenis Gangguan');

        $this->get(route('admin.kategori.create'))
            ->assertOk()
            ->assertSee('admin-dashboard', false)
            ->assertSee('Tambah Jenis Gangguan');

        $category = Category::create(['name' => 'Wi-Fi Lambat']);
        $this->get(route('admin.kategori.edit', $category))
            ->assertOk()
            ->assertSee('admin-dashboard', false)
            ->assertSee('Edit Jenis Gangguan');
    }

    public function test_technician_login_redirects_to_the_technician_dashboard(): void
    {
        $technician = User::factory()->create([
            'email' => 'tech@example.com',
            'password' => Hash::make('technician-password'),
            'role' => 'teknisi',
        ]);

        $this->post(route('login'), [
            'email' => $technician->email,
            'password' => 'technician-password',
        ])->assertRedirect(route('teknisi.dashboard'));
    }

    public function test_admin_can_create_technician_and_assign_a_ticket(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'warga']);

        $this->actingAs($admin)
            ->post(route('admin.teknisi.store'), [
                'name' => 'Teknisi Uji',
                'email' => 'teknisi-uji@example.com',
                'password' => 'secure-pass-123',
                'password_confirmation' => 'secure-pass-123',
            ])
            ->assertRedirect(route('admin.teknisi.index'));

        $technician = User::where('email', 'teknisi-uji@example.com')->firstOrFail();
        $complaint = $this->createComplaint($customer);

        $this->put(route('admin.pengaduan.update', $complaint), [
            'status' => Complaint::STATUS_DIPROSES,
            'technician_id' => $technician->id,
        ])->assertRedirect(route('admin.pengaduan.show', $complaint));

        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'technician_id' => $technician->id,
        ]);
    }

    public function test_technician_only_updates_assigned_tickets_and_customer_can_see_progress(): void
    {
        $technician = User::factory()->create(['role' => 'teknisi']);
        $otherTechnician = User::factory()->create(['role' => 'teknisi']);
        $customer = User::factory()->create(['role' => 'warga']);
        $assignedTicket = $this->createComplaint($customer, $technician);
        $otherTicket = $this->createComplaint($customer, $otherTechnician);

        $this->actingAs($technician)
            ->get(route('teknisi.dashboard'))
            ->assertOk()
            ->assertSee('TKT-' . str_pad((string) $assignedTicket->id, 6, '0', STR_PAD_LEFT))
            ->assertDontSee('TKT-' . str_pad((string) $otherTicket->id, 6, '0', STR_PAD_LEFT));

        $this->get(route('teknisi.tiket.show', $otherTicket))->assertNotFound();

        $this->put(route('teknisi.tiket.update', $assignedTicket), [
            'status' => Complaint::STATUS_SELESAI,
            'technician_note' => 'Router sudah diperiksa dan koneksi kembali normal.',
        ])->assertRedirect(route('teknisi.tiket.show', $assignedTicket));

        $this->assertDatabaseHas('complaints', [
            'id' => $assignedTicket->id,
            'status' => Complaint::STATUS_SELESAI,
            'technician_note' => 'Router sudah diperiksa dan koneksi kembali normal.',
        ]);

        $this->actingAs($customer)
            ->get(route('warga.pengaduan.show', $assignedTicket))
            ->assertOk()
            ->assertSee('dashboard-shell admin-dashboard', false)
            ->assertSee('customer-ticket-detail', false)
            ->assertSee('Router sudah diperiksa dan koneksi kembali normal.');
    }

    public function test_customer_cannot_open_technician_dashboard(): void
    {
        $customer = User::factory()->create(['role' => 'warga']);

        $this->actingAs($customer)->get(route('teknisi.dashboard'))->assertForbidden();
    }

    public function test_admin_cannot_assign_ticket_to_a_non_technician(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'warga']);
        $ticket = $this->createComplaint($customer);

        $this->actingAs($admin)
            ->put(route('admin.pengaduan.update', $ticket), [
                'status' => Complaint::STATUS_DIPROSES,
                'technician_id' => $customer->id,
            ])
            ->assertSessionHasErrors('technician_id');

        $this->assertDatabaseHas('complaints', [
            'id' => $ticket->id,
            'technician_id' => null,
        ]);
    }

    public function test_customer_can_attach_a_photo_to_a_complaint_and_see_its_preview(): void
    {
        Storage::fake('public');
        $customer = User::factory()->create(['role' => 'warga']);

        $this->actingAs($customer)
            ->post(route('warga.pengaduan.store'), [
                'category' => 'Wi-Fi Lambat',
                'location' => 'Jl. Merdeka No. 10',
                'description' => 'Koneksi Wi-Fi tidak stabil.',
                'photo' => UploadedFile::fake()->create('router.jpg', 10, 'image/jpeg'),
            ])
            ->assertRedirect(route('warga.dashboard'));

        $complaint = Complaint::firstOrFail();
        Storage::disk('public')->assertExists($complaint->photo);

        $this->get(route('warga.pengaduan.show', $complaint))
            ->assertOk()
            ->assertSee('customer-ticket-detail', false)
            ->assertSee('Foto lampiran pengaduan')
            ->assertSee(Storage::disk('public')->url($complaint->photo), false);

        $admin = User::factory()->create(['role' => 'admin']);
        $technician = User::factory()->create(['role' => 'teknisi']);
        $complaint->update(['technician_id' => $technician->id]);

        $this->actingAs($admin)
            ->get(route('admin.pengaduan.show', $complaint))
            ->assertOk()
            ->assertSee('complaint-attachment-preview', false)
            ->assertSee(Storage::disk('public')->url($complaint->photo), false);

        $this->actingAs($technician)
            ->get(route('teknisi.tiket.show', $complaint))
            ->assertOk()
            ->assertSee('complaint-attachment-preview', false)
            ->assertSee(Storage::disk('public')->url($complaint->photo), false);
    }

    private function createComplaint(User $customer, ?User $technician = null): Complaint
    {
        return Complaint::create([
            'user_id' => $customer->id,
            'technician_id' => $technician?->id,
            'category' => 'Wi-Fi Lambat',
            'location' => 'Jl. Merdeka No. 10',
            'description' => 'Koneksi Wi-Fi tidak stabil.',
            'status' => Complaint::STATUS_DIAJUKAN,
        ]);
    }
}
