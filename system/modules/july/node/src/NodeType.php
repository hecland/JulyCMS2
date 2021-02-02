<?php

namespace July\Node;

use App\Entity\EntityMoldBase;
use Illuminate\Support\Facades\Log;

class NodeType extends EntityMoldBase implements GetNodesInterface
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'node_types';

    /**
     * 获取实体类
     *
     * @return string
     */
    public static function getEntityClass()
    {
        return Node::class;
    }

    public function get_nodes()
    {
        return NodeSet::make($this->nodes->keyBy('id')->all());
    }
}
