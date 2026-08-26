<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LegacyRedirectMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uri = $request->getRequestUri();
        $path = $request->getPathInfo();

        // 1. Redirect old contact page
        if ($path === '/contact' || $path === '/contact-us') {
            return redirect()->to('/kontak', 301);
        }

        // 2. Redirect old category structures: /category/news -> /blog/kategori/news
        if (str_starts_with($path, '/category/')) {
            $slug = str_replace('/category/', '', $path);
            return redirect()->to('/blog/kategori/' . $slug, 301);
        }

        // 3. Redirect old post structures: /2024/05/12/judul-artikel -> /blog/judul-artikel
        if (preg_match('/^\/\d{4}\/\d{2}\/\d{2}\/(.+)$/', $path, $matches)) {
            $slug = rtrim($matches[1], '/');
            return redirect()->to('/blog/' . $slug, 301);
        }

        // 4. Redirect old query parameters: /?p=ID
        if ($request->has('p')) {
            $postId = $request->query('p');
            // Try to find the post if there's a reference or redirect to /blog
            $post = Post::find($postId);
            if ($post && $post->status->value === 'published') {
                return redirect()->to('/blog/' . $post->slug, 301);
            }
            return redirect()->to('/blog', 301);
        }

        return $next($request);
    }
}
