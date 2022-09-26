<?php

if (!function_exists('phoneToInt')) {
    function phoneToInt(string $phone): int
    {
        return preg_replace("/[^0-9]/", '', $phone);
    }
}

if (!function_exists('getQueryUrl')) {
    function getQueryUrl(array $params): string
    {
        $toRemove = ['page', 'sort', 'order'];
        $query = array_diff_key(request()->query(), array_flip($toRemove));
        $query = array_merge($query, $params);

        return url()->current() . '?' . http_build_query($query);
    }
}

if (!function_exists('getUserAccess')) {
    function getUserAccess(string $role): array
    {
        return \Illuminate\Support\Facades\DB::table('menu_item_user')
            ->where('user_role', $role)->get()->pluck('menu_item_id')->toArray();
    }
}
