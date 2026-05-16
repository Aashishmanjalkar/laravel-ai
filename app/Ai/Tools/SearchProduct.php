<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class SearchProduct implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Search products by name, category or description or optional price range.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $query = trim( (string) $request['query'] ?? '');
        $maxPrice = $request['max_price'] ?? null;

        if(empty($query)) {
            return 'Please provide a search query.';
        }

        info([$query]);

        $products = \App\Models\Product::query()
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('category', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($maxPrice, function($q) use ($maxPrice) {
                $q->where('price', '<=', $maxPrice);
            })
            ->get();

        if($products->isEmpty()) {
            return 'No products found matching your query.';
        }

        return $products->map(function($product) {
            return "{$product->name} - {$product->category} - \${$product->price}\n{$product->description}";
        })->implode("\n\n");

    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string()->description('The search query for products.')->required(),
            'max_price' => $schema->number()->description('The maximum price for filtering products.'),
        ];
    }
}
