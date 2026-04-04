<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RegisterWhatsAppNumber extends Command
{
    protected $signature = 'whatsapp:register {pin? : A 6-digit PIN you choose for 2-step verification}';
    protected $description = 'Registers your WhatsApp phone number with the Cloud API to fix Account not registered error';

    public function handle()
    {
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $token         = env('WHATSAPP_ACCESS_TOKEN');

        if (!$phoneNumberId || !$token) {
            $this->error('WHATSAPP_PHONE_NUMBER_ID or WHATSAPP_ACCESS_TOKEN is missing in .env');
            return 1;
        }

        $pin = $this->argument('pin');

        if (!$pin) {
            $pin = $this->ask('Enter a 6-digit PIN for WhatsApp 2-step verification (you will need this pin again if you re-register)');
        }

        if (!preg_match('/^\d{6}$/', $pin)) {
            $this->error('PIN must be exactly 6 digits. Example: 123456');
            return 1;
        }

        $this->info("Registering phone number ID: {$phoneNumberId} with WhatsApp Cloud API...");

        $response = Http::withToken($token)
            ->post("https://graph.facebook.com/v21.0/{$phoneNumberId}/register", [
                'messaging_product' => 'whatsapp',
                'pin'               => $pin,
            ]);

        $body = $response->json();

        if ($response->successful() && isset($body['success']) && $body['success']) {
            $this->info('✅ Phone number registered successfully! Status is now Connected.');
            $this->info('You can now send messages. Run: php artisan whatsapp:test 91XXXXXXXXXX');
        } else {
            $this->error('❌ Registration failed!');
            $this->line('Response: ' . json_encode($body, JSON_PRETTY_PRINT));

            if (isset($body['error']['code'])) {
                $code = $body['error']['code'];
                $msg  = $body['error']['message'] ?? '';

                if ($code === 133015) {
                    $this->warn('This number is currently on the WhatsApp mobile app. You must delete WhatsApp from the physical phone before registering with Cloud API.');
                } elseif ($code === 133016) {
                    $this->warn('Wrong PIN. If you previously set a PIN, use the same one. Or wait 7 days for the PIN reset period.');
                } elseif ($code === 133010) {
                    $this->warn('Account still not registered. Check if you have a valid payment method linked to your WhatsApp Business Account.');
                } else {
                    $this->warn("Error code: {$code} — {$msg}");
                }
            }
        }

        return 0;
    }
}
