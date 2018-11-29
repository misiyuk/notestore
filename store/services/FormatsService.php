<?php

namespace store\services;

use store\entities\Formats;
use store\forms\manage\formats\FormatsForm;
use store\repositories\FormatsRepository;

/**
 * @property FormatsRepository $formats
 */
class FormatsService
{
    private $formats;

    public function __construct(FormatsRepository $formats)
    {
        $this->formats = $formats;
    }

    /**
     * @param int $id
     * @param FormatsForm $form
     * @throws \Exception
     */
    public function edit(int $id, FormatsForm $form)
    {
        $formats = $this->formats->get($id);
        $formats->edit($form->name);
        $this->formats->save($formats);
    }

    /**
     * @param FormatsForm $form
     * @return Formats
     * @throws \Exception
     */
    public function create(FormatsForm $form): Formats
    {
        $formats = Formats::create($form->name);
        $this->formats->save($formats);
        return $formats;
    }

    /**
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(int $id): void
    {
        $formats = $this->formats->get($id);
        $this->formats->remove($formats);
    }
}