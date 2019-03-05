<?php

namespace App\Services;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\Aboutme as AboutmeModel;

class AboutmeService 
{
    /**
     * Get current aboutme
     *
     * @return ?object  elements as below:
     *                  - imageUrl
     */
    public function getAboutme()
    {
        $aboutme = AboutmeModel::first();
        return is_null($aboutme) ?: (object) [
            'imageUrl'  => Storage::url($aboutme->image_path),
        ];
    }

    /**
     * Set aboutme
     *
     * @param UploadedFile $image
     *
     * @return int affected rows
     */
    public function setAboutme(UploadedFile $image) : int {
        $aboutme = AboutmeModel::first();
        if ($aboutme) {
            $oldImagePath = $aboutme->image_path;
            $aboutme->delete();
            Storage::delete($oldImagePath);
        }

        return AboutmeModel::create([
            'image_path'    => $image->save('images/aboutme'),
        ]);
    }
}
