<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Support\Collection;

class SitemapController extends Controller
{
    public function sitemap()
    {
        //建立sitemap
        $sitemap = app('sitemap');

        //基本頁面
        $sitemap->add(
            route('index'),
            null,
            1.0,
            'hourly',
            [
                ['url' => asset('img/hacker.png')],
            ],
            config('app.cht_name')
        );
        $sitemap->add(route('clubs.map.static'), null, 1.0, 'hourly');
        $sitemap->add(route('clubs.map.google'), null, 1.0, 'hourly');
        $sitemap->add(route('clubs.index'), null, 1.0, 'hourly');

        //黑客社
        $hackersir = Club::where('name', 'like', '%黑客社%')->first();
        if ($hackersir->imgurImage) {
            $images = [
                ['url' => $hackersir->imgurImage->thumbnail('l')],
            ];
        } else {
            $images = null;
        }
        $sitemap->add(
            route('clubs.show', $hackersir),
            $hackersir->updated_at,
            0.9,
            'hourly',
            $images
        );

        //社團
        /** @var Club[]|Collection $clubs */
        $clubs = Club::with('imgurImage')->get();
        foreach ($clubs as $club) {
            if ($club->imgurImage) {
                $images = [
                    ['url' => $club->imgurImage->thumbnail('l')],
                ];
            } else {
                $images = null;
            }
            $sitemap->add(
                route('clubs.show', $club),
                $club->updated_at,
                0.5,
                'hourly',
                $images
            );
        }

        return $sitemap->render('xml');
    }
}
