<html>
    <head>
        <style>
            body {
                font-size: 11px;
            }

            table {
                table-layout: auto; 
                width:100%;
                border-collapse: collapse;
            }

            table, th, td {
                border: 1px solid;
            }
        </style>
    </head>

    <body>
        <h3 colspan="8" style="text-align: center;">DAFTAR INVENTARIS, GEDUNG & FASILITASNYA</h3>

        <table>
            <thead style="text-align: center">
                <tr>
                    <th>No Urut</th>
                    <th>Nama Barang / Inventaris</th>
                    <th>Merk / Tipe / Spesifikasi Lainnya</th>
                    <th colspan="2">Kuantum / Volume</th>
                    <th>Kode Inventaris</th>
                    <th>Masa Perawatan</th>
                    <th>Keterangan / Lokasi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($inventories as $key => $inventory)
                <tr>
                    <td style="width: 5%; text-align: center;">{{ $key+1 }}</td>
                    <td style="width: 20%">{{ $inventory->nama }}</td>
                    <td style="width: 30%">{{ $inventory->merk }}, {{ $inventory->tipe }}, {{ $inventory->spek }}</td>
                    <td style="width: 5%; text-align: center;">1</td>
                    <td style="width: 5%; text-align: center;">pcs</td>
                    <td style="width: 10%; text-align: center;">{{ $inventory->kode_inventaris }}</td>
                    <td style="width: 5%; text-align: center;">{{ $inventory->tahun_perolehan }}</td>
                    <td style="width: 20%">{{ $inventory->lokasi?->ket }}</td>
                </tr>
            @endforeach
            </tbody>
        </table> 
    </body>
</html>