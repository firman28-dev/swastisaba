<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Berita Acara Verifikasi {{$district->name}}</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 40px;
    }
    h2, h3 {
      text-align: center;
    }
    p, ul {
      text-align: justify;
    }
    .bold {
      font-weight: bold;
    }
    .center {
      text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    th, td {
        border: 1px solid #000;
        padding: 8px;
        word-wrap: break-word;
        vertical-align: top;
    }
    .page-break {
        page-break-before: always;
        break-before: page;
    }
  </style>
</head>
<body>
    @php
        $districtFullName = $district->area_type_id == 1 ? str_replace('Kab.', 'Kabupaten', $district->name) : $district->name;
        $wali_bup = $district->area_type_id == 1 ? 'Bupati' : 'Wali Kota';
        $wali_bup_v2 = preg_replace('/^(Kota |Kab\. )/', '', $district->name);

        $logoFile = '';

        switch ($district->id) {
            case '1301': $logoFile = 'Kab_Pessel.png'; break;
            case '1302': $logoFile = 'Kab_Solok.png'; break;
            case '1303': $logoFile = 'Kab_Sijunjung.png'; break;
            case '1304': $logoFile = 'Kab_Tanah Datar.png'; break;
            case '1305': $logoFile = 'Kab_Padang Pariaman.png'; break;
            case '1306': $logoFile = 'Kab_Agam.png'; break;
            case '1307': $logoFile = 'Kab_50 Kota.png'; break;
            case '1308': $logoFile = 'Kab_Pasaman.png'; break;
            case '1309': $logoFile = 'Kab_Kep_Mentawai.png'; break;
            case '1310': $logoFile = 'Kab_Dharmasraya.png'; break;
            case '1311': $logoFile = 'Kab_Solok_Selatan.png'; break;
            case '1312': $logoFile = 'Kab_Pasbar.png'; break;

            case '1371': $logoFile = 'Kota_Padang.png'; break;
            case '1372': $logoFile = 'Kota_Solok.png'; break;
            case '1373': $logoFile = 'Kota_Sawahlunto.png'; break;
            case '1374': $logoFile = 'Kota_Padang Panjang.png'; break;
            case '1375': $logoFile = 'Kota_Bukittinggi.png'; break;
            case '1376': $logoFile = 'Kota_Payakumbuh.png'; break;
            case '1377': $logoFile = 'Kota_Pariaman.png'; break;

            default: $logoFile = 'default.png'; break;
        }

    @endphp
    <div class="center">
        <img src="{{asset('assets/media/sumbar.png')}}" alt="sumbar" style="width: 55px">
        &nbsp;
        <img src="{{asset('assets/media/icon-kabkota/'. $logoFile)}}" alt="Kab/kota" style="width: 50px">
    </div>
 
  <h3>BERITA ACARA</h3>
  <h3 style="text-transform: uppercase;">VERIFIKASI USULAN DOKUMEN PENYELENGGARAAN<br>
  KABUPATEN/KOTA SEHAT TINGKAT {{ $districtFullName }}<br>
  TAHUN 2025</h3>

  <p>Pada hari <span class="bold">{{$day_id}}</span>, tanggal <span class="bold">{{$date_id}}</span> bulan <i> Mei </i> tahun <i> Dua Ribu Dua Puluh Lima </i> bertempat di <i> Bappeda Provinsi Sumatera Barat</i>, telah dilaksanakan verifikasi oleh Tim Pembina Kabupaten/Kota Sehat Tingkat Provinsi Sumatera Barat yang terdiri dari Bappeda (Ketua Tim Pembina), Dinas Kesehatan (Sekretaris Tim Pembina) dan Perangkat Daerah Provinsi (Anggota Tim Pembina) terhadap usulan dokumen penyelenggaraan <span class="bold">{{$districtFullName}}</span> Sehat yang disampaikan oleh Tim Pembina <span class="bold">{{$districtFullName}}</span> Sehat (Bappeda dan Dinas Kesehatan) serta Forum <span class="bold">{{$districtFullName}}</span> Sehat sebagaimana tercantum dalam daftar hadir peserta dalam Lampiran I Berita Acara ini.</p>

  <p>Setelah memperhatikan, mendengar dan mempertimbangkan :</p>
  <ol type="1">
    <li>Usulan dokumen penyelenggaraan <span class="bold">{{ $districtFullName }}</span> Sehat untuk mengikuti penilaian penyelenggaraan Kabupaten/Kota Sehat Tingkat Nasional Tahun 2025 yang diajukan oleh Tim Pembina <span class="bold">{{$districtFullName}}</span> Sehat dan Forum <span class="bold">{{$districtFullName}}</span> Sehat, yang terdiri dari :
      <ol type="a">
        <li>Usulan dokumen penyelenggaraan <span class="bold">{{$districtFullName}}</span> Sehat Tahun 2023</li>
        <li>Usulan dokumen penyelenggaraan <span class="bold">{{$districtFullName}}</span> Sehat Tahun 2024</li>
      </ol>
    </li>
    <li>Hasil verifikasi yang dilakukan oleh Tim Pembina Kabupaten/Kota Sehat Tingkat Provinsi Sumatera Barat yang terdiri dari Bappeda (Ketua Tim Pembina), Dinas Kesehatan (Sekretaris Tim Pembina) dan Perangkat Daerah Provinsi (Anggota Tim Pembina), maka :</li>
  </ol>

  
  <h3 class="center">MENYEPAKATI :</h3>

  <ol>
    <li>Tim Pembina <span class="bold">{{$districtFullName}}</span> Sehat beserta Forum <span class="bold">{{$districtFullName}}</span> Sehat akan melakukan perbaikan usulan dokumen dan data dukung penyelenggaraan <span class="bold">{{$districtFullName}}</span> Sehat pada Tahun 2023 dan Tahun 2024 sesuai hasil verifikasi Tim Pembina Kabupaten/Kota Sehat Tingkat Provinsi sebagaimana Lampiran II Berita Acara ini.</li>
    
    <li>Perbaikan usulan dokumen dan data dukung penyelenggaraan <span class="bold">{{$districtFullName}}</span> Sehat Tahun 2023 dan Tahun 2024 dilakukan secara elektronik dan terdokumentasi pada Aplikasi Swastisaba pada tanggal 17 – 23 Mei 2025.</li>

    <li> Usulan dokumen dan data dukung penyelenggaraan <span class="bold">{{$districtFullName}}</span> Sehat Tahun 2023 dan Tahun 2024 yang telah diperbaiki oleh Tim Pembina <span class="bold">{{$districtFullName}}</span> Sehat beserta Forum <span class="bold">{{$districtFullName}}</span> Sehat akan disampaikan oleh Tim Pembina <span class="bold">{{$districtFullName}}</span> Sehat melalui surat {{ $wali_bup }} <span class="bold"> {{$wali_bup_v2}}</span> kepada Gubernur c.q. Kepala Bappeda Provinsi Sumatera Barat, dengan tembusan Kepala Dinas Kesehatan Provinsi Sumatera Barat yang akan diteruskan kepada Tim Pembina Kabupaten/Kota Sehat Tingkat Pusat sebagai bahan penilaian penyelenggaraan Kabupaten/Kota Sehat tingkat Nasional Tahun 2025.</li>
  </ol>

  <p>Demikian berita acara ini dibuat dan disahkan untuk digunakan sebagaimana mestinya.</p>

  {{-- <div class="page-break"> --}}
    <h3 class="center">MENYETUJUI :</h3>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th style="width: 35%">LEMBAGA</th>
                <th style="width: 20%">NAMA</th>
                <th>JABATAN</th>
                <th style="width: 20%">TANDA TANGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center">1</td>
                <td>Bappeda Provinsi selaku Ketua Tim Pembina KKS Tingkat Provinsi</td>
                <td>{{$bappeda_prov->name}}</td>
                <td>{{$bappeda_prov->jabatan}}</td>
                <td></td>
            </tr>
            <tr>
                <td class="center">2</td>
                <td>Dinas Kesehatan selaku Sekretaris Tim Pembina KKS Tingkat Provinsi</td>
                <td>{{$dinkes_prov->name}}</td>
                <td>{{$dinkes_prov->jabatan}}</td>
                <td></td>
            </tr>
            <tr>
                <td class="center">3</td>
                <td>SKPD <span class="bold"> {{$skpd->name}}  </span>selaku Perwakilan Perangkat Daerah Provinsi selaku Anggota Tim Pembina KKS Tingkat Provinsi </td>
                <td>{{$nama_skpd_prov}}</td>
                <td>{{$jb_skpd_prov}}</td>
                <td></td>
            </tr>
            <tr>
                <td class="center">4</td>
                <td>Bappeda <span class="bold"> {{$districtFullName}} </span> selaku Ketua Tim Pembina KKS Tingkat <span class="bold">{{$districtFullName}}</span></td>
                <td>{{$nama_bappeda_kab_kota}}</td>
                <td>{{$jb_bappeda_kab_kota}}</td>
                <td></td>
            </tr>
            <tr>
                <td class="center">5</td>
                <td>Dinas Kesehatan <span class="bold"> {{$districtFullName}} </span> selaku Sekretaris Tim Pembina KKS Tingkat <span class="bold">{{$districtFullName}}</span></td>
                <td>{{$nama_dinkes_kab_kota}}</td>
                <td>{{$jb_dinkes_kab_kota}}</td>
                <td></td>
            </tr>
            <tr>
                <td class="center">6</td>
                <td>Forum <span class="bold"> {{$districtFullName}} </span> Sehat</td>
                <td>{{$nama_forum_kab_kota}}</td>
                <td>{{$jb_forum_kab_kota}}</td>
                <td style="padding: 30px"></td>
            </tr>
        </tbody>
    </table>
  {{-- </div> --}}

</body>
</html>
