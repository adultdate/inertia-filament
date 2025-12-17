<?php

namespace App\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class ListArtisanCommands extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        List all available Artisan commands in the Laravel application.
    MARKDOWN;

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $commands = [];
        $application = app();

        foreach ($application->all() as $command) {
            $commands[] = [
                'name' => $command->getName(),
                'description' => $command->getDescription(),
                'aliases' => $command->getAliases(),
            ];
        }

        return Response::json($commands);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            //
        ];
    }
}
