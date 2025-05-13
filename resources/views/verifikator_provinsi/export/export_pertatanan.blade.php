<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tatanan_{{$category->name}}_{{$district->name}}_Tahun 2023-2024</title>
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
        Tatanan {{$category->name}}  <br> {{$district->name}} <br> Tahun 2023-2024
    </h1>
    <table>
        <thead>
            <tr >
                <th rowspan="2">No.</th>
                <th rowspan="2">Pertanyaan</th>
                <th colspan="4">Self Assesment Kab/Kota</th>
                <th colspan="4">Provinsi</th>

            </tr>
            <tr class="fw-semibold fs-6 text-muted">
                <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                <th class="text-center border-1 border align-middle p-3">Angka</th>
                <th class="text-center border-1 border align-middle p-3">Keterangan</th>
                <th class="text-center border-1 border align-middle p-3">Dokumen</th>

                <th class="text-center border-1 border align-middle p-3">Nilai Assessment</th>
                <th class="text-center border-1 border align-middle p-3">Angka</th>
                <th class="text-center border-1 border align-middle p-3">Catatan Verifikasi</th>
                <th class="text-center border-1 border align-middle p-3">Status Dokumen</th>

            </tr>
        </thead>
        <tbody>
            @php
                $totalSelfAssessment = 0;
                $totalProvScore = 0;
                $totalPusatScore = 0;
            @endphp
            @foreach($questions as $question)
                <tr>
                    <td class="border-1 border text-center p-3">{{ $loop->iteration }}</td>
                    <td class="border-1 border p-3">{{ $question->name }}</td>
                    @php
                        $relatedAnswer = $answer->where('id_question', $question->id)->first(); // This will return a single instance or null
                        $uploadedFile = $uploadedFiles->where('id_question', $question->id);

                        $totalSelfAssessment += $relatedAnswer->_q_option->score ?? 0;
                        $totalProvScore += $relatedAnswer->_q_option_prov->score ?? 0;
                        $totalPusatScore += $relatedAnswer->_q_option_pusat->score ?? 0;
                    @endphp
                    @if($relatedAnswer)
                        <td class="border-1 border p-3">{{ $relatedAnswer->_q_option->name }}</td>
                        <td class="border-1 border text-center p-3" style="text-align: center">{{ $relatedAnswer->_q_option->score }}</td>
                        <td class="border-1 border text-center p-3">
                            <div class="badge badge-light-success">Sudah dijawab</div>
                        </td>
                        @if ($uploadedFile->isNotEmpty())
                            <td class="border-1 border text-center p-3">
                                <div class="badge badge-light-success">Sudah diupload</div>
                            </td>
                        @else
                            <td class="border-1 border text-center p-3">
                                <div class="badge badge-light-danger">Belum diupload</div>
                            </td>
                        @endif
                        

                        <td class="border-1 border p-3">{{ $relatedAnswer->_q_option_prov->name?? '-' }}</td>
                        <td class="border-1 border text-center p-3" style="text-align: center">{{ $relatedAnswer->_q_option_prov->score??'0'}}</td>
                        <td class="border-1 border p-3">
                            @if($relatedAnswer && $relatedAnswer->comment_prov)
                                {{ $relatedAnswer->comment_prov }}
                            @else
                                <div class="badge badge-light-danger">-</div>
                            @endif
                        </td>
                        <td class="border-1 border p-3">
                            Agar diuploadkan data dukung gabungan capaian tahun 2023 2024 pada menu 2024
                        </td>


                    @else
                        <td class="border-1 border p-3" style="text-align: center">-</td>
                        <td class="border-1 border p-3" style="text-align: center">0</td>
                        <td class="border-1 border p-3">
                            <div class="badge badge-light-danger">Belum dijawab</div>
                        </td>
                        <td class="border-1 border p-3">-</td>


                        <td class="border-1 border p-3" style="text-align: center">-</td>
                        <td class="border-1 border p-3" style="text-align: center">0</td>
                        <td class="border-1 border p-3">Belum dijawab</td>
                        <td class="border-1 border p-3" >
                            Agar diuploadkan data dukung gabungan capaian tahun 2023 2024 pada menu 2024
                        </td>


                        
                    @endif
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td style="text-align: center"><strong>{{ $totalSelfAssessment }}</strong></td>
                <td colspan="3"></td>
                <td style="text-align: center"><strong>{{ $totalProvScore }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
       
    </table>

    <table width="100%" border="0" style="margin-top: 50px">
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
            {{-- <td width="1%">&nbsp;</td> --}}
        </tr>
    </table> 
</body>
</html>