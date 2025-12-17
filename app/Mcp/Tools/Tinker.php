<?php

namespace App\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Symfony\Component\Process\Process;

class Tinker extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        Execute PHP code in the Laravel Tinker environment for debugging and testing.
    MARKDOWN;

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $code = $request->input('code');

        // Use Laravel's tinker command to execute the code
        $process = new Process([
            'php',
            'artisan',
            'tinker',
            '--execute',
            $code,
        ]);

        $process->run();

        $output = $process->getOutput();
        $errorOutput = $process->getErrorOutput();

        $result = '';
        if ($output) {
            $result .= "Output:\n" . $output;
        }
        if ($errorOutput) {
            $result .= "Errors:\n" . $errorOutput;
        }

        return Response::text($result ?: 'No output');
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'code' => $schema->string('The PHP code to execute')->required(),
        ];
    }
}
