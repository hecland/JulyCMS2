<?php

use App\BaseMigrations\CreateFieldsTableBase;

class CreateMessageFieldsTable extends CreateFieldsTableBase
{
    /**
     * 模型名
     *
     * @var string
     */
    protected $model = \July\Message\MessageField::class;

    /**
     * 填充文件
     *
     * @var string|null
     */
    protected $seeder = \July\Message\Seeds\MessageFieldSeeder::class;
}

// class CreateMessageFieldsTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('message_fields', function (Blueprint $table) {
//             // 字段 id
//             $table->string('id')->primary();

//             // 字段类型
//             $table->string('field_type_id');

//             // 是否预设：
//             //  - 不可删除
//             //  - 只能通过程序添加，如安装或更新
//             //  - 预设的字段会在新建模型时默认出现在字段列表中，且不可移除
//             $table->boolean('is_reserved')->default(false);

//             // 是否全局字段：全局字段会在新建模型时默认出现在全局字段列表
//             $table->boolean('is_global')->default(false);

//             // 分组标题
//             $table->string('group_title')->nullable();

//             // 搜索权重
//             $table->unsignedTinyInteger('search_weight')->default(0);

//             // 建议长度
//             $table->unsignedSmallInteger('maxlength')->default(0);

//             $table->string('label');
//             $table->string('description')->nullable();

//             // 是否必填
//             $table->boolean('is_required')->default(false);

//             // 表单字段下方输入提示
//             $table->string('helpertext')->nullable();

//             // 默认值
//             $table->string('default_value')->nullable();

//             // 可选值
//             $table->string('options')->nullable();

//             // 验证规则
//             $table->string('rules')->nullable();

//             // 字段占位符
//             $table->string('placeholder')->nullable();

//             // 初始语言版本
//             $table->string('langcode', 12);

//             // 时间戳
//             $table->timestamps();
//         });

//         $this->seed();
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         foreach (MessageField::all() as $field) {
//             $field->tableDown();
//         }

//         Schema::dropIfExists('message_fields');
//     }

//     /**
//      * 填充数据
//      *
//      * @return void
//      */
//     protected function seed()
//     {
//         DB::beginTransaction();
//         MessageFieldSeeder::seed();
//         DB::commit();

//         MessageFieldSeeder::afterSeeding();
//     }
// }
