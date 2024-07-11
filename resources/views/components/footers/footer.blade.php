@if (isset(\App\Services\AppConfig::get()->app->app_info->footer_section) &&
        \App\Services\AppConfig::get()->app->app_info->footer_section === 'default')
    @include('components.footers.default')
@elseif (isset(\App\Services\AppConfig::get()->app->app_info->footer_section) &&
        \App\Services\AppConfig::get()->app->app_info->footer_section === 'style1')
    @include('components.footers.footer1')
@elseif (isset(\App\Services\AppConfig::get()->app->app_info->footer_section) &&
        \App\Services\AppConfig::get()->app->app_info->footer_section === 'style2')
    @include('components.footers.footer2')
@elseif (isset(\App\Services\AppConfig::get()->app->app_info->footer_section) &&
        \App\Services\AppConfig::get()->app->app_info->footer_section === 'style3')
    @include('components.footers.footer3')
@elseif (isset(\App\Services\AppConfig::get()->app->app_info->footer_section) &&
        \App\Services\AppConfig::get()->app->app_info->footer_section === 'style4')
    @include('components.footers.footer3')
@elseif (isset(\App\Services\AppConfig::get()->app->app_info->footer_section) &&
        \App\Services\AppConfig::get()->app->app_info->footer_section === 'style5')
    @include('components.footers.footer3')
@else
    @include('components.footers.default')
@endif
