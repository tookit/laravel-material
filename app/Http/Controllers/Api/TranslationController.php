<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {

        $translate = new GoogleTranslate();
        $translate->setSource('en');
        $translate->setTarget($request->get('target'));
        $translate->setOptions([
            'headers' => [
                'user-agent'=> 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML,',
            ]
        ]);
        $translate->setUrl('https://translate.google.com/translate_a/single');
        $data['text'] = $translate->translate($request->get('text'));
        $data['source'] = 'en';
        $data['target'] = $request->get('target');
        return new JsonResource($data);
    }


    public function getFieldTranslation(Request $request)
    {
        $class = $request->get('model');
        $id = $request->get('id');
        $field = $request->get('field');
        $item = app()->make($class)->find($id);
        return new JsonResource($item->getTranslations($field));

    }


    public function updateFieldTranslation(Request $request)
    {
        $class = $request->get('model');
        $id = $request->get('id');
        $field = $request->get('field');
        $translations = $request->get('translations');
        $item = app()->make($class)->find($id);
        $item->setTranslations($field,$translations);
        $item->save();
        $resource = new JsonResource($item);
        return $resoure
            ->additional(
                [
                    'meta' =>
                        [
                            'message' => 'Translation updated',
                        ]
                ]
            );

    }

}
