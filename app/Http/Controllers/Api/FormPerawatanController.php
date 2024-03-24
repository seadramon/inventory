<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormPerawatanResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\FormPerawatan;
use App\Models\FormPerawatanDetail;
use App\Models\FormPerawatanAssign;
use App\Http\Resources\PerawatanResource;

class FormPerawatanController extends Controller
{
    //
    public function index($kdPat)
    {
    	$data = FormPerawatan::with([
				'detail',
				'latest_assign' => function($sql) use($kdPat) {
					$sql->where('kd_pat', '=', $kdPat);
					$sql->with('perawatan.detail');
				}
			])
			->whereHas('assigns', function($query) use($kdPat) {
				$query->where('kd_pat', '=', $kdPat);
			})
			->get();
    	
    	return FormPerawatanResource::collection($data);
    }
}
