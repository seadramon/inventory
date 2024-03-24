<table>
	@if (count($data) > 0)
		<?php $i = 1; ?>

		<tr>
		@foreach($data as $row)
			<td style="padding-left: 1em;padding-right: 1em;">
				<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(150)->generate($row->kode)) }} "><br>
				<p style="text-align: center;font-size: 10px">{{ $row->kode.'|'.$row->name }}</p>
				<p style="text-align: center;font-size: 10px;margin-top: -10px;">{{ '('.$row->lokasi->kd_pat .' - '.$row->lokasi->ket.')' }}</p>
			</td>

			@if ( $i % 4 == 0 )
				@if ($i == count($data))
					</tr>
				@else
					</tr>
					<tr>
				@endif
			@endif

			<?php $i++; ?>
		@endforeach
	@else
		<div style="text-align: center">
			<h2>Data tidak ditemukan</h2>
		</div>
	@endif
</table>