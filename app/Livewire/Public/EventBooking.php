<?php

namespace App\Livewire\Public;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PromoCode;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class EventBooking extends Component
{
    public Event $event;
    public $ticketTypes;
    public array $quantities = []; // ticket_type_id => quantity
    public array $attendees = []; // index => ['name' => '', 'email' => '', 'ticket_type_id' => '']
    public string $promoCode = '';
    public ?PromoCode $appliedPromo = null;

    public float $subtotal = 0;
    public float $discountAmount = 0;
    public float $adminFee = 5000; // Flat payment admin fee Rp 5.000
    public float $total = 0;

    public string $validationError = '';
    public string $promoError = '';
    public string $promoSuccess = '';

    protected $rules = [
        'attendees.*.name' => 'required|string|min:3',
        'attendees.*.email' => 'required|email',
    ];

    protected $messages = [
        'attendees.*.name.required' => 'Nama lengkap peserta wajib diisi.',
        'attendees.*.name.min' => 'Nama lengkap minimal 3 karakter.',
        'attendees.*.email.required' => 'Email peserta wajib diisi.',
        'attendees.*.email.email' => 'Format email tidak valid.',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->ticketTypes = $event->ticketTypes()->where('is_active', true)->get();
        foreach ($this->ticketTypes as $type) {
            $this->quantities[$type->id] = 0;
        }
        $this->calculateTotals();
    }

    public function updatedQuantities()
    {
        // Sanitize quantities
        foreach ($this->quantities as $id => $qty) {
            $type = TicketType::find($id);
            if (!$type) continue;

            $qty = intval($qty);
            if ($qty < 0) $qty = 0;

            // Check stock limit
            $availableStock = $type->available_stock;
            if ($qty > $availableStock) {
                $qty = $availableStock;
                $this->validationError = "Stok tiket '{$type->name}' terbatas, hanya tersisa {$availableStock} tiket.";
            }

            // Check transaction limit
            if ($qty > $type->max_per_transaction) {
                $qty = $type->max_per_transaction;
                $this->validationError = "Maksimum pembelian tiket '{$type->name}' adalah {$type->max_per_transaction} per transaksi.";
            }

            $this->quantities[$id] = $qty;
        }
    }

    public function incrementTicket($typeId)
    {
        $this->validationError = '';
        $type = TicketType::find($typeId);
        if (!$type) return;

        $currentQty = $this->quantities[$typeId] ?? 0;
        $qty = $currentQty + 1;

        // Check stock limit
        $availableStock = $type->available_stock;
        if ($qty > $availableStock) {
            $qty = $availableStock;
            $this->validationError = "Stok tiket '{$type->name}' terbatas, hanya tersisa {$availableStock} tiket.";
        }

        // Check transaction limit
        if ($qty > $type->max_per_transaction) {
            $qty = $type->max_per_transaction;
            $this->validationError = "Maksimum pembelian tiket '{$type->name}' adalah {$type->max_per_transaction} per transaksi.";
        }

        $this->quantities[$typeId] = $qty;
        $this->calculateTotals();
        $this->rebuildAttendeeFields();
    }

    public function decrementTicket($typeId)
    {
        $this->validationError = '';
        $currentQty = $this->quantities[$typeId] ?? 0;
        $qty = $currentQty - 1;
        if ($qty < 0) $qty = 0;

        $this->quantities[$typeId] = $qty;
        $this->calculateTotals();
        $this->rebuildAttendeeFields();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        foreach ($this->quantities as $id => $qty) {
            $type = $this->ticketTypes->firstWhere('id', intval($id));
            if ($type && $qty > 0) {
                $this->subtotal += $type->price * $qty;
            }
        }

        // Apply discount if promo is active
        if ($this->appliedPromo) {
            // Check if promo code is still valid for current selection
            $validForSelection = true;
            if ($this->appliedPromo->ticket_type_id) {
                $qtySelectedForPromo = $this->quantities[$this->appliedPromo->ticket_type_id] ?? 0;
                if ($qtySelectedForPromo === 0) {
                    $validForSelection = false;
                }
            }

            if ($validForSelection) {
                $this->discountAmount = $this->appliedPromo->calculateDiscount($this->subtotal);
            } else {
                $this->appliedPromo = null;
                $this->discountAmount = 0;
                $this->promoError = 'Kode promo tidak berlaku untuk jenis tiket yang Anda pilih.';
                $this->promoSuccess = '';
            }
        } else {
            $this->discountAmount = 0;
        }

        $this->total = max(0, $this->subtotal - $this->discountAmount + ($this->subtotal > 0 ? $this->adminFee : 0));
    }

