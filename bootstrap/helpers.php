<?php
//辅助函数，方便web页能拿到scss中定义的class名称 如.users-show-page，通过class="{{route_class()}}",得到class="user-show-page"
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}