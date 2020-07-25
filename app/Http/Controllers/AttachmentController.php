<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * @var array[]
     */
    private $attachments = [];

    /**
     * AttachmentController constructor.
     * @param array $attachments
     */
    public function __construct($attachments = [])
    {
        $this->attachments = [$attachments];
    }

    /**
     * @return array
     */
    public function store(): array
    {
        return array_map(function ($attributes) {
            return new Attachment($attributes);
        }, $this->getUploadedAttachmentsAttributes());
    }


    /**
     * Returns array data of uploaded files
     *
     * @return array
     */
    private function getUploadedAttachmentsAttributes()
    {
        $attributes = [];

        foreach ($this->attachments as $attachment) {

            $filePath = $this->upload($attachment);

            $attributes[] = [
                'name' => $attachment->getClientOriginalName(),
                'extension' => Storage::mimeType($filePath),
                'size' => $attachment->getSize() / 1024,
                'source' => $filePath
            ];
        }

        return $attributes;
    }

    /**
     * Returns uploaded file path
     *
     * @param $file
     * @return mixed
     */
    public function upload($file)
    {
        return $file->store(Attachment::UPLOAD_PATH);
    }

    /**
     * Destroy file by filename
     *
     * @param $filename
     */
    public function destroy($filename) : void
    {
        File::delete($filename);
    }

}
