<?php

namespace App\Repositories;

use App\Models\Portfolio;
use Illuminate\Support\Facades\Storage;

class PortfolioRepository extends BaseRepository
{
    public function __construct(Portfolio $model)
    {
        parent::__construct($model);
    }

    public function create(array $data)
    {
        // Upload thumbnail
        if (request()->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = request()->file('thumbnail_image')
                ->store('uploads/portfolio/thumbnails', 'public');
        }

        // Upload featured image
        if (request()->hasFile('featured_image')) {
            $data['featured_image'] = request()->file('featured_image')
                ->store('uploads/portfolio/featured', 'public');
        }

        return parent::create($data);
    }

    public function update($id, array $data)
    {
        $item = $this->find($id);

        // Thumbnail update
        if (request()->hasFile('thumbnail_image')) {
            if ($item->thumbnail_image && Storage::disk('public')->exists($item->thumbnail_image)) {
                Storage::disk('public')->delete($item->thumbnail_image);
            }
            $data['thumbnail_image'] = request()->file('thumbnail_image')
                ->store('uploads/portfolio/thumbnails', 'public');
        }

        // Featured image update
        if (request()->hasFile('featured_image')) {
            if ($item->featured_image && Storage::disk('public')->exists($item->featured_image)) {
                Storage::disk('public')->delete($item->featured_image);
            }
            $data['featured_image'] = request()->file('featured_image')
                ->store('uploads/portfolio/featured', 'public');
        }

        return parent::update($id, $data);
    }

    public function delete($id)
    {
        $item = $this->find($id);

        if ($item->thumbnail_image && Storage::disk('public')->exists($item->thumbnail_image)) {
            Storage::disk('public')->delete($item->thumbnail_image);
        }

        if ($item->featured_image && Storage::disk('public')->exists($item->featured_image)) {
            Storage::disk('public')->delete($item->featured_image);
        }

        return parent::delete($id);
    }
}