    public function rebuildAttendeeFields()
    {
        $newAttendees = [];
        $index = 0;

        foreach ($this->quantities as $typeId => $qty) {
            for ($i = 0; $i < $qty; $i++) {
                // Keep existing inputs if possible
                $existing = collect($this->attendees)->firstWhere('ticket_type_id', intval($typeId));
                $newAttendees[$index] = [
                    'name' => $existing['name'] ?? '',
                    'email' => $existing['email'] ?? '',
                    'ticket_type_id' => intval($typeId)
                ];
                $index++;
            }
        }

        $this->attendees = $newAttendees;
    }

    public function applyPromo()
    {
        $this->promoError = '';
        $this->promoSuccess = '';

        if (empty($this->promoCode)) {
            $this->promoError = 'Harap masukkan kode promo.';
            return;
        }

        if ($this->subtotal === 0.0) {
            $this->promoError = 'Pilih tiket terlebih dahulu sebelum menggunakan kode promo.';
            return;
        }

        $promo = PromoCode::where('code', strtoupper($this->promoCode))->first();

        if (!$promo) {
            $this->promoError = 'Kode promo tidak ditemukan.';
            return;
        }

        // Validate promo code
        $ticketTypeIdToCheck = $promo->ticket_type_id;
        if (!$promo->isValid($ticketTypeIdToCheck)) {
            $this->promoError = 'Kode promo sudah kedaluwarsa atau kuota habis.';
            return;
        }

        // Check if matching ticket type is in current selection
        if ($promo->ticket_type_id) {
            $selectedQty = $this->quantities[$promo->ticket_type_id] ?? 0;
            if ($selectedQty === 0) {
                $type = TicketType::find($promo->ticket_type_id);
                $this->promoError = "Kode promo ini hanya berlaku untuk tiket jenis '{$type->name}'.";
                return;
            }
        }

        $this->appliedPromo = $promo;
        $this->calculateTotals();
        $this->promoSuccess = 'Kode promo berhasil digunakan!';
    }

    public function removePromo()
    {
        $this->appliedPromo = null;
        $this->promoCode = '';
        $this->promoSuccess = '';
        $this->promoError = '';
        $this->calculateTotals();
    }

    public function submitBooking(PaymentGatewayInterface $gateway)
    {
        $this->validationError = '';

        if ($this->subtotal <= 0) {
            $this->validationError = 'Silakan pilih minimal 1 tiket untuk melanjutkan.';
            return;
        }

        // Run validation on attendee inputs
        $this->validate();

        try {
            $order = DB::transaction(function () use ($gateway) {
                // Re-verify stocks in transaction
                foreach ($this->quantities as $typeId => $qty) {
                    if ($qty <= 0) continue;

                    $type = TicketType::lockForUpdate()->find($typeId);
                    if ($type->sold_count + $qty > $type->quota) {
                        throw new \Exception("Maaf, kuota tiket '{$type->name}' baru saja habis.");
                    }
                    
                    // Increment sold count
                    $type->increment('sold_count', $qty);
                }

                // Generate Order Number
                $orderNumber = 'TQW-' . strtoupper(Str::random(3)) . '-' . now()->format('ymdHis');

                // Create Order
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => auth()->id(),
                    'event_id' => $this->event->id,
                    'status' => 'pending',
                    'subtotal' => $this->subtotal,
                    'discount' => $this->discountAmount,
                    'admin_fee' => $this->adminFee,
                    'total' => $this->total,
                    'promo_code_id' => $this->appliedPromo?->id,
                    'expired_at' => now()->addMinutes(60),
                ]);

                // Create Order Items
                foreach ($this->attendees as $attendee) {
                    $type = TicketType::find($attendee['ticket_type_id']);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'ticket_type_id' => $attendee['ticket_type_id'],
                        'qty' => 1,
                        'price_each' => $type->price,
                        'attendee_name' => $attendee['name'],
                        'attendee_email' => $attendee['email'],
                    ]);
                }

                // If promo code applied, increment used count
                if ($this->appliedPromo) {
                    $this->appliedPromo->increment('used_count');
                }

                return $order;
            });

            // Call Payment Gateway Snap Token API
            $paymentResult = $gateway->createTransaction($order);

            // Save Snap Token to Payment table
            Payment::create([
                'order_id' => $order->id,
                'gateway' => 'midtrans',
                'gateway_transaction_id' => null,
                'payment_method' => null,
                'amount' => $order->total,
                'status' => 'pending',
                'raw_payload' => ['snap_token' => $paymentResult['token'], 'redirect_url' => $paymentResult['redirect_url']],
            ]);

            // Redirect directly to the checkout status page where Snap is invoked
            return redirect()->route('checkout.status', $order->order_number);

        } catch (\Exception $e) {
            $this->validationError = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.public.event-booking');
    }
}
