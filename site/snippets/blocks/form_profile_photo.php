<?php

$name = 'photo';
$label = $site->payment_label_uploadPhoto();
$error = $site->payment_error_uploadPhoto();
$isRequired = true;

$existingValue = $page->getExistingValueFor('profile__photo');

?>
<form name="profile" data-handler="form-fields">
    <div class="photo-field relative mt-4" data-value="<?= $existingValue ?>" data-field-type="profile_photo" data-field-name="profile__photo" data-field-required="<?= $isRequired ? 1 : 0 ?>">
        <div class="upload-photo relative text-center z-10 pt-8 pb-8">
            <a class="button black relative">
                <span> <?= $label ?></span>
                <input class="photo-input opacity-0 absolute top-0 left-0 w-full h-full" type="file" value="Upload a profile photo" accept="image/*">
            </a>
        </div>
        <div class="cropper">

        </div>
        <div class="photo-error hidden">
            <?= $error ?>
        </div>
    </div>
</form>