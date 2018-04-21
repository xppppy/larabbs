<?php
//辅助函数，方便web页能拿到scss中定义的class名称 如.users-show-page，通过class="{{route_class()}}",得到class="user-show-page"
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}
//截取摘录，去空格回车
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}