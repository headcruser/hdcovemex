<?php

namespace HelpDesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Media extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'media';

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'media_type', 'media_id', 'name', 'file', 'mime_type', 'size'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * Get the owning mediable model.
     */
    public function modelo()
    {
        return $this->morphTo();
    }

    /**
     * Format Size file.
     *
     * @param  string  $value
     * @return string
     */
    public function getSizeAttribute($value)
    {
        return formatBytes($value);
    }

    /**
     * Generate File to Base64
     *
     * @param UploadedFile $file
     * @return array
     * @throws Exception Throw exeption if not instance UploadedFile
     */
    public static function createMediaArray($file)
    {

        if (!$file instanceof UploadedFile) {
            throw new \Exception("Error Instance UploadFile", 1);
        }

        $fileMimeType = $file->getMimeType();
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $fileBase64 = base64_encode(file_get_contents(addslashes($file)));
        $adjunto = "data:{$fileMimeType};base64,{$fileBase64}";

        return [
            'mime_type' => $fileMimeType,
            'name'      => $fileName,
            'file'      => $adjunto,
            'size'      => $fileSize
        ];
    }

    /**
     * Build path file for dowload
     *
     * @return string
     */
    public function buildMediaFilePath()
    {
        $path = storage_path('tmp' . DIRECTORY_SEPARATOR . 'uploads');

        try {
            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }
        } catch (\Exception $e) {
        }

        $data = explode(',', $this->file);
        $content = base64_decode($data[1]);

        $nameFile = $path . DIRECTORY_SEPARATOR . $this->name;

        file_put_contents($nameFile, $content);

        return $nameFile;
    }
}
