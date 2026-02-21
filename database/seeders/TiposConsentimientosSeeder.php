<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoConsentimiento;

class TiposConsentimientosSeeder extends Seeder
{
    public function run(): void
    {
        $consentimientos = [
            ['consentimiento' => 'Consent_ID1'],
            ['consentimiento' => 'Consent_ID2'],
            ['consentimiento' => 'Consent_ID3'],
        ];

        foreach ($consentimientos as $consentimiento) {
            TipoConsentimiento::updateOrCreate(
                ['consentimiento' => $consentimiento['consentimiento']],
                $consentimiento
            );
        }
    }
}
