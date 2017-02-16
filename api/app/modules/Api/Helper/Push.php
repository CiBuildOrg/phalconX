<?php
namespace Api\Helper;

use Engine\Helper as EnHelper;
use Phalcon\DI;

/**
 * Push notification helper using OneSignal
 *
 * @category  Activity
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Push extends EnHelper
{
    public static function sendMessage(string $langcode, string $message, array $players, array $data)
    {
        $config = DI::getDefault()->get('config');

        $content = [
            $langcode => $message
        ];

        $fields = [
            'app_id' => $config->default->onesignalClient->appId,
            'include_player_ids' => $players,
            'data' => $data,
            'contents' => $content,
            'content_available' => true,
            'ios_badgeType' => 'Increase',
            'ios_badgeCount' => '1'
        ];

		$fields = json_encode($fields);
    	// print("\nJSON sent:\n");
    	// print($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic ' . $config->default->onesignalClient->authKey));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}
}
