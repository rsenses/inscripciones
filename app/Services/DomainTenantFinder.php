<?php

namespace App\Services;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class DomainTenantFinder extends TenantFinder
{
    use UsesTenantModel;

    public function findForRequest(Request $request): ?Tenant
    {
        $host = str_replace('.localhost', '', request()->getHost());
        $hostNames = explode('.', $host);
        if (count($hostNames) > 3) {
            abort(500, 'Error, dominio muy largo');
        }
        if (count($hostNames) === 3) {
            array_shift($hostNames);
        }
        $domain = join('.', $hostNames);

        if (in_array($domain, ['unidadeditorial.es', 'marca.com', 'telva.com', 'elmundo.es', 'expansion.com'])) {
            $domain = 'unidadeditorial.es';
        }

        return $this->getTenantModel()::whereDomain($domain)->first();
    }
}
