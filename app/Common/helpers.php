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

if (!function_exists('getEnding')) {
    function getEnding(int $n, array $titles): string
    {
        $cases = [2, 0, 1, 1, 1, 2];
        return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }
}

if (!function_exists('adminOrArchivist')) {
    function adminOrArchivist(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'archivist']);
    }
}
