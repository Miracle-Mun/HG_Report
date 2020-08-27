<div id="kt_header" class="header  header-fixed ">
    <div class="  d-flex align-items-stretch justify-content-between headerLine">
        <div class="d-flex align-items-stretch">
            <div class="header-logo">
                <a href="/"> <img alt="Logo" style="max-height: 110px !important; margin-left: 10%;border-radius: 15px;" src="./assets/logos/LOOGO-1024x322.png" class="logo-default max-h-40px"> </a>
            </div>
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                <div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile  header-menu-layout-default ">
                    <ul class="menu-nav ">
                        <?php
                            try {
                                $Sessionuserinfo = Session::get('session');
                                $RealName = $RealCom = '';
                                if($Sessionuserinfo) {
                                    $infoarr = explode(",", $Sessionuserinfo);
                                    $myInfo = DB::table('logins')->where(['username' => $infoarr[0], 'encrypted' => $infoarr[1]])->get('user_id');
                                    $userId = json_decode($myInfo)[0]->user_id;
                                    $RealName = json_decode(DB::table('users')->where('id', $userId)->get())[0]->name;
                                    $RealCom = json_decode(DB::table('communities')->where('id', json_decode(DB::table('users')->where('id', $userId)->get())[0]->community_id)->get())[0]->name;
                                }
                            } catch (Exception $e) {
                                Session::forget('session');
                                Session::flash('sessiondestroy','true');
                            }
                        ?>
                        @if (Session::get('sessiondestroy') == 'true')
                            <form style="display: none;" method="GET" action="/signout"><input id="signoutBtn"/></form>
                            <script> $('#signoutBtn').click(); </script>
                        @else
                            {{-- <li class="menu-item  menu-item-submenu menu-item-rel hellotitle" data-menu-toggle="click" aria-haspopup="true">
                                Hello &nbsp;&nbsp; <b>{{ $RealName }}</b>&nbsp;&nbsp; from&nbsp; <b> {{ $RealCom }} </b>
                            </li> --}}
                        @endif
                        <li class="menu-item  menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
                            <a href="/main" class="gotoPage button-wrapper">
                                <span class="menu-text boxed-btn btn-rounded">
                                    <span class="iconify" data-icon="fa:home" data-inline="false"></span>
                                    Home
                                </span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>

                        <li class="menu-item  menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
                            <div class="btn-group headergroup">
                                <button type="button" class="btn btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="iconify" data-icon="entypo:user" data-inline="false"></span>
                                    {{ $RealName }}
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                    <a href="#" class="dropdown-item">
                                        <span class="menu-text boxed-btn btn-rounded">
                                            <span class="iconify" data-icon="icomoon-free:profile" data-inline="false"></span>
                                            Profile
                                        </span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <a href="usermanage" class="dropdown-item">
                                        <span class="menu-text boxed-btn btn-rounded">
                                            <span class="iconify" data-icon="wpf:administrator" data-inline="false"></span>
                                            Admin
                                        </span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    {{-- <a href="#" class="dropdown-item">
                                        <span class="menu-text boxed-btn btn-rounded">
                                            <span class="iconify" data-icon="ic:twotone-contact-support" data-inline="false"></span>
                                            Support
                                        </span>
                                        <i class="menu-arrow"></i>
                                    </a> --}}
                                    <div class="dropdown-divider"></div>
                                    <a href="/signout" class="dropdown-item">
                                        <span class="menu-text boxed-btn btn-rounded">
                                            <span class="iconify" data-icon="si-glyph:sign-out" data-inline="false"></span>
                                            Sign Out
                                        </span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <form method="GET" action=""><input type="submit" value="submit" id="goTopageAction" style="display: none;"></form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
