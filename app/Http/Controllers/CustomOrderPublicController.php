<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\GuestCredentialsMail;
use App\Mail\CustomOrderSubmittedMail;
use App\Models\CustomOrder;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomOrderPublicController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService,
    ) {}

    /**
     * Show custom order form.
     * Accessible by public (guests & authenticated users).
     */
    public function create()
    {
        $user = auth()->user();
        return view('customer.custom-orders.create', compact('user'));
    }

    /**
     * Store a new custom order.
     */
    public function store(Request $request)
    {
        // Check if active account — redirect to login
        if (!auth()->check() && $this->checkoutService->isActiveAccount($request->email)) {
            return redirect()->route('login')
                ->with('info', 'Email ini sudah terdaftar dan aktif. Silakan login terlebih dahulu untuk mengajukan Custom Order.')
                ->withInput();
        }

        $rules = [
            'description' => ['required', 'string', 'min:20', 'max:2000'],
            'dimensions' => ['required', 'string', 'max:255'],
            'material' => ['required', 'in:jati,mahoni,merbau,trembesi,sonokeling'],
            'finishing' => ['required', 'in:natural,glossy,doff,rustic,whitewash'],
            'color' => ['nullable', 'string', 'max:100'],
            'ref_images' => ['nullable', 'array', 'max:3'],
            'ref_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        // Add user data validation if not logged in
        if (!auth()->check()) {
            $rules['name'] = ['required', 'string', 'max:100'];
            $rules['email'] = ['required', 'email', 'max:150'];
            $rules['phone'] = ['required', 'string', 'max:20'];
            $rules['address'] = ['required', 'string'];
        }

        $validated = $request->validate($rules, [
            'description.required' => 'Deskripsi mebel wajib diisi.',
            'description.min' => 'Deskripsi minimal 20 karakter.',
            'dimensions.required' => 'Ukuran / dimensi wajib diisi.',
            'material.required' => 'Pilih jenis kayu.',
            'finishing.required' => 'Pilih jenis finishing.',
            'ref_images.max' => 'Maksimal 3 gambar referensi.',
            'ref_images.*.max' => 'Ukuran gambar maksimal 2MB.',
            'ref_images.*.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor WhatsApp/Telepon wajib diisi.',
            'address.required' => 'Alamat pengiriman wajib diisi.',
        ]);

        $isNewGuest = false;
        $userData = auth()->check() ? [] : [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ];

        // This will reuse existing logged in user or create a new guest account
        $user = $this->checkoutService->resolveUser($userData, $isNewGuest);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('ref_images')) {
            foreach ($request->file('ref_images') as $image) {
                $imagePaths[] = $image->store('custom-orders', 'public');
            }
        }

        $customOrder = CustomOrder::create([
            'user_id' => $user->id,
            'description' => $validated['description'],
            'dimensions' => $validated['dimensions'],
            'material' => $validated['material'],
            'finishing' => $validated['finishing'],
            'color' => $validated['color'] ?? null,
            'ref_images' => $imagePaths,
            'status' => CustomOrder::STATUS_SUBMITTED,
        ]);

        // Send Custom Order Submitted Confirmation Email
        try {
            Mail::to($user->email)->queue(new CustomOrderSubmittedMail($customOrder));
        } catch (\Throwable) {
            // Don't block if email fails
        }

        // Send guest credentials if new guest
        if ($isNewGuest && isset($user->temp_password)) {
            try {
                Mail::to($user->email)->queue(new GuestCredentialsMail($user, $user->temp_password));
            } catch (\Throwable) {
                // Don't block if email fails
            }
        }
        
        $message = 'Custom order berhasil diajukan! Tim kami akan meninjau pesanan Anda.';
        if ($isNewGuest) {
            $message = 'Custom order berhasil diajukan! Untuk dapat kami proses, mohon cek email Anda dan klik link aktivasi akun yang telah kami kirimkan.';
        } elseif ($user->is_guest || !$user->email_verified_at) {
            $message = 'Custom order berhasil diajukan! Untuk dapat kami proses, pastikan Anda telah mengaktivasi akun melalui link yang dikirim ke email Anda.';
        }

        if (auth()->check()) {
            return redirect()->route('customer.custom-orders')->with('success', $message);
        }

        return redirect()->route('home')->with('success', $message);
    }
}
