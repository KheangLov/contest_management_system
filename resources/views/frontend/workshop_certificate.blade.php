@extends('frontend.layout.certificate')

@push('before_styles')
    <style>
        .pm-certificate-container {
            width: 777px !important;
            background-image: url('{{ asset("assets/certificate_bg.png") }}');
        }

        .pm-certificate-border .pm-certificate-top-title {
            position: relative;
            top: 25px;
        }

        .pm-certificate-border .pm-certificate-title {
            top: 35px !important;
        }

        .pm-certificate-border .pm-certificate-top-title h2,
        .pm-certificate-border .pm-certificate-title h2,
        .pm-certificate-border .pm-certificate-title h3 {
            font-size: 14px !important;
            color: #213faa;
            font-family: 'Moul', cursive !important;
        }

        .pm-certificate-container .pm-certificate-border .overlay-bg,
        .pm-certificate-container .pm-certificate-border .left-overlay-bg,
        .pm-certificate-container .pm-certificate-border .right-overlay-bg {
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            position: absolute;
            width: 100%;
        }

        .pm-certificate-container .pm-certificate-border .overlay-bg {
            background-image: url('{{ asset("assets/MoEYS_(Cambodia).svg.png") }}');
            height: 60%;
            top: 15%;
            opacity: 0.25;
        }

        .pm-certificate-container .pm-certificate-border .left-overlay-bg {
            background-image: url('{{ asset("assets/moeys.png") }}');
            height: 13%;
            background-position: right;
            width: 23%;
            top: 55px;
        }

        .pm-certificate-container .pm-certificate-border .right-overlay-bg {
            background-image: url('{{ asset("assets/koica.PNG") }}');
            height: 18%;
            background-position: right;
            top: 55px;
            width: 96%;
        }

        .pm-certificate-border .pm-certificate-title p {
            text-indent: 0px !important;
            padding: 10px 20px !important;
            line-height: 25px !important;
        }

        .pm-certificate-border .pm-certificate-header {
            margin: 0 !important;
        }


    </style>
@endpush

@section('content')
    <div class="pm-certificate-border">
        <div class="left-overlay-bg"></div>
        <span class="moul" style="position: absolute;top: 135px;
        left: 65px;
        font-size: 11px;">ក្រសួងអប់រំ យុវជន និងកីឡា</span>
        <div class="overlay-bg"></div>
        <div class="right-overlay-bg"></div>

        <div class="row pm-certificate-header">
            <div class="pm-certificate-top-title cursive col-xs-12 text-center">
                <div style="padding: 15px 30px;">
                    <h2 style="font-weight: bold;">ព្រះរាជាណាចក្រកម្ពុជា</h2>
                    <h2 style="font-weight: bold; margin-top: 10px">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
                </div>
            </div>

            <div class="pm-certificate-title cursive col-xs-12 text-center">
                <div style="padding: 0 30px;">
                    <h2 style="font-weight: bold;">លិខិតបញ្ចាក់ការចូលរូម</h2>
                    <h3 style="font-size: 14px; margin-top: 10px">ប្រគល់ជូន</h3>
                    <p>
                        បានចូលរួមក្នុង <span class="moul">{{ $entry->TitleLang }}</span>  រៀបចំដោយ ក្រសួងអប់រំ យុវជន និង កីឡា រយៈពេលបីថ្ងៃ ចាប់ពីថ្ងៃទី {{ $entry->StartDayKhmer }}
                        ដល់ ថ្ងៃទី {{ $entry->EndDayKhmer }} ខែ{{ $entry->MonthKhmer }} ឆ្នាំ{{ $entry->YearKhmer }} តាមប្រព័ន្ធអនឡាញ។ វិភាគទាននេះបានបង្ហាញពីកិច្ចគាំទ្រនៅក្នុងការពង្រឹងប្រព័ន្ធអប់រំស្ទែម
                        និង ចូលរួមចំណែកឆ្លើយតបការលើកកម្ពស់គុណភាពអប់រំនៅកម្ពុជា។
                    </p>
                </div>
            </div>
        </div>

        <div class="row pm-certificate-body">

            <div class="col-xs-12">
                <div class="row">
                    <div class="pm-certificate-footer" style="position:absolute;width:100%;top:25px;">
                        <div class="col-xs-6 pm-certified text-center">
                            <span>សហការរៀបចំដោយ៖</span>
                            <img src="{{ asset('assets/logos.png') }}" alt="logos.png" class="img-responsive" style="height: 80px;
                            position: absolute;
                            top: 25px;
                            left: 58px;">
                        </div>
                        <div class="col-xs-6 pm-certified text-center">
                            <span style="position: relative;white-space: nowrap;top:-15px;right:-10px;">រាជធានីភ្នំពេញ {{ $current_date }}</span>
                            <span style="position: relative;top: 5px;display: block;top:-8px;right:-11px;"><strong>រដ្ឋមន្ត្រីក្រសួងអប់រំ យុវជន និងកីឡា</strong></span>
                            <span style="position: relative;top: 5px;display: block;top:53px;right:-11px;color:#ff0000 !important;"><strong>បណ្ឌិតសភាចារ្យ ហង់ជួន ណារ៉ុង</strong></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
