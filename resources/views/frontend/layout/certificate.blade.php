<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Certificate</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Moul&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

        @stack('before_styles')
        <style>
            @import url('https://fonts.googleapis.com/css?family=Open+Sans|Pinyon+Script|Rochester');
            @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

            .bold {
                font-weight: bold;
            }

            .block {
                display: block;
            }

            .underline {
                border-bottom: 1px solid #777;
                padding: 5px;
                margin-bottom: 15px;
            }

            .margin-0 {
                margin: 0;
            }

            .padding-0 {
                padding: 0;
            }

            .pm-empty-space {
                height: 40px;
                width: 100%;
            }

            body {
                padding: 0;
                background: #ccc;
            }

            .pm-certificate-container {
                position: relative;
                width: 800px;
                height: 550px;
                background-repeat: no-repeat;
                background-position: center;
                background-size: contain;
                padding: 30px;
                color: #333;
                font-family: 'Open Sans', sans-serif;
                box-shadow: 0 0 5px rgba(0, 0, 0, .5);
                margin: 0 auto;
            }

            .outer-border {
                width: 794px;
                height: 594px;
                position: absolute;
                left: 50%;
                margin-left: -397px;
                top: 50%;
                margin-top:-297px;
                border: 2px solid #fff;
            }

            .inner-border {
                width: 730px;
                height: 530px;
                position: absolute;
                left: 50%;
                margin-left: -365px;
                top: 50%;
                margin-top:-265px;
                border: 2px solid #fff;
            }

            .pm-certificate-border {
                position: relative;
                width: 720px;
                height: 520px;
                padding: 0;
                border: none;
                background-color: transparent;
                background-image: none;
                left: 50%;
                margin-left: -360px;
                top: 50%;
                margin-top: -260px;
            }

            .pm-certificate-border .pm-certificate-block {
                width: 650px;
                height: 280px;
                position: relative;
                left: 50%;
                margin-left: -325px;
                top: 70px;
                margin-top: 0;
            }

            .pm-certificate-border .pm-certificate-header {
                margin-bottom: 10px;
            }

            .pm-certificate-border .pm-certificate-title {
                position: relative;
                top: 110px;
            }

            span {
                color: #213faa !important;
            }

            span strong {
                font-family: 'Moul', cursive !important;
            }

            .pm-certificate-border .pm-certificate-title h2 {
                font-size: 20px;
                color: #213faa;
                font-family: 'Moul', cursive !important;
            }

            .moul {
                font-family: 'Moul', cursive !important;
            }

            .pm-certificate-border .pm-certificate-title p {
                font-size: 15px !important;
                color: #213faa;
                margin: 0;
                line-height: 30px;
                text-align: justify;
                text-justify: inter-word;
                text-indent: 80px;
            }

            .pm-certificate-border .pm-certificate-body {
                padding: 20px;
            }

            .pm-certificate-container .pm-certificate-border .pm-certificate-body .pm-name-text {
                font-size: 20px;
            }

            .pm-certificate-border .pm-earned {
                margin: 15px 0 20px;
            }

            .pm-certificate-border .pm-earned-text {
                font-size: 20px;
            }

            .pm-certificate-border .pm-credits-text {
                font-size: 15px;
            }

            .pm-certificate-border .pm-course-title .pm-earned-text {
                font-size: 20px;
            }

            .pm-certificate-border .pm-course-title .pm-credits-text {
                font-size: 15px;
            }

            .pm-certificate-border .pm-course-title .pm-certified {
                font-size: 12px;
            }

            .pm-certificate-border .pm-course-title .underline {
                margin-bottom: 5px;
            }

            .pm-certificate-border .pm-course-title .pm-certificate-footer {
                width: 650px;
                height: 100px;
                position: relative;
                left: 50%;
                margin-left: -325px;
                bottom: -105px;
            }

            .image-position {
                position: relative;
                top: 50px;
                right: 120px;
            }
        </style>
    </head>
    <body>
        <div class="alert alert-info text-center" style="border-radius: 0px;" role="alert">
            <button class="btn btn-link" id="btn_download">
                <h4 class="text-info" style="margin: 0; padding: 0;">
                    <strong>Download</strong>
                </h4>
            </button>
        </div>
        <div class="container">
            <div class="pm-certificate-container" id="certificate">

                @yield('content')

            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>
        <script>
            const options = {
                margin: 0.5,
                filename: 'certificate_{{ optional($entry->contest)->TitleLang . $entry->id }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 1
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'landscape'
                }
            }

            $(function() {
                $('#btn_download').click(function(e) {
                    e.preventDefault();
                    var element = document.getElementById('certificate');
                    html2pdf().from(element).set(options).save();
                });
            });
        </script>
    </body>
</html>
