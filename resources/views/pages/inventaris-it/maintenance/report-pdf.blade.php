<html>
    <head>
        <style>
            body {
                font-size: 11px;
            }

            .tengah {
                text-align: center;
                font-weight: bold;
            }

            table.content {
                table-layout: auto; 
                width:100%;
                border-collapse: collapse;
            }

            .content table, .content th, .content td {
                border: 1px solid;
            }
        </style>
    </head>

    <body>
        <h3 colspan="8" style="text-align: center;">KARTU DIAGNOSA & PENANGANAN PC/ NOTEBOOK/ PRINTER</h3>
        <table style="font-weight: bold;margin-bottom: 7px;margin-top: 3px;" border="0" width="40%">
            <tr>
                <td>NAMA PERANGKAT</td>
                <td>{{ !empty($data->tipe_pc)?$data->tipe_pc->ket:"" }}</td>
            </tr>
            <tr>
                <td>NO INVENTARIS</td>
                <td>{{ $data->no_inventaris }}</td>
            </tr>
            <tr>
                <td>PEMAKAI</td>
                <td>{{ $data->pengguna }}</td>
            </tr>
        </table>

        <table class="content">
            <thead style="text-align: center">
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">TANGGAL</th>
                    <th rowspan="2">MASALAH</th>
                    <th rowspan="2">DIAGNOSA</th>
                    <th rowspan="2">TINDAK LANJUT</th>
                    <th colspan="5">JENIS PENANGANAN</th>
                    <th rowspan="2">OLEH</th>
                    <th rowspan="2">TANGGAL SELESAI</th>
                    <th rowspan="2">USER</th>
                </tr>
                <tr>
                    <th>SERVICE RUTIN</th>
                    <th>UPGRADE</th>
                    <th>PERB.HW</th>
                    <th>PERB.SW</th>
                    <th>MUTASI</th>
                </tr>
            </thead>
            <tbody>
            @if (count($data->maintenances) > 0)
                @foreach($data->maintenances as $key => $inventory)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ date('d/m/Y', strtotime($inventory->created_at)) }}</td>
                        <td>{{ $inventory->permasalahan }}</td>
                        <td>{{ $inventory->diagnosa }}</td>
                        <td>{{ $inventory->tindak_lanjut }}</td>

                        <td class="tengah">{{ ($inventory->jenis_penanganan == 'service_rutin')?'X':"" }}</td>
                        <td class="tengah">{{ ($inventory->jenis_penanganan == 'upgrade')?'X':"" }}</td>
                        <td class="tengah">{{ ($inventory->jenis_penanganan == 'perb_hw')?'X':"" }}</td>
                        <td class="tengah">{{ ($inventory->jenis_penanganan == 'perb_sw')?'X':"" }}</td>
                        <td class="tengah">{{ ($inventory->jenis_penanganan == 'mutasi')?'X':"" }}</td>

                        <td>
                            @if (count($inventory->signature) > 0)
                                {{ $inventory->signature[0]->personal->getPenggunaAttribute() }}</td>
                            @endif
                        <td>{{ date('d/m/Y', strtotime($inventory->created_at)) }}</td>
                        <td>
                            @if (!empty($data->employee_id))
                                {{ $data->personal->getPenggunaAttribute() }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="13">
                        Data Kosong
                    </td>
                </tr>
            @endif
            </tbody>
        </table> 
    </body>
</html>