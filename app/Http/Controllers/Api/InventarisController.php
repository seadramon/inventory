<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\PcResource;
use App\Http\Resources\OfficeResource;
use App\Models\Pc;
use App\Models\Inventory;

class InventarisController extends Controller
{
    
    public function itDetail(Request $request, $code)
    {
        $code = str_replace('|', '/', $code);
    	$data = Pc::with(['merk', 'maintenances', 'detail', 'pc_softwares.software'])->findOrFail($code);

    	return new PcResource($data);
    }

    public function officeDetail(Request $request, $code)
    {
    	$data = Inventory::whereKode($code)->firstOrFail();;

    	return new OfficeResource($data);
    }
}
