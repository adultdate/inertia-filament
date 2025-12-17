<?php

namespace App\Mcp\Tools;

use Exception;
use Illuminate\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\DB;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class DatabaseQuery extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        Execute a database query to read data from the database.
    MARKDOWN;

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $query = $request->input('query');
        $bindings = $request->input('bindings', []);

        try {
            $results = DB::select($query, $bindings);

            return Response::json($results);
        } catch (Exception $e) {
            return Response::text('Error executing query: ' . $e->getMessage());
        }
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string('The SQL query to execute')->required(),
            'bindings' => $schema->array('The query bindings')->default([]),
        ];
    }
}
