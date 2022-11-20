<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>PDF</title>
{{--    <link rel="stylesheet" href="{{url('assets/css/style.css')}}" />--}}
    <style>
        /********/
        /*@font-face {*/
        /*    font-family: Almarai-Regular;*/
        /*    src: url(../fonts/Almarai-Regular.ttf);*/
        /*}*/
        body {
            margin: 0;
        }
        .Almarai-Regular {
            /*font-family: Almarai-Regular, sans-serif;*/
        }

        .rtl{
            direction: rtl;
        }
        .col-md-6 {
            width: 50%;
        }
        .min_height {
            /* height: 1056px; */
            height: 100vh;
            background: linear-gradient(
                89.73deg,
                rgba(255, 255, 255, 0) 0.24%,
                #ffffff 55.19%
            );
        }
        .max_width {
            width: 90%;
            max-width: 696px;
            margin: 0 auto;
        }
        .pt-40 {
            padding-top: 40px;
        }
        .d-flex {
            display: flex;
        }
        .black-color{
            color: #000;
        }
        .primary-color {
            color: #32a7e2;
        }
        .second-color {
            color: #AD5A17;
        }
        .bg-primary {
            background: #eff3f9;
        }
        .bg-second {
            background: #335075;
        }
        .items-center {
            align-items: center !important;
        }
        .height-full {
            height: 100%;
        }
        .d-inlineblock{
            display: inline-block;
        }
        .broder_gray{
            border: 1px solid #EFEDE7;
            width: 100%;
            display: inline-block;
            margin: 16px 0;
        }
        @media print {
            .width_print {
                width: 100%;
                max-width: 100%;
            }
            th {
                font-weight: bold;
            }
        }
        /************project*********/
        img {
            max-width: 100%;
        }
        .h-65 {
            height: 65px;
        }
        .w-110 {
            width: 110px;
        }
        .shadow-img {
            box-shadow: 0 0px 5px #c1bdbd;
        }
        .flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .radius-4 {
            border-radius: 4px;
        }
        .items-center {
            align-items: center;
        }
        .justify-center {
            justify-content: center;
        }
        .justify-end {
            justify-content: end;
        }
        .mr-15 {
            margin-right: 15px;
        }
        .ml-15 {
            margin-left: 15px;
        }
        .mt-auto {
            margin-top: auto;
        }
        .flex-column {
            flex-direction: column;
        }
        .space-between {
            justify-content: space-between;
        }
        .footer {
            border-top: 1px solid #efede7;
            padding: 15px 0;
            margin-top: 40px;
        }
        .text-28{
            font-size: 28px;
        }
        .min-w-135{
            min-width: 140px
        }
        .min-w-150{
            min-width: 170px
        }
        .table td{
            line-height: 20px;
            font-size: 15px;
        }
        .mt-20{
            margin-top: 20px;
        }
        .w-430{
            width: 430px;
        }

        .w-65{
            width: 65%;
            float: left;
        }
        .w-36{
            width: 35%;
            float: left;
        }
        .text-15{
            font-size: 15px;
        }
        .mb-30{
            margin-bottom: 30px;
        }
        .mb-15{
            margin-bottom: 15px;
        }
        .mx-15{
            margin: 15px 0;
        }
        .line-h-25{
            line-height: 25px;
        }
        .align-items-center{
            align-items: center;
        }
        .max-h-25{
            max-height: 25px;
        }
        .d-grid {
            display: grid;
        }
        .d-grid-col-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .w-50{
            width: 50%;
        }
        .w-full{
            width: 100%;
        }
        .bordered,.bordered th,.bordered td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        .p-5{
            padding: 5px;
        }
        .p-10{
            padding: 10px;
        }
        .min-w-200{
            min-width: 200px;;
        }
        .border-left{
            border-left: 1px solid #000;
        }
        .max_width_90{
            max-width: 90%;
        }
        .m-auto{
            margin: auto;
        }
        .text-center{
            text-align: center;
        }
        .border_none,.bordered .border_none{
            border: none ;
        }
        .bordered .border_none{
            border-left: 1px solid #000;
        }
        tbody tr:nth-child(2) td {
            border-top: 1px solid #000 !important;
        }

        .bordered .border_none:first-child {
            border-top: 1px solid #222;
        }

        th {
            padding: 6px;
        }

        td.border_none {
            padding: 5px;
        }
        .py-10 {
            padding: 0 10px;
        }
    </style>
</head>
<body>
<div
    class="max_width min_height py-60 d-flex items-end flex-column Almarai-Regular rtl"
>
    <div class="w-full">
        <div class="d-flex pt-40 mb-30">
            <div class="w-110 h-65 shadow-img flex-center radius-4" style="float: right;">
                <img src="{{ public_path('assets/images/logo.png') }}" width="197"/>
            </div>
            <div class="d-flex flex-column justify-center mr-15" style="float:left;">
                <div class="second-color text-28 line-h-32" style="margin-top: 8px">
                    MK Insurance Broker
                </div>
            </div>
        </div>



        <div class="d-flex text-15 bordered max_width_90 m-auto">
            <div class="d-flex border-left p-10">
                مدة التأمين من يوم
                   ( {{ date('Y - m - d') }} )
            </div>
        </div>
        <table class="table bordered p-5 w-full text-center mt-20 w-430">
            <tbody>
            <tr>
                <th class="p-5">ماركة السيارة</td>
                <th class="p-5">سنة الصنع</td>
                <th class="p-5">مبلغ التأمين</td>
            </tr>
            <tr>
                <td class="p-5">{{ $info['car_brand_name'] }} - {{ $info['car_model_name']  }}</td>
                <td class="p-5">{{ $info['year'] }}</td>
                <td class="p-5">{{ $info['price'] }} ج.م </td>
            </tr>

            </tbody>
        </table>


        @php
            $countFees = count($info['fees']) + 1;
            $totalAmounts = 0;
        @endphp
        <table class="table bordered p-5 w-full text-center mt-20 w-430">
            <tbody>
            <tr >
                <td rowspan="{{ $countFees }}">قسط التأمين الاساسى</td>
                <td class="py-10" rowspan="{{ $countFees }}">{{ $info['premium'] }}</td>
            </tr>
            @foreach($info['fees'] as $fee)
                <tr>
                    <td class="border_none">{{ $fee['name'] }} </td>
                    <td  class="border_none">{{ $fee['amount']}}</td>
                </tr>
                @php
                    $totalAmounts += $fee['amount'];
                @endphp
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th> </th>
                <th></th>
                <th>الاجمالى</th>
                <th>{{ $totalAmounts + $info['premium'] }} ج.م</th>
            </tr>
            </tfoot>
        </table>

        <div class="mx-15">
            {!! $terms !!}
        </div>

    </div>


    <htmlpagefooter name="MyFooter1">
        <div class="mt-auto">
            <div class="footer w-full">
                <div class="d-flex space-between items-center">
                    <div style="width: 200px; float:right;"><img class="max-h-25" src="{{ public_path('assets/images/fav.png') }}" /></div>

                    <div class="text-16 text-gray" style="direction: ltr;width: 150px;float:left;margin-top:5px;">{{
                    date('d - M -
                    Y') }}</div>
                </div>
            </div>
        </div>
    </htmlpagefooter>

    <sethtmlpagefooter name="MyFooter1" value="on" />

</div>

</body>
</html>
