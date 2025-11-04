<?php


class FormSubmissionsPage extends Page
{
    public function _download_submissions_url()
    {
        return site()->url() . '/download-submissions/' . (string)$this->parent()->uuid()->id() . '.csv';
    }



    public function _ski_fondue_count()
    {
        return $this->_product_submissions('82GDAeCt7ukPP8j5')->count();
    }

    public function _fondue_only_count()
    {
        return $this->_product_submissions('WXKMQNUsuXq7Pp9U')->count();
    }


    public function _complete_submissions()
    {
        return $this->children()->filter(function ($child) {
            return $child->isCompleted();
        });
    }

    public function _product_submissions($productId)
    {
        return $this->_complete_submissions()->filter(function ($child) use ($productId) {
            return $child->hasProduct($productId);
        });
    }

    public function _incomplete_submissions()
    {
        return $this->children()->filter(function ($child) {
            return !$child->isCompleted();
        });
    }
}
