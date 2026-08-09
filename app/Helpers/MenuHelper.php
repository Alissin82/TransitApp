<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups(): array
    {
        return [
            [
                'title' => __('Menu'),
                'items' => self::getMainNavItems(),
            ],
        ];
    }

    public static function getMainNavItems(): array
    {
        return [
            [
                'icon' => 'home',
                'name' => __('Home'),
                'path' => route('home'),
                'active_routes' => ['home'],
            ],
            [
                'icon' => 'routes',
                'name' => __('Route management'),
                'active_routes' => ['terminals.*', 'transit-lines.*'],
                'subItems' => [
                    [
                        'name' => __('terminal.plural'),
                        'path' => route('terminals.index'),
                        'active_routes' => ['terminals.*'],
                    ],
                    [
                        'name' => __('transit-line.plural'),
                        'path' => route('transit-lines.index'),
                        'active_routes' => ['transit-lines.*'],
                    ],
                ],
            ],
        ];
    }

    public static function getIcon($iconName): string
    {
        $icons = [
            'home' => '<i class="fas fa-home"></i>',
            'routes' => '<i class="fas fa-route"></i>',
        ];

        return $icons[$iconName] ?? '<i class="fas fa-star"></i>';
    }

    public static function isActive(array $item): bool
    {
        if (isset($item['active_routes']) && self::routeMatches($item['active_routes'])) {
            return true;
        }

        if (isset($item['path']) && self::pathMatches($item['path'])) {
            return true;
        }

        return false;
    }

    public static function hasActiveSubItem(array $item): bool
    {
        if (!isset($item['subItems']) || !is_array($item['subItems'])) {
            return false;
        }

        foreach ($item['subItems'] as $subItem) {
            if (self::isActive($subItem)) {
                return true;
            }
        }

        return false;
    }

    protected static function routeMatches(array|string $routes): bool
    {
        $routes = (array) $routes;

        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return true;
            }
        }

        return false;
    }

    protected static function pathMatches(string $path): bool
    {
        $normalized = self::normalizePath($path);

        if ($normalized === '/') {
            return request()->routeIs('home') || request()->path() === '/';
        }

        $normalized = trim($normalized, '/');

        return request()->is($normalized) || request()->is($normalized . '/*');
    }

    protected static function normalizePath(string $path): string
    {
        $parsed = parse_url($path, PHP_URL_PATH);

        if ($parsed === null || $parsed === false || $parsed === '') {
            $parsed = $path;
        }

        $normalized = '/' . trim($parsed, '/');

        return $normalized === '//' ? '/' : $normalized;
    }
}
