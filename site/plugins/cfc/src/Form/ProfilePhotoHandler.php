<?php

namespace CFC\Form;

use Exception;
use Kirby\Uuid\Uuid;


class ProfilePhotoHandler extends AbstractFormHandler
{
    public function getFields()
    {
        return [
            [
                'name' => 'profile__photo',
                'label' => 'Profile Photo',
                'required' => true,
            ],

        ];
    }

    public function validate(array $data = [])
    {
        if (!isset($_FILES['profile__photo'])) {
            throw new \Exception(sprintf('Field %s is required', 'profile__photo'));
        }
    }

    public function merge($data, \FormSubmissionPage $submission)
    {

        if (!isset($_FILES['profile__photo'])) {
            throw new \Exception(sprintf('Field %s is required', 'profile__photo'));
        }

        $source = $_FILES['profile__photo']['tmp_name'];


        $ext = str_replace('image/', '', $_FILES['profile__photo']['type']);

        $title = (string)$submission->title();
        $name = str_replace(" ", "", $title);
        $name = iconv("utf-8", "ascii//TRANSLIT", $name);
        $name = preg_replace('/[^A-Za-z0-9 ]/', '', $name);
        $name = sprintf('%s_%s.%s', $name, Uuid::generate(), $ext);

        $photoPath = sprintf('%s/%s', $submission->root(), $name);
        $tempPhotoPath = sprintf('%s/temp_%s', $submission->root(), $name);

        move_uploaded_file($source, $tempPhotoPath);
        $file = $submission->createFile([
            'source'   => $tempPhotoPath,
            'filename' => $photoPath,
            'template' => 'image',
        ]);
        if (file_exists($tempPhotoPath)) {
            unlink($tempPhotoPath);
        }

        return [
            'picture' =>  '- file://' . $file->uuid()->id(),
            'data' => [
                'profile__photo' => $file->thumb(['width' => 1000])->url(),
            ],
        ];
    }
}
