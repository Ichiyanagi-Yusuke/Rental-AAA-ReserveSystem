<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsPostController extends Controller
{
    public function index()
    {
        $posts = NewsPost::orderBy('published_at', 'desc')->paginate(10);
        return view('news_posts.index', compact('posts'));
    }

    public function create()
    {
        return view('news_posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:news,blog,event',
            'published_at' => 'required|date',
            'thumbnail' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|string|max:500',
            'closing_sentence' => 'nullable|string', // 追加

            // セクションのバリデーション
            'sections' => 'nullable|array',
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.body' => 'nullable|string',
            'sections.*.note' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('news', 'public');
            $validated['thumbnail'] = $path;
        }

        $validated['is_published'] = $request->has('is_published');
        // contentカラムはnullにしておくか、sectionsから結合して入れておくことも可能ですが今回は無視します
        $validated['content'] = '';

        // 記事保存
        $post = NewsPost::create($validated);

        // セクション保存
        if (!empty($request->sections)) {
            foreach ($request->sections as $index => $sectionData) {
                // 空データ（全て空）の場合はスキップ
                if (empty($sectionData['heading']) && empty($sectionData['body']) && empty($sectionData['note'])) {
                    continue;
                }
                $post->sections()->create([
                    'heading' => $sectionData['heading'],
                    'body' => $sectionData['body'],
                    'note' => $sectionData['note'],
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('news-posts.index')->with('success', '記事を作成しました。');
    }

    public function edit(NewsPost $newsPost)
    {
        return view('news_posts.edit', compact('newsPost'));
    }

    public function update(Request $request, NewsPost $newsPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:news,blog,event',
            'published_at' => 'required|date',
            'thumbnail' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|string|max:500',
            'closing_sentence' => 'nullable|string',

            'sections' => 'nullable|array',
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.body' => 'nullable|string',
            'sections.*.note' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($newsPost->thumbnail) {
                Storage::disk('public')->delete($newsPost->thumbnail);
            }
            $path = $request->file('thumbnail')->store('news', 'public');
            $validated['thumbnail'] = $path;
        }

        $validated['is_published'] = $request->has('is_published');

        $newsPost->update($validated);

        // セクション更新（既存を全削除して作り直すシンプルな方式を採用）
        $newsPost->sections()->delete();

        if (!empty($request->sections)) {
            foreach ($request->sections as $index => $sectionData) {
                if (empty($sectionData['heading']) && empty($sectionData['body']) && empty($sectionData['note'])) {
                    continue;
                }
                $newsPost->sections()->create([
                    'heading' => $sectionData['heading'],
                    'body' => $sectionData['body'],
                    'note' => $sectionData['note'],
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('news-posts.index')->with('success', '記事を更新しました。');
    }

    public function destroy(NewsPost $newsPost)
    {
        if ($newsPost->thumbnail) {
            Storage::disk('public')->delete($newsPost->thumbnail);
        }
        $newsPost->delete();
        return redirect()->route('news-posts.index')->with('success', '記事を削除しました。');
    }
}
