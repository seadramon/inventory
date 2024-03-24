<table>
    <thead>
        <tr>
            <th rowspan="2" colspan="8" style="text-align: center; vertical-align: middle;">DAFTAR INVENTARIS, GEDUNG dan FASILITASNYA</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th style="border: 1px solid #000000;">No Urut</th>
            <th style="border: 1px solid #000000;">Nama Barang / Inventaris</th>
            <th style="border: 1px solid #000000;">Merk / Tipe / Spesifikasi Lainnya</th>
            <th style="border: 1px solid #000000;" colspan="2">Kuantum / Volume</th>
            <th style="border: 1px solid #000000;">Kode Inventaris</th>
            <th style="border: 1px solid #000000;">Masa Perawatan</th>
            <th style="border: 1px solid #000000;">Keterangan / Lokasi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($inventories as $key => $inventory)
        <tr>
            <td style="border: 1px solid #000000; width: 100%; text-align: center;">{{ $key+1 }}</td>
            <td style="border: 1px solid #000000; width: 350%;">{{ $inventory->nama }}</td>
            <td style="border: 1px solid #000000; width: 350%;">{{ $inventory->merk }}, {{ $inventory->tipe }}, {{ $inventory->spek }}</td>
            <td style="border: 1px solid #000000; width: 100%; text-align: center;">1</td>
            <td style="border: 1px solid #000000; width: 100%; text-align: center;">pcs</td>
            <td style="border: 1px solid #000000; width: 200%; text-align: center;">{{ $inventory->kode }}</td>
            <td style="border: 1px solid #000000; width: 200%; text-align: center;">{{ $inventory->tahun_perolehan }}</td>
            <td style="border: 1px solid #000000; width: 350%;">{{ $inventory->lokasi?->ket }}</td>
        </tr>
    @endforeach
    </tbody>
</table>