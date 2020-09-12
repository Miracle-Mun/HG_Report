<!DOCTYPE html>
<html lang="en" >
	<!--begin::Head-->
	<!-- Mirrored from keenthemes.com/metronic/preview/demo2/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jun 2020 04:36:54 GMT -->
	<!-- Added by HTTrack -->
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<!-- /Added by HTTrack -->
	<head>
		<meta charset="utf-8"/>
		<title>Welcome to OT</title>
		<meta name="description" content="Updates and statistics"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
        <!--end::Fonts-->
        <!--begin::Page Vendors Styles(used by this page)-->
        <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle79e8.css?v=7.0.3" rel="stylesheet" type="text/css"/>
        <!--end::Page Vendors Styles-->
        <!--begin::Global Theme Styles(used by all pages)-->
        <link href="assets/plugins/global/plugins.bundle79e8.css?v=7.0.3" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/custom/prismjs/prismjs.bundle79e8.css?v=7.0.3" rel="stylesheet" type="text/css"/>
        <link href="assets/css/style.bundle79e8.css?v=7.0.3" rel="stylesheet" type="text/css"/>
        <link href="/assets/css/myStyle.css" rel="stylesheet" type="text/css"/>
        <link href="/assets/css/newcss.css" rel="stylesheet" type="text/css"/>
        <link href="/assets/css/front-end.css" rel="stylesheet" type="text/css"/>
        <!--end::Global Theme Styles-->
        <!--begin::Layout Themes(used by all pages)-->
        <!--end::Layout Themes-->
        <link rel="shortcut icon" href="https://keenthemes.com/metronic/themes/metronic/theme/html/demo2/distassets/media/logos/favicon.ico"/>
        <!-- Hotjar Tracking Code for keenthemes.com -->
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:1070954,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-37564768-1');
            var communitiess = [];
        </script>
    </head>
    <body  id="kt_body"  class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading"  >
        @csrf
        @include('layouts.header')
        <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="d-flex flex-column-fluid mainContainer">
                <div class=" container " style="padding-top: 5%;">
                    <div class="card-body p-0 mainBody">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
        <div id="kt_scrolltop" class="scrolltop">
            <span class="svg-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1"></rect>
                        <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero"></path>
                    </g>
                </svg>
            </span>
        </div>
        <button id="randomBtn" class="dn">random<button>

        <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
        <script>
            var KTAppSettings = {
                "breakpoints": {
                    "sm": 576,
                    "md": 768,
                    "lg": 992,
                    "xl": 1200,
                    "xxl": 1200
                },
                "colors": {
                    "theme": {
                        "base": {
                            "white": "#ffffff",
                            "primary": "#6993FF",
                            "secondary": "#E5EAEE",
                            "success": "#1BC5BD",
                            "info": "#8950FC",
                            "warning": "#FFA800",
                            "danger": "#F64E60",
                            "light": "#F3F6F9",
                            "dark": "#212121"
                        },
                        "light": {
                            "white": "#ffffff",
                            "primary": "#E1E9FF",
                            "secondary": "#ECF0F3",
                            "success": "#C9F7F5",
                            "info": "#EEE5FF",
                            "warning": "#FFF4DE",
                            "danger": "#FFE2E5",
                            "light": "#F3F6F9",
                            "dark": "#D6D6E0"
                        },
                        "inverse": {
                            "white": "#ffffff",
                            "primary": "#ffffff",
                            "secondary": "#212121",
                            "success": "#ffffff",
                            "info": "#ffffff",
                            "warning": "#ffffff",
                            "danger": "#ffffff",
                            "light": "#464E5F",
                            "dark": "#ffffff"
                        }
                    },
                    "gray": {
                        "gray-100": "#F3F6F9",
                        "gray-200": "#ECF0F3",
                        "gray-300": "#E5EAEE",
                        "gray-400": "#D6D6E0",
                        "gray-500": "#B5B5C3",
                        "gray-600": "#80808F",
                        "gray-700": "#464E5F",
                        "gray-800": "#1B283F",
                        "gray-900": "#212121"
                    }
                },
                "font-family": "Poppins"
            };
        </script>
        <!--end::Global Config-->
        <!--begin::Global Theme Bundle(used by all pages)-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="assets/plugins/global/plugins.bundle79e8.js?v=7.0.3"></script>
        <script src="assets/plugins/custom/prismjs/prismjs.bundle79e8.js?v=7.0.3"></script>
        <script src="assets/js/scripts.bundle79e8.js?v=7.0.3"></script>
        <!--end::Global Theme Bundle-->
        <!--begin::Page Vendors(used by this page)-->
        <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle79e8.js?v=7.0.3"></script>
        <!--end::Page Vendors-->
        <!--begin::Page Scripts(used by this page)-->
        <script src="assets/js/pages/widgets79e8.js?v=7.0.3"></script>
        <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
        <script src="https://www.w3schools.com/lib/w3.js"></script>
        <script src="/assets/js/myEvent.js"></script>
        <!--end::Page Scripts-->
    </body>
    <!--end::Body-->
    <!-- Mirrored from keenthemes.com/metronic/preview/demo2/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jun 2020 04:36:55 GMT -->
</html>
