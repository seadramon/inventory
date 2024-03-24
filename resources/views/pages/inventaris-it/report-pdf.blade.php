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
        <h3 colspan="8" style="text-align: left;">DAFTAR INVENTARIS DESKTOP PC</h3>
        <h3 colspan="8" style="text-align: left;">{{ $pat->ket }}</h3>

        <table>
            <thead style="text-align: center">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nomor Inventaris</th>
                    <th rowspan="2">Unit Kerja</th>
                    <th rowspan="2">User</th>
                    <th colspan="2">System Unit</th>
                    <th rowspan="2">IP Address</th>
                    <th rowspan="2">MAC Address</th>
                    <th rowspan="2">Software</th>
                </tr>
                <tr>
                    <th>Merk</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
            @foreach($inventories as $key => $inventory)
                <tr>
                    <td valign="top">{{ $key+1 }}</td>
                    <td valign="top">{{ $inventory->no_inventaris }}</td>
                    <td valign="top">{{ $inventory->pat->ket }}</td>
                    <td valign="top">{{ $inventory->pengguna }}</td>
                    <td valign="top">{{ !empty($inventory->merk)?$inventory->merk->ket:"" }}</td>
                    <td valign="top">{{ !empty($inventory->tipe_pc)?$inventory->tipe_pc->ket:"" }}</td>
                    <td valign="top">{{ $inventory->ip4_address }}</td>
                    <td valign="top">{{ $inventory->mac_address }}</td>
                    <td>
                        @if (count($inventory->pc_softwares) > 0)
                            <?php $i = 1; ?>
                            @foreach ($inventory->pc_softwares as $pc_software)
                                @if ($pc_software->software->jenis_lisensi == "perangkat")
                                    <?php 
                                        $serialKey = $pc_software->serial_key;
                                    ?>
                                @else
                                    <?php 
                                        $serialKey = $pc_software->software->serial_key;
                                    ?>
                                @endif

                                {{ $i.'. '.$pc_software->software->nama.' | '.$serialKey }}<br>

                                <?php $i++; ?>
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table> 
    </body>
</html>