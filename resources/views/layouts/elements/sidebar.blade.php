<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="d-flex flex-column justify-content-between h-100 hover-scroll-overlay-y my-2 d-flex flex-column" id="kt_app_sidebar_main" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_main" data-kt-scroll-offset="5px">
        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg mb-7">

            <!-- menu link -->
            <div class="menu-item here show">
                <a href="/" class="menu-link">
                    <span class="menu-icon">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>

            <div class="menu-item here show">
                <a href="{{ route('clients.index') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fa fa-users"></i>
                    </span>
                    <span class="menu-title">Clienti</span>
                </a>
            </div>

        </div>
    </div>
</div>
