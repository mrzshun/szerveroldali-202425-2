<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Post;

final readonly class RelatedPosts
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $post = Post::findOrFail($args['id']);
        $categories = $post->categories;
        $relatedPosts = collect([]);
        foreach($categories as $cat) {
            $relatedPosts = $relatedPosts->concat($cat->posts);
        }
        $relatedPosts = $relatedPosts->unique('id');
        return $relatedPosts;
    }
}
