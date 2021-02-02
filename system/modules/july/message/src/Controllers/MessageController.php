<?php

namespace July\Message\Controllers;

use App\Http\Controllers\Controller;
use App\Utils\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use July\Message\Message;
use July\Message\MessageForm;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'models' => Message::allWithFields('subject'),
            'context' => [
                'molds' => MessageForm::query()->pluck('label', 'id')->all(),
                'languages' => Lang::getTranslatableLangnames(),
            ],
        ];

        return view('message::message.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \July\Message\MessageForm  $form
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request, MessageForm $form)
    {
        // 获取验证规则
        [$rules, $messages, $fields] = $form->resolveFieldRules();

        // 生成验证器
        $validator = Validator::make($attributes = $request->all(), $rules, $messages);

        // 执行验证，如果未通过，则返回验证错误页
        if ($validator->fails()) {
            // dd($validator->errors());
            return view('message::failed', [
                    'errors' => $validator->errors(),
                    'fields' => $fields,
                ]);
        }

        // 保存消息到数据库
        $message = Message::create($attributes += [
            'mold_id' => $form->getKey(),
            'langcode' => langcode('request'),
        ]);

        // 发送消息
        try {
            $message->send();
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            Log::info($attributes);
        }

        // 获取返回网址
        $backTo = $request->input('_back_to') ?? URL::previous();

        // 返回成功页面，在此页面中嵌入返回地址
        return view('message::success', ['back_to' => $backTo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \July\Message\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return $message->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \July\Message\MessageForm  $form
     * @return \Illuminate\Http\Response
     */
    public function create(MessageForm $form)
    {
        //
    }

    /**
     * 展示编辑或翻译界面
     *
     * @param  \July\Message\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \July\Message\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \July\Message\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        // Log::info($node->id);
        $message->delete();

        return response('');
    }
}
