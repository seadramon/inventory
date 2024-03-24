<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
	<div class="col-6">
		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Tipe Perangkat</label>
			{!! Form::select('kd_tipe_pc', $tipe, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'kd_tipe_pc']) !!}
		</div>

		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Tipe Pengguna</label>
			{!! Form::select('tipe_pengguna', $tipe_pengguna, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'tipe_pengguna']) !!}
		</div>


		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Pengguna</label>
			<select class="form-select" id="pengguna" name="pengguna">
				@if(!empty($pengguna))
					<option value="{{ $pengguna->employee_id }}" selected >{{ $pengguna->first_name }} {{ $pengguna->last_name }}</option>
				@endif
			</select>
		</div>
		
		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Merk</label>
			{!! Form::select('kd_merk', $merk, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'kd_merk']) !!}
		</div>

		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Nama Komputer</label>
			{!! Form::text('pc_name', null, ['class'=>'form-control', 'id'=>'pc_name']) !!}
		</div>
		
		<div class="form-group hide">
			<label class="fs-6 fw-bold mt-2 mb-3">Workgroup</label>
			{!! Form::text('workgroup', null, ['class'=>'form-control', 'id'=>'workgroup']) !!}
		</div>

		<div class="form-group hide">
			<label class="fs-6 fw-bold mt-2 mb-3">Domain</label>
			{!! Form::text('domain', null, ['class'=>'form-control', 'id'=>'domain']) !!}
		</div>
		
		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Harga Perolehan</label>
			{!! Form::text('hrg_perolehan', null, ['class'=>'form-control decimal', 'id'=>'hrg_perolehan',]) !!}
			<div class="help-block">format nominal koma menggunakan titik (.)</div>
		</div>
	</div>
	<div class="col-6">
		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Tanggal Perolehan</label>
			{!! Form::text('tgl_perolehan', $data ? date('d-m-Y', strtotime($data->tgl_perolehan)) : null, ['class'=>'form-control datepicker', 'id'=>'tgl_perolehan']) !!}
		</div>

		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Model</label>
			{!! Form::text('model', null, ['class'=>'form-control', 'id'=>'model']) !!}
		</div>
		
		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">PAT/PPU</label>
			{!! Form::select('kd_pat', $pat, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'kd_pat']) !!}
		</div>
		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Biro Seleksi</label>
			{!! Form::select('kd_gas', $gas, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'kd_gas']) !!}
		</div>
		<div class="form-group hide">
			<label class="fs-6 fw-bold mt-2 mb-3">IP Address / Number</label>
			{!! Form::text('ip4_address', null, ['class'=>'form-control', 'id'=>'ip4_address']) !!}
		</div>
		
		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">MAC Address</label>
			{!! Form::text('mac_address', null, ['class'=>'form-control', 'id'=>'mac_address']) !!}
		</div>
		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Nilai Buku Saat ini</label>
			{!! Form::text('nilai_buku', null, ['class'=>'form-control decimal', "readonly" => true, 'id'=>'nilai_buku']) !!}
		</div>
		
		<div class="form-group">
			<label class="fs-6 fw-bold mt-2 mb-3">Status</label>
			{!! Form::select('status', $status, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'status']) !!}
		</div>
	</div>
</div>