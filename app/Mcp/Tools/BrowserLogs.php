<?php

namespace App\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Log;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use SplFileObject;

class BrowserLogs extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        Read browser logs, errors, and exceptions from the Laravel log files.
    MARKDOWN;

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $limit = $request->input('limit', 50);

        // Get the latest log entries from Laravel's log files
        $logPath = storage_path('logs/laravel.log');

        if (! file_exists($logPath)) {
            return Response::text('No log file found');
        }

        $logs = [];

        // Read the last N lines from the log file
        $file = new SplFileObject($logPath, 'r');
        $file->seek(PHP_INT_MAX);
        $totalLines = $file->key();

        $startLine = max(0, $totalLines - $limit);
        $file->seek($startLine);

        while (! $file->eof()) {
            $line = trim($file->fgets());
            if ($line) {
                $logs[] = $line;
            }
        }

        return Response::json(array_reverse($logs));
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'limit' => $schema->integer('The number of log entries to retrieve')->default(50),
        ];
    }
}
