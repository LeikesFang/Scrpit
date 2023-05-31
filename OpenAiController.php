<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Jobs\ProcessChatGPTResponse;
use Cache;
use GatewayClient\Gateway;

class OpenAiController extends Controller
{
	public function getModelList(){
		$client = new Client([
			'base_uri' => 'https://api.openai.com/v1/',
		]);

		$response = $client->get('models',[
			'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('services.openai.secret_key'),
            ]
		]);

		$responseData = json_decode($response->getBody(), true);

		return response()->json([
            'text' => $responseData,
        ]);
	}

    public function generateText(Request $request)
	{

		$openaiClient = \Tectalic\OpenAi\Manager::build(
		    new \GuzzleHttp\Client(),
		    new \Tectalic\OpenAi\Authentication(getenv('OPENAI_API_KEY'))
		);

		/** @var \Tectalic\OpenAi\Models\ChatCompletions\CreateResponse $response */
		$response = $openaiClient->chatCompletions()->create(
		    new \Tectalic\OpenAi\Models\ChatCompletions\CreateRequest([
		        'model' => 'gpt-3.5-turbo',
		        'messages' => [
		            [
		                'role' => 'user',
		                'content' => 'Will using a well designed and supported third party package save time?'
		            ],
		        ],
		    ])
		)->toModel();

		echo $response->choices[0]->message->content;
		// dd(base_path());
	    // 获取当前对话内容
	    // $content = $request->input('content');

	 //    Gateway::$registerAddress = 'your_register_address'; // 设置注册中心地址
        
  //       // 连接到 ChatGPT 的 WebSocket
  //       Gateway::connect('ws://chatgpt_websocket_url');

	 //    // dd($client);

	 //    $messages = [
	 //    	'role' => 'user',
  //       	'content' => $request->input('content')
	 //    ];

	 //    // 缓存当前对话内容
	 //    Cache::put('chat_content', $request->input('content'));

	 //    // 调用ChatGPT的API获取回复内容
	 //    $client = new Client(['base_uri' => 'https://api.openai.com/v1/']);
	 //    $response = $client->post('chat/completions', [
	 //        'headers' => [
	 //            'Content-Type' => 'application/json',
	 //            'Authorization' => 'Bearer ' . config('services.openai.secret_key'),
	 //        ],
	 //        'json' => [
	 //        	'model' => 'gpt-3.5-turbo',
	 //            'messages' => [$messages],
	 //            'max_tokens' => 128,
	 //            'temperature' => 0.7,
	 //            'stop' => ['\n'],
	 //        ],
	 //    ]);
	 //    $responseData = json_decode($response->getBody(), true);
	 //    if (isset($responseData['choices'][0]['text'])) {
		//     $text = $responseData['choices'][0]['text'];
		// } else {
		//     $text = '';
		// }

	 //    // 将回复内容按照一定速度逐步输出
	 //    $result = [];
	 //    $chars = str_split($text);
	 //    foreach ($chars as $char) {
	 //        $result[] = $char;
	 //    }
	 }
}