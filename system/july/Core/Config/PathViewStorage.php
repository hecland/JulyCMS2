<?php

namespace July\Core\Config;

use July\Core\EntityField\FieldStorageBase;
use July\Core\Entity\Exceptions\InvalidEntityException;

class PathViewStorage extends FieldStorageBase
{
    /**
     * {@inheritdoc}
     */
    public function get()
    {
        if (!$this->entity->exists) {
            throw new InvalidEntityException('字段存取器的关联实体无效');
        }

        return PathView::findViewByPath($this->entity->getEntityPath())->get($this->entity->getLangcode());
    }

    /**
     * {@inheritdoc}
     */
    public function set($value)
    {
        if (!$this->entity->exists) {
            throw new InvalidEntityException('字段存取器的关联实体无效');
        }

        if (is_null($value)) {
            $this->delete();
            return;
        }

        if (!$this->isValideViewName($value)) {
            throw new \TypeError('URL 格式不正确');
        }

        PathView::query()->updateOrCreate([
            'path' => $this->entity->getEntityPath(),
            'langcode' => $this->entity->getLangcode(),
        ], ['view' => $value]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        if (!$this->entity->exists) {
            throw new InvalidEntityException('字段存取器的关联实体无效');
        }

        PathView::query()->where([
            'path' => $this->entity->getEntityPath(),
            'langcode' => $this->entity->getLangcode(),
        ])->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $needle)
    {
        return [];
    }

    /**
     * 验证是否合法的 URL
     *
     * @param  mixed $view
     * @return bool
     */
    protected function isValideViewName($view)
    {
        if (!is_string($view) || empty($view)) {
            return false;
        }

        if (preg_match('/^(\/[a-z0-9\-_]+)+(\.html)?\.twig$/i', $view)) {
            return true;
        }

        return false;
    }
}
