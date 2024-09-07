<?php
    class TelegramBot {
        private $apiUrl;

        public function __construct() {
            $botToken = "7308613248:AAHpR_ZJiVDGQ-LmckEG9JoEP_AIBuCT2Dw";
            $this->apiUrl = 'https://api.telegram.org/bot' . $botToken . '/';
        }
        public function sendRequest($method, $params = []) {
            $params['method'] = $method;
            $handle = curl_init($this->apiUrl . $method);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($handle, CURLOPT_TIMEOUT, 60);
            curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            $result = curl_exec($handle);
            curl_close($handle);
            return $result;
        }
        public function getChatMembersCount($chatId) {
            // Define the method and parameters
            $params = [
                'chat_id' => $chatId
            ];

            // Call sendRequest method with GET request type
            $response = $this->sendRequest("getChatMembersCount", $params);

            // Decode the JSON response
            $data = json_decode($response, true);
            if($data["ok"]) {
                return $data['result'];
            }else{
                return 0;
            }

        }

        public function getUpdate(){
            $content = file_get_contents("php://input");
            $update = json_decode($content,true);
            return $update;
        }
        public function get_messageinfo() {
            $update = $this->getUpdate();
            $message_info = [];
            $message_id = 0;

            // اگر update از نوع message باشد
            if (isset($update["message"])) {
                $user_id = $update["message"]["from"]["id"];
                $first_name = $update["message"]["from"]["first_name"];
                $current_date = $update["message"]["date"];
                $chat_id = $update['message']['chat']['id'];
                $chat_type = $update['message']['chat']['type'];
                $date = date("Y-m-d H:i:s", $current_date);
                $get_message_info = null;
                // تفکیک انواع پیام‌ها
                if (isset($update['message']['text'])) {
                    $message = $update['message']['text'];
                    $message_type = 'text';
                } elseif (isset($update['message']['photo'])) {
                    $message = $update['message']['photo'];
                    $message_type = 'photo';
                    $photos = $update['message']['photo'];
                    $largest_photo = end($photos); // انتخاب بزرگترین تصویر
                    $file_id = $largest_photo['file_id'];
                    $file_size = $largest_photo['file_size'];
                    $width = $largest_photo['width'];
                    $height = $largest_photo['height'];
                    $get_message_info = [
                        'file_id' => $file_id,
                        'file_size' => $file_size,
                        'width' => $width,
                        'height' => $height
                    ];
                } elseif (isset($update['message']['video'])) {
                    $message = $update['message']['video'];
                    $message_type = 'video';
                    $file_id = $message['file_id'];
                    $file_size = $message['file_size'];
                    $duration = $message['duration'];
                    $mime_type = $message['mime_type'];
                    $width = $message['width'];
                    $height = $message['height'];
                    $get_message_info = [
                        'file_id' => $file_id,
                        'file_size' => $file_size,
                        'duration' => $duration,
                        'mime_type' => $mime_type,
                        'width' => $width,
                        'height' => $height
                    ];
                } elseif (isset($update['message']['document'])) {
                    $message = $update['message']['document'];
                    $message_type = 'document';
                    $file_id = $message['file_id'];
                    $file_name = $message['file_name'];
                    $mime_type = $message['mime_type'];
                    $file_size = $message['file_size'];
                    $get_message_info = [
                        'file_id' => $file_id,
                        'file_name' => $file_name,
                        'mime_type' => $mime_type,
                        'file_size' => $file_size
                    ];
                } else {
                    $message = null;
                    $message_type = 'unknown';
                }

                $message_id = $update['message']['message_id'];

                $message_info = [
                    "user_id" => $user_id,
                    "first_name" => $first_name,
                    "date" => $date,
                    "chat_id" => $chat_id,
                    "message" => $message,
                    "message_type" => $message_type, // نوع پیام
                    "message_id" => $message_id,
                    "message_info" => $get_message_info,
                    "callback_data" => null,
                    "type"=>$chat_type
                ];
                if ($chat_type === 'group' || $chat_type === 'supergroup') {
                    $group_name = isset($update['message']['chat']['title']) ? $update['message']['chat']['title'] : null;
                    $message_info["group_info"] = [
                        'group_name' => $group_name,
                        'group_id' => $chat_id
                    ];
                }
                if(isset($update["message"]['new_chat_members'])){
                    $message_info['new_chat_members'] = true;
                }
            }

            // اگر update از نوع callback_query باشد
            if (isset($update["callback_query"])) {
                $user_id = $update["callback_query"]["from"]["id"];
                $first_name = $update["callback_query"]["from"]["first_name"];
                $chat_id = $update["callback_query"]["message"]["chat"]["id"];
                $callback_data = isset($update["callback_query"]["data"]) ? $update["callback_query"]["data"] : null;
                $chat_type = $update["callback_query"]["message"]["chat"]["type"];
                $message_info = [
                    "user_id" => $user_id,
                    "first_name" => $first_name,
                    "date" => null,
                    "chat_id" => $chat_id,
                    "message" => null,
                    "message_type" => null, // نوع پیام
                    "message_id" => $message_id,
                    "callback_data" => $callback_data,
                    "type"=>$chat_type
                ];
            }

            return $message_info;
        }
        public function updateMediaMessage($chat_id, $type, $message_id, $new_media) {
            $media = [
                'type' => $type,  // نوع رسانه: 'photo', 'video', 'document' و غیره
                'media' => $new_media, // فایل جدید
            ];

            $params = [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'media' => json_encode($media),
            ];
            return $this->sendRequest('editMessageMedia', $params);
        }
        public function editMediaCaption($chat_id, $message_id, $caption_name, $btn = null) {
            $params = [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'caption' => $caption_name,
            ];

            // اگر دکمه‌های Inline تعریف شده‌اند، آنها را اضافه کنید
            if (!is_null($btn)) {
                $params['reply_markup'] = json_encode([
                    'inline_keyboard' => $btn
                ]);
            }

            return $this->sendRequest('editMessageCaption', $params);
        }

        public function insertMediaCaption($chat_id, $caption_name,$photo, $btn = null) {
            $params = [
                'chat_id' => $chat_id,
                'caption' => $caption_name,
                'photo' => $photo, // مسیر فایل یا لینک عکس
            ];

            // اگر دکمه‌های Inline تعریف شده‌اند، آنها را اضافه کنید
            if (!is_null($btn)) {
                $params['reply_markup'] = json_encode([
                    'inline_keyboard' => $btn
                ]);
            }

            return $this->sendRequest('sendPhoto', $params);
        }


        public function updateTextMessage($chat_id, $message_id, $new_text, $inline_keyboard = null) {
            $params = [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => $new_text,
                'parse_mode' => 'HTML' // یا 'Markdown' بسته به نیاز شما
            ];

            if (!is_null($inline_keyboard)) {
                $params['reply_markup'] = json_encode(['inline_keyboard' => $inline_keyboard]);
            }

            return $this->sendRequest('editMessageText', $params);
        }
        public function chat_id(){
            $update = $this->getUpdate();
            $chat_id = $update['message']['chat']['id'];
            return $chat_id;
        }
//        public function isMemberOfGroup($chatId, $userId) {
//            $params = [
//                'chat_id' => $chatId,
//                'user_id' => $userId
//            ];
//            $result = $this->sendRequest('getChatMember', $params);
//            $resultArray = json_decode($result, true);
//
//            if (isset($resultArray['result']['status'])) {
//                $status = $resultArray['result']['status'];
//                return ($status == 'member' || $status == 'administrator' || $status == 'creator');
//            }
//
//            return false; // اگر کاربر عضو نیست یا خطایی رخ داده باشد
//        }
        public function isMemberOfGroup($chat_id, $user_id) {
            // پارامترهای مورد نیاز برای getChatMember
            $params = [
                'chat_id' => $chat_id,
                'user_id' => $user_id
            ];

            // ارسال درخواست به متد getChatMember
            $response = $this->sendRequest('getChatMember', $params);

            // تبدیل نتیجه به یک آرایه
            $responseArray = json_decode($response, true);

            // بررسی اینکه درخواست موفق بوده و اطلاعات کاربر موجود است
            if (isset($responseArray['result']['status'])) {
                return $responseArray['result']['status'];
            } else {
                // خطا در دریافت اطلاعات کاربر
                return false;
            }
        }
        // 1. ارسال پیام متنی
        public function sendMessage($chatId, $text, $parseMode = 'TEXT') {
            $params = [
                'chat_id' => $chatId,
                'text' => $text,
            ];
            if($parseMode == 'HTML') {
                $params['parse_mode'] = "HTML";
            }
            return $this->sendRequest('sendMessage', $params);
        }
        // 2. ارسال عکس
        public function sendPhoto($chatId, $photoUrl, $caption = '', $parseMode = 'HTML') {
            $params = [
                'chat_id' => $chatId,
                'photo' => $photoUrl,
                'caption' => $caption,
                'parse_mode' => $parseMode
            ];
            return $this->sendRequest('sendPhoto', $params);
        }
        public function sendBTNPhoto($chatId, $photoUrl, $caption = '', $btn = null,$parseMode = "HTML") {
            $params = [
                'chat_id' => $chatId,
                'photo' => $photoUrl,
                'caption' => $caption,
                'parse_mode' => $parseMode
            ];

            // اگر دکمه‌های Inline تعریف شده‌اند، آنها را اضافه کنید
            if (!is_null($btn)) {
                $params['reply_markup'] = json_encode([
                    'inline_keyboard' => $btn
                ]);
            }

            return $this->sendRequest('sendPhoto', $params);
        }

        // 3. ارسال دکمه‌های اینلاین
        public function sendButton($chatId, $text, $buttons, $parseMode = 'HTML') {
            $keyboard = [
                'inline_keyboard' => $buttons
            ];
            $params = [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => $parseMode,
                'reply_markup' => json_encode($keyboard)
            ];
            return $this->sendRequest('sendMessage', $params);
        }
        // 4. ارسال پیام صوتی
        public function sendVoice($chatId, $voiceUrl, $caption = '', $duration = null, $parseMode = 'HTML') {
            $params = [
                'chat_id' => $chatId,
                'voice' => $voiceUrl,
                'caption' => $caption,
                'duration' => $duration,
                'parse_mode' => $parseMode
            ];
            return $this->sendRequest('sendVoice', $params);
        }
        // 5. ارسال پیام ویدیویی
        public function sendVideo($chatId, $videoUrl, $caption = '', $parseMode = 'HTML', $supportsStreaming = false) {
            $params = [
                'chat_id' => $chatId,
                'video' => $videoUrl,
                'caption' => $caption,
                'parse_mode' => $parseMode,
                'supports_streaming' => $supportsStreaming
            ];
            return $this->sendRequest('sendVideo', $params);
        }
        // 6. ارسال موقعیت مکانی
        public function sendLocation($chatId, $latitude, $longitude) {
            $params = [
                'chat_id' => $chatId,
                'latitude' => $latitude,
                'longitude' => $longitude
            ];
            return $this->sendRequest('sendLocation', $params);
        }
        // 7. ارسال پیام با استیکر
        public function sendSticker($chatId, $stickerUrl) {
            $params = [
                'chat_id' => $chatId,
                'sticker' => $stickerUrl
            ];
            return $this->sendRequest('sendSticker', $params);
        }
        // 8. ارسال پیام متنی با صفحه کلید کیبورد
        public function sendKeyboard($chatId, $text, $keyboard, $resizeKeyboard = true, $oneTimeKeyboard = false, $parseMode = 'HTML') {
            $replyMarkup = [
                'keyboard' => $keyboard,
                'resize_keyboard' => $resizeKeyboard,
                'one_time_keyboard' => $oneTimeKeyboard
            ];
            $params = [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => $parseMode,
                'reply_markup' => json_encode($replyMarkup)
            ];
            return $this->sendRequest('sendMessage', $params);
        }
        // 9. ارسال پیام مخاطب
        public function sendContact($chatId, $phoneNumber, $firstName, $lastName = '') {
            $params = [
                'chat_id' => $chatId,
                'phone_number' => $phoneNumber,
                'first_name' => $firstName,
                'last_name' => $lastName
            ];
            return $this->sendRequest('sendContact', $params);
        }
        // 10. ارسال انیمیشن (GIF)
        public function sendAnimation($chatId, $animationUrl, $caption = '', $parseMode = 'HTML') {
            $params = [
                'chat_id' => $chatId,
                'animation' => $animationUrl,
                'caption' => $caption,
                'parse_mode' => $parseMode
            ];
            return $this->sendRequest('sendAnimation', $params);
        }
        // 11. ارسال فایل صوتی (موزیک)
        public function sendAudio($chatId, $audioUrl, $caption = '', $performer = '', $title = '', $duration = null, $parseMode = 'HTML') {
            $params = [
                'chat_id' => $chatId,
                'audio' => $audioUrl,
                'caption' => $caption,
                'performer' => $performer,
                'title' => $title,
                'duration' => $duration,
                'parse_mode' => $parseMode
            ];
            return $this->sendRequest('sendAudio', $params);
        }
        // 12. ارسال پیام ویدیویی کوتاه (Video Note)
        public function sendVideoNote($chatId, $videoNoteUrl, $duration = null, $length = null) {
            $params = [
                'chat_id' => $chatId,
                'video_note' => $videoNoteUrl,
                'duration' => $duration,
                'length' => $length
            ];
            return $this->sendRequest('sendVideoNote', $params);
        }
        // 13. ارسال فایل
        public function sendDocument($chatId, $documentUrl, $caption = '', $parseMode = 'HTML') {
            $params = [
                'chat_id' => $chatId,
                'document' => $documentUrl,
                'caption' => $caption,
                'parse_mode' => $parseMode
            ];
            return $this->sendRequest('sendDocument', $params);
        }
        // 14. ارسال پرسش با جواب (Poll)
        public function sendPoll($chatId, $question, $options = [], $isAnonymous = true, $type = 'regular', $allowsMultipleAnswers = false) {
            $params = [
                'chat_id' => $chatId,
                'question' => $question,
                'options' => json_encode($options),
                'is_anonymous' => $isAnonymous,
                'type' => $type,
                'allows_multiple_answers' => $allowsMultipleAnswers
            ];
            return $this->sendRequest('sendPoll', $params);
        }
        // 15. ارسال کیبورد ریموت (Inline Keyboard)
        public function sendInlineKeyboard($chatId, $text, $inlineKeyboard, $parseMode = 'HTML') {
            $replyMarkup = [
                'inline_keyboard' => $inlineKeyboard
            ];
            $params = [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => $parseMode,
                'reply_markup' => json_encode($replyMarkup)
            ];
            return $this->sendRequest('sendMessage', $params);
        }
        // 16. ارسال پیغام در جواب به پیغام دیگر (Reply)
        public function sendReplyMessage($chatId, $text, $replyToMessageId, $parseMode = 'HTML') {
            $params = [
                'chat_id' => $chatId,
                'text' => $text,
                'reply_to_message_id' => $replyToMessageId,
                'parse_mode' => $parseMode
            ];
            return $this->sendRequest('sendMessage', $params);
        }
        // 17. فروارد پیام (Forward Message)
        public function forwardMessage($chatId, $fromChatId, $messageId) {
            $params = [
                'chat_id' => $chatId,
                'from_chat_id' => $fromChatId,
                'message_id' => $messageId
            ];
            return $this->sendRequest('forwardMessage', $params);
        }
        // 18. ارسال پیام‌های چند رسانه‌ای (Media Group)
        public function sendMediaGroup($chatId, $media = []) {
            $params = [
                'chat_id' => $chatId,
                'media' => json_encode($media)
            ];
            return $this->sendRequest('sendMediaGroup', $params);
        }
        // 19. ویرایش پیام (Edit Message Text)
        public function editMessageText($chatId, $messageId, $text, $parseMode = 'HTML') {
            $params = [
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'text' => $text,
                'parse_mode' => $parseMode
            ];
            return $this->sendRequest('editMessageText', $params);
        }
        // 20. ویرایش کیبورد یک پیام (Edit Message Reply Markup)
        public function editMessageReplyMarkup($chatId, $messageId, $inlineKeyboard) {
            $params = [
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'reply_markup' => json_encode(['inline_keyboard' => $inlineKeyboard])
            ];
            return $this->sendRequest('editMessageReplyMarkup', $params);
        }
        // 21. حذف پیام (Delete Message)
        public function deleteMessage($chatId, $messageId) {
            $params = [
                'chat_id' => $chatId,
                'message_id' => $messageId
            ];
            return $this->sendRequest('deleteMessage', $params);
        }
        // 22. ارسال پرسش و جواب (Quiz)
        public function sendQuiz($chatId, $question, $options = [], $correctOptionId, $isAnonymous = true) {
            $params = [
                'chat_id' => $chatId,
                'question' => $question,
                'options' => json_encode($options),
                'correct_option_id' => $correctOptionId,
                'is_anonymous' => $isAnonymous,
                'type' => 'quiz'
            ];
            return $this->sendRequest('sendPoll', $params);
        }
        // 23. ارسال پیام دلخواه (Custom Request)
        public function customRequest($method, $params = []) {
            return $this->sendRequest($method, $params);
        }
        // 24. تغییر عنوان چت (Set Chat Title)
        public function setChatTitle($chatId, $title) {
            $params = [
                'chat_id' => $chatId,
                'title' => $title
            ];
            return $this->sendRequest('setChatTitle', $params);
        }
        // 25. تغییر توضیحات چت (Set Chat Description)
        public function setChatDescription($chatId, $description) {
            $params = [
                'chat_id' => $chatId,
                'description' => $description
            ];
            return $this->sendRequest('setChatDescription', $params);
        }
        public function sendWebAppMessage($chatId,$button_title, $webAppUrl, $text) {
            $buttons = [
                [
                    ['text' => $button_title, 'web_app' => ['url' => $webAppUrl]]
                ]
            ];

            return $this->sendButton($chatId, $text, $buttons, "HTML");
        }
        public function banChatMember($chat_id, $user_id, $until_date = null) {
            $params = [
                'chat_id' => $chat_id,
                'user_id' => $user_id
            ];

            if ($until_date) {
                $params['until_date'] = $until_date;
            }

            return $this->sendRequest('banChatMember', $params);
        }
        public function restrictChatMember($chat_id, $user_id, $until_date, $permissions) {
            $params = [
                'chat_id' => $chat_id,
                'user_id' => $user_id,
                'permissions' => $permissions,
                'until_date' => $until_date
            ];
            return $this->sendRequest('restrictChatMember', $params);
        }
    }
?>