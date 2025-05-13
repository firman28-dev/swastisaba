<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tatanan {{$district->name}}_Tahun 2023-2024</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
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
            vertical-align: middle;
        }

        h1 {
            text-align: center;
        }

        .category-title {
            margin-top: 40px;
            text-align: start;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        tr {    
            page-break-inside: avoid;
        }
    </style>
</head>
<body onload="print()">
    <h1>
        Tatanan Seluruh Kategori {{$district->name}} <br> Tahun 2023-2024
    </h1>
   
    @foreach ($categories as $category)
        @if (!$loop->first)
            <div style="page-break-before: always;"></div> <!-- Tambahkan pemisah halaman -->
        @endif  
        <div class="category-title">
            {{$loop->iteration}}. Tatanan {{$category->name}}
        </div>
        <table>
            <thead>
                <tr >
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Pertanyaan</th>
                    <th colspan="4">Self Assesment Kab/Kota</th>
                    <th colspan="4">Provinsi</th>
    
                </tr>
                <tr>
                    <th>Nilai Assessment</th>
                    <th>Angka</th>
                    <th>Keterangan</th>
                    <th>Dokumen</th>
    
                    <th>Nilai Assessment</th>
                    <th>Angka</th>
                    <th>Catatan Verifikasi</th>
                    <th>Dokumen</th>

    
                </tr>
            </thead>
            <tbody>
                @php
                    $questionsV2 = $questions->where('id_category', $category->id);

                    $totalSelfAssessment = 0;
                    $totalProvScore = 0;
                    $totalPusatScore = 0;
                @endphp
                @if($questionsV2->isNotEmpty())
                    @foreach ($questionsV2 as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="max-width: 200px">{{ $item->name }}</td>

                    @php
                        $relatedAnswer = $answer->where('id_question', $item->id)->first(); // This will return a single instance or null
                        $uploadedFile = $uploadedFiles->where('id_question', $item->id);
                        
                        $totalSelfAssessment += $relatedAnswer->_q_option->score ?? 0;
                        $totalProvScore += $relatedAnswer->_q_option_prov->score ?? 0;
                        $totalPusatScore += $relatedAnswer->_q_option_pusat->score ?? 0;
                    @endphp

                    @if($relatedAnswer)
                        <td style="max-width: 400px">{{ $relatedAnswer->_q_option->name }}</td>
                        <td style="text-align: center">{{ $relatedAnswer->_q_option->score }}</td>
                        <td>
                            <div>Sudah dijawab</div>
                        </td>
                        @if ($uploadedFile->isNotEmpty())
                            <td>
                                <div>Sudah diupload</div>
                            </td>
                        @else
                            <td class="border-1 border text-center p-3">
                                <div class="badge badge-light-danger">Belum diupload</div>
                            </td>
                        @endif


                        <td>{{ $relatedAnswer->_q_option_prov->name?? '-' }}</td>
                        <td style="text-align: center">{{ $relatedAnswer->_q_option_prov->score??'0'}}</td>
                        <td>
                            @if($relatedAnswer && $relatedAnswer->comment_prov)
                                {{ $relatedAnswer->comment_prov }}
                            @else
                                <div class="badge badge-light-danger">Belum dijawab</div>
                            @endif
                        </td>
                        <td class="border-1 border p-3">
                            Agar diuploadkan data dukung gabungan capaian tahun 2023 2024 pada menu 2024
                        </td>

                    @else
                    <td>-</td>
                    <td style="text-align: center">0</td>
                    <td>
                        <div class="badge badge-light-danger">Belum dijawab</div>
                    </td>
                    <td>-</td>

                    <td>-</td>
                    <td style="text-align: center">0</td>
                    <td>Belum dijawab</td>  
                    <td>Agar diuploadkan data dukung gabungan capaian tahun 2023 2024</td>

                    @endif
                    </tr>

                    @endforeach
                @endif
                
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td  align="center"><strong>{{ $totalSelfAssessment }}</strong></td>
                    <td colspan="3"></td>
                    <td  align="center"><strong>{{ $totalProvScore }}</strong></td>
                    <td colspan="2" ></td>
                </tr>
            
            </tbody>
        </table>
    @endforeach
    
    {{-- <table width="100%" border="0" style="margin-top: 50px">
        <tr>
            <td width="50%" align="center"><div>Tim Verifikasi Provinsi</div>
                <p align="center">&nbsp;</p>
            </td>
            <td width="50%" align="center"><div>Perwakilan Kab/Kota</div>
                <div style="text-align:center;">{{$jabatan}}</div>
                <p align="center">&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <div style="text-align:center;">
                    <div><strong><u>{{$operator}}</u></strong></div>
                     <div style="padding-left:1px;"> <?php //echo $data->row()->jabatan_opd;?></div> 
                </div>
            </td>
            <td align="center">
                <div>
                    <div><strong><u> {{$pembahas}}</u></strong></div>
                    <div style="padding-left:10px;"><?php //echo $data->row()->jabatan_kabkota;?></div> 
                </div>
            </td>
        </tr>
    </table>  --}}
</body>
</html>