@extends('frontend.layout.certificate')

@push('before_styles')
    <style>
        .pm-certificate-container {
            background-image: url('{{ asset("assets/background.jpeg") }}');
        }

        .pm-certificate-border .pm-certificate-title p {
            font-family: 'Moul', cursive !important;
        }
    </style>
@endpush

@section('content')
    <div class="pm-certificate-border col-xs-12">
        <div class="row pm-certificate-header">
            <div class="pm-certificate-title cursive col-xs-12 text-center">
                <div style="padding: 15px 30px;">
                    <h2 style="font-weight: bold;">វិញាបនបត្របញ្ចាក់ការសិក្សា</h2>
                    <h2>ប្រគល់ជូន</h2>
                    <h2>{{ optional($entry->user)->FullName }}</h2>
                    <p>
                        គ្រូបង្រៀននៅសាលារៀនវ៉េស្ទឡាញន៍ ដែលបានចូលរួមវគ្គសិក្សាបំប៉នសមត្ថភាព
                        សម្រាប់ការរៀបចំប្រឡង <span style="letter-spacing: 1px;">{{ optional($entry->contest)->TitleLang }}</span> កម្រិតបឋមសិក្សា
                        នៅ<span>{{ $current_date }}</span>។
                    </p>
                </div>
            </div>
        </div>

        <div class="row pm-certificate-body">

            <div class="col-xs-12">
                <div class="row">
                    <div class="pm-certificate-footer">
                        <div class="col-xs-4 pm-certified col-xs-4 text-center">
                        </div>
                        <div class="col-xs-4">
                        </div>
                        <div class="col-xs-4 pm-certified text-center">
                            <span style="position: relative;top: 65px;right: 75px;white-space: nowrap;">រាជធានីភ្នំពេញ {{ $current_date }}</span>
                            <span style="position: relative;top: 70px;right: 65px;"><strong>ប្រធានសហគមន៍</strong></span>
                            <img src="{{ asset('assets/signator.png') }}" class="img-responsive image-position">
                            <span style="position: relative;top: 20px;right: 65px;">បណ្ឌិតសភាចារ្យ <strong>ច័ន្ទ រ័ត្ន</strong></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
