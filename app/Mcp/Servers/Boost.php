<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\BrowserLogs;
use App\Mcp\Tools\DatabaseQuery;
use App\Mcp\Tools\GetAbsoluteUrl;
use App\Mcp\Tools\ListArtisanCommands;
use App\Mcp\Tools\Tinker;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Prompt;
use Laravel\Mcp\Server\Tool;

class Boost extends Server
{
    /**
     * The MCP server's name.
     */
    protected string $name = 'Boost';

    /**
     * The MCP server's version.
     */
    protected string $version = '0.0.1';

    /**
     * The MCP server's instructions for the LLM.
     */
    protected string $instructions = <<<'MARKDOWN'
        You are Laravel Boost, a powerful MCP server for Laravel applications.

        ## Laravel Boost Guidelines

        The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to enhance the user's satisfaction building Laravel applications.

        ## Foundational Context
        This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

        - php - 8.4.12
        - filament/filament (FILAMENT) - v4
        - laravel/fortify (FORTIFY) - v1
        - laravel/framework (LARAVEL) - v12
        - laravel/prompts (PROMPTS) - v0
        - livewire/flux (FLUXUI_FREE) - v2
        - livewire/livewire (LIVEWIRE) - v3
        - livewire/volt (VOLT) - v1
        - laravel/mcp (MCP) - v0
        - laravel/pint (PINT) - v1
        - laravel/sail (SAIL) - v1
        - pestphp/pest (PEST) - v4
        - phpunit/phpunit (PHPUNIT) - v12
        - tailwindcss (TAILWINDCSS) - v4

        ## Available Tools
        - list-artisan-commands: List all available Artisan commands
        - get-absolute-url: Get absolute URLs with correct scheme, domain, and port
        - tinker: Execute PHP code in Laravel Tinker environment
        - database-query: Execute database queries to read data
        - browser-logs: Read browser logs, errors, and exceptions from Laravel logs

        Use these tools to help with Laravel development tasks.
    MARKDOWN;

    /**
     * The tools registered with this MCP server.
     *
     * @var array<int, class-string<Tool>>
     */
    protected array $tools = [
        ListArtisanCommands::class,
        GetAbsoluteUrl::class,
        Tinker::class,
        DatabaseQuery::class,
        BrowserLogs::class,
    ];

    /**
     * The resources registered with this MCP server.
     *
     * @var array<int, class-string<Server\Resource>>
     */
    protected array $resources = [
        //
    ];

    /**
     * The prompts registered with this MCP server.
     *
     * @var array<int, class-string<Prompt>>
     */
    protected array $prompts = [
        //
    ];
}
