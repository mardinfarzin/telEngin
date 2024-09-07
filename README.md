# Hi there

## This engine connects to the Telegram API to control your bot using PHP.

### To use this engine, create your bot in BotFather and obtain a token. After that, you can use the token in the `__construct` function in the `$botToken` variable. The engine is ready to use.

### Example usage includes:
* Getting group and channel member counts
* Retrieving message information
* Inserting and updating media messages
* Inserting and updating text messages
* Checking if a user is in a group or channel
* Sending voice messages, locations, etc.
* Sending inline buttons and simple keyboard buttons
* Banning users
* Restricting users
* And more

The file contains descriptions to guide you.

## `TelegramBot` Class

The `TelegramBot` class provides methods to interact with the Telegram Bot API.

### Properties
- `private $apiUrl` - URL for API requests.

### Methods

#### `__construct()`
Initializes the bot with a token and sets the API URL.

#### `sendRequest($method, $params = [])`
Sends a request to the Telegram Bot API.

**Parameters:**
- `string $method`: API method to call.
- `array $params`: Parameters for the API method.

**Returns:**
- `string`: API response.

#### `getChatMembersCount($chatId)`
Gets the number of members in a chat.

**Parameters:**
- `int $chatId`: Chat ID.

**Returns:**
- `int`: Number of chat members.

#### `getUpdate()`
Retrieves the latest update from Telegram.

**Returns:**
- `array`: Update data.

#### `get_messageinfo()`
Extracts information about a message or callback query from the update.

**Returns:**
- `array`: Message information including user ID, message type, etc.

#### `updateMediaMessage($chat_id, $type, $message_id, $new_media)`
Updates media in a message.

**Parameters:**
- `int $chat_id`: Chat ID.
- `string $type`: Media type.
- `int $message_id`: Message ID.
- `string $new_media`: New media URL or file ID.

**Returns:**
- `string`: API response.

#### `editMediaCaption($chat_id, $message_id, $caption_name, $btn = null)`
Edits the caption of a media message.

**Parameters:**
- `int $chat_id`: Chat ID.
- `int $message_id`: Message ID.
- `string $caption_name`: New caption.
- `array|null $btn`: Optional inline keyboard buttons.

**Returns:**
- `string`: API response.

#### `insertMediaCaption($chat_id, $caption_name, $photo, $btn = null)`
Sends a photo with a caption.

**Parameters:**
- `int $chat_id`: Chat ID.
- `string $caption_name`: Caption for the photo.
- `string $photo`: Photo URL or file ID.
- `array|null $btn`: Optional inline keyboard buttons.

**Returns:**
- `string`: API response.

#### `updateTextMessage($chat_id, $message_id, $new_text, $inline_keyboard = null)`
Updates the text of a message.

**Parameters:**
- `int $chat_id`: Chat ID.
- `int $message_id`: Message ID.
- `string $new_text`: New message text.
- `array|null $inline_keyboard`: Optional inline keyboard buttons.

**Returns:**
- `string`: API response.

#### `chat_id()`
Gets the chat ID from the update.

**Returns:**
- `int`: Chat ID.

#### `isMemberOfGroup($chat_id, $user_id)`
Checks if a user is a member of a group.

**Parameters:**
- `int $chat_id`: Group chat ID.
- `int $user_id`: User ID.

**Returns:**
- `string|false`: User's status or `false` on error.

#### `sendMessage($chatId, $text, $parseMode = 'TEXT')`
Sends a text message.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $text`: Message text.
- `string $parseMode`: Optional parse mode (`'HTML'` or `'TEXT'`).

**Returns:**
- `string`: API response.

#### `sendPhoto($chatId, $photoUrl, $caption = '', $parseMode = 'HTML')`
Sends a photo.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $photoUrl`: Photo URL or file ID.
- `string $caption`: Optional caption.
- `string $parseMode`: Optional parse mode.

**Returns:**
- `string`: API response.

#### `sendBTNPhoto($chatId, $photoUrl, $caption = '', $btn = null, $parseMode = "HTML")`
Sends a photo with an inline keyboard.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $photoUrl`: Photo URL or file ID.
- `string $caption`: Optional caption.
- `array|null $btn`: Optional inline keyboard buttons.
- `string $parseMode`: Optional parse mode.

**Returns:**
- `string`: API response.

#### `sendButton($chatId, $text, $buttons, $parseMode = 'HTML')`
Sends a message with inline buttons.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $text`: Message text.
- `array $buttons`: Inline keyboard buttons.
- `string $parseMode`: Optional parse mode.

**Returns:**
- `string`: API response.

#### `sendVoice($chatId, $voiceUrl, $caption = '', $duration = null, $parseMode = 'HTML')`
Sends a voice message.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $voiceUrl`: Voice file URL or file ID.
- `string $caption`: Optional caption.
- `int|null $duration`: Optional duration.
- `string $parseMode`: Optional parse mode.

**Returns:**
- `string`: API response.

#### `sendVideo($chatId, $videoUrl, $caption = '', $parseMode = 'HTML', $supportsStreaming = false)`
Sends a video.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $videoUrl`: Video URL or file ID.
- `string $caption`: Optional caption.
- `string $parseMode`: Optional parse mode.
- `bool $supportsStreaming`: Optional flag for streaming support.

**Returns:**
- `string`: API response.

#### `sendLocation($chatId, $latitude, $longitude)`
Sends a location.

**Parameters:**
- `int $chatId`: Chat ID.
- `float $latitude`: Latitude.
- `float $longitude`: Longitude.

**Returns:**
- `string`: API response.

#### `sendSticker($chatId, $stickerUrl)`
Sends a sticker.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $stickerUrl`: Sticker URL or file ID.

**Returns:**
- `string`: API response.

#### `sendKeyboard($chatId, $text, $keyboard, $resizeKeyboard = true, $oneTimeKeyboard = false, $parseMode = 'HTML')`
Sends a message with a custom keyboard.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $text`: Message text.
- `array $keyboard`: Custom keyboard layout.
- `bool $resizeKeyboard`: Optional flag to resize keyboard.
- `bool $oneTimeKeyboard`: Optional flag for one-time use.
- `string $parseMode`: Optional parse mode.

**Returns:**
- `string`: API response.

#### `sendContact($chatId, $phoneNumber, $firstName, $lastName = '')`
Sends a contact.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $phoneNumber`: Contact phone number.
- `string $firstName`: Contact's first name.
- `string $lastName`: Optional last name.

**Returns:**
- `string`: API response.

#### `sendAnimation($chatId, $animationUrl, $caption = '', $parseMode = 'HTML')`
Sends an animation (GIF).

**Parameters:**
- `int $chatId`: Chat ID.
- `string $animationUrl`: Animation URL or file ID.
- `string $caption`: Optional caption.
- `string $parseMode`: Optional parse mode.

**Returns:**
- `string`: API response.

#### `sendAudio($chatId, $audioUrl, $caption = '', $performer = '', $title = '', $duration = null, $parseMode = 'HTML')`
Sends an audio file.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $audioUrl`: Audio URL or file ID.
- `string $caption`: Optional caption.
- `string $performer`: Optional performer.
- `string $title`: Optional title.
- `int|null $duration`: Optional duration.
- `string $parseMode`: Optional parse mode.

**Returns:**
- `string`: API response.

#### `sendVideoNote($chatId, $videoNoteUrl, $duration = null, $length = null)`
Sends a video note.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $videoNoteUrl`: Video note URL or file ID.
- `int|null $duration`: Optional duration.
- `int|null $length`: Optional length.

**Returns:**
- `string`: API response.

#### `sendDocument($chatId, $documentUrl, $caption = '', $parseMode = 'HTML')`
Sends a document.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $documentUrl`: Document URL or file ID.
- `string $caption`: Optional caption.
- `string $parseMode`: Optional parse mode.

**Returns:**
- `string`: API response.

#### `sendPoll($chatId, $question, $options = [], $isAnonymous = true, $type = 'regular', $allowsMultipleAnswers = false)`
Sends a poll.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $question`: Poll question.
- `array $options`: Poll options.
- `bool $isAnonymous`: Optional anonymity flag.
- `string $type`: Optional poll type (`'regular'` or `'quiz'`).
- `bool $allowsMultipleAnswers`: Optional flag for multiple answers.

**Returns:**
- `string`: API response.

#### `sendDice($chatId, $emoji = '')`
Sends a dice roll.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $emoji`: Optional emoji (default is 🎲).

**Returns:**
- `string`: API response.

#### `sendInvoice($chatId, $title, $description, $payload, $providerToken, $startParameter, $currency, $prices, $photoUrl = '', $photoSize = 0, $photoWidth = 0, $photoHeight = 0, $needName = true, $needPhoneNumber = true, $needEmail = true, $needShippingAddress = false, $sendPhoneNumberToProvider = false, $sendEmailToProvider = false, $isFlexible = false)`
Sends an invoice.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $title`: Invoice title.
- `string $description`: Invoice description.
- `string $payload`: Invoice payload.
- `string $providerToken`: Payment provider token.
- `string $startParameter`: Optional start parameter.
- `string $currency`: Currency code.
- `array $prices`: Item prices.
- `string $photoUrl`: Optional photo URL.
- `int $photoSize`: Optional photo size.
- `int $photoWidth`: Optional photo width.
- `int $photoHeight`: Optional photo height.
- `bool $needName`: Optional flag for name.
- `bool $needPhoneNumber`: Optional flag for phone number.
- `bool $needEmail`: Optional flag for email.
- `bool $needShippingAddress`: Optional flag for shipping address.
- `bool $sendPhoneNumberToProvider`: Optional flag to send phone number to provider.
- `bool $sendEmailToProvider`: Optional flag to send email to provider.
- `bool $isFlexible`: Optional flag for flexible payment.

**Returns:**
- `string`: API response.

#### `sendGame($chatId, $gameShortName)`
Sends a game.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $gameShortName`: Game short name.

**Returns:**
- `string`: API response.
  
#### `sendVideo($chatId, $videoUrl, $caption = '', $parseMode = 'HTML', $supportsStreaming = false)`
Sends a video.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $videoUrl`: URL of the video.
- `string $caption`: (Optional) Video caption.
- `string $parseMode`: (Optional) HTML or Markdown parse mode for captions. Default is 'HTML'.
- `bool $supportsStreaming`: (Optional) Whether the video supports streaming. Default is `false`.

**Returns:**
- `string`: API response.

---

#### `sendLocation($chatId, $latitude, $longitude)`
Sends a location.

**Parameters:**
- `int $chatId`: Chat ID.
- `float $latitude`: Latitude of the location.
- `float $longitude`: Longitude of the location.

**Returns:**
- `string`: API response.

---

#### `sendSticker($chatId, $stickerUrl)`
Sends a sticker.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $stickerUrl`: URL of the sticker.

**Returns:**
- `string`: API response.

---

#### `sendKeyboard($chatId, $text, $keyboard, $resizeKeyboard = true, $oneTimeKeyboard = false, $parseMode = 'HTML')`
Sends a text message with a custom keyboard.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $text`: Message text.
- `array $keyboard`: Keyboard layout.
- `bool $resizeKeyboard`: (Optional) Whether to resize the keyboard. Default is `true`.
- `bool $oneTimeKeyboard`: (Optional) Whether the keyboard is hidden after use. Default is `false`.
- `string $parseMode`: (Optional) HTML or Markdown parse mode for the text. Default is 'HTML'.

**Returns:**
- `string`: API response.

---

#### `sendContact($chatId, $phoneNumber, $firstName, $lastName = '')`
Sends a contact.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $phoneNumber`: Phone number of the contact.
- `string $firstName`: First name of the contact.
- `string $lastName`: (Optional) Last name of the contact.

**Returns:**
- `string`: API response.

---

#### `sendAnimation($chatId, $animationUrl, $caption = '', $parseMode = 'HTML')`
Sends an animation (GIF).

**Parameters:**
- `int $chatId`: Chat ID.
- `string $animationUrl`: URL of the animation.
- `string $caption`: (Optional) Animation caption.
- `string $parseMode`: (Optional) HTML or Markdown parse mode for captions. Default is 'HTML'.

**Returns:**
- `string`: API response.

---

#### `sendAudio($chatId, $audioUrl, $caption = '', $performer = '', $title = '', $duration = null, $parseMode = 'HTML')`
Sends an audio file.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $audioUrl`: URL of the audio file.
- `string $caption`: (Optional) Audio caption.
- `string $performer`: (Optional) Performer of the audio.
- `string $title`: (Optional) Title of the audio.
- `int|null $duration`: (Optional) Duration of the audio in seconds.
- `string $parseMode`: (Optional) HTML or Markdown parse mode for captions. Default is 'HTML'.

**Returns:**
- `string`: API response.

---

#### `sendVideoNote($chatId, $videoNoteUrl, $duration = null, $length = null)`
Sends a video note.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $videoNoteUrl`: URL of the video note.
- `int|null $duration`: (Optional) Duration of the video note in seconds.
- `int|null $length`: (Optional) Length of the video note in pixels.

**Returns:**
- `string`: API response.

---

#### `sendDocument($chatId, $documentUrl, $caption = '', $parseMode = 'HTML')`
Sends a document.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $documentUrl`: URL of the document.
- `string $caption`: (Optional) Document caption.
- `string $parseMode`: (Optional) HTML or Markdown parse mode for captions. Default is 'HTML'.

**Returns:**
- `string`: API response.

---

#### `sendPoll($chatId, $question, $options = [], $isAnonymous = true, $type = 'regular', $allowsMultipleAnswers = false)`
Sends a poll.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $question`: Poll question.
- `array $options`: List of poll options.
- `bool $isAnonymous`: (Optional) Whether the poll is anonymous. Default is `true`.
- `string $type`: (Optional) Poll type, 'regular' or 'quiz'. Default is 'regular'.
- `bool $allowsMultipleAnswers`: (Optional) Whether multiple answers are allowed. Default is `false`.

**Returns:**
- `string`: API response.

---

#### `sendInlineKeyboard($chatId, $text, $inlineKeyboard, $parseMode = 'HTML')`
Sends a text message with an inline keyboard.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $text`: Message text.
- `array $inlineKeyboard`: Inline keyboard layout.
- `string $parseMode`: (Optional) HTML or Markdown parse mode for the text. Default is 'HTML'.

**Returns:**
- `string`: API response.

---

#### `sendReplyMessage($chatId, $text, $replyToMessageId, $parseMode = 'HTML')`
Sends a reply message.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $text`: Message text.
- `int $replyToMessageId`: ID of the message to reply to.
- `string $parseMode`: (Optional) HTML or Markdown parse mode for the text. Default is 'HTML'.

**Returns:**
- `string`: API response.

---

#### `forwardMessage($chatId, $fromChatId, $messageId)`
Forwards a message.

**Parameters:**
- `int $chatId`: Chat ID to forward the message to.
- `int $fromChatId`: Chat ID from which the message will be forwarded.
- `int $messageId`: ID of the message to forward.

**Returns:**
- `string`: API response.

---

#### `sendMediaGroup($chatId, $media = [])`
Sends a media group.

**Parameters:**
- `int $chatId`: Chat ID.
- `array $media`: List of media items in JSON format.

**Returns:**
- `string`: API response.

---

#### `editMessageText($chatId, $messageId, $text, $parseMode = 'HTML')`
Edits the text of a message.

**Parameters:**
- `int $chatId`: Chat ID.
- `int $messageId`: ID of the message to edit.
- `string $text`: New message text.
- `string $parseMode`: (Optional) HTML or Markdown parse mode for the text. Default is 'HTML'.

**Returns:**
- `string`: API response.

---

#### `editMessageReplyMarkup($chatId, $messageId, $inlineKeyboard)`
Edits the reply markup (inline keyboard) of a message.

**Parameters:**
- `int $chatId`: Chat ID.
- `int $messageId`: ID of the message to edit.
- `array $inlineKeyboard`: New inline keyboard layout.

**Returns:**
- `string`: API response.

---

#### `deleteMessage($chatId, $messageId)`
Deletes a message.

**Parameters:**
- `int $chatId`: Chat ID.
- `int $messageId`: ID of the message to delete.

**Returns:**
- `string`: API response.

---

#### `sendQuiz($chatId, $question, $options = [], $correctOptionId, $isAnonymous = true)`
Sends a quiz.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $question`: Quiz question.
- `array $options`: List of quiz options.
- `int $correctOptionId`: ID of the correct option.
- `bool $isAnonymous`: (Optional) Whether the quiz is anonymous. Default is `true`.

**Returns:**
- `string`: API response.

---

#### `customRequest($method, $params = [])`
Sends a custom request to the Telegram API.

**Parameters:**
- `string $method`: API method to call.
- `array $params`: (Optional) Parameters for the API request.

**Returns:**
- `string`: API response.

---

#### `setChatTitle($chatId, $title)`
Changes the title of a chat.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $title`: New chat title.

**Returns:**
- `string`: API response.

---

#### `setChatDescription($chatId, $description)`
Changes the description of a chat.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $description`: New chat description.

**Returns:**
- `string`: API response.

---

#### `sendWebAppMessage($chatId, $button_title, $webAppUrl, $text)`
Sends a message with a Web App button.

**Parameters:**
- `int $chatId`: Chat ID.
- `string $button_title`: Title of the Web App button.
- `string $webAppUrl`: URL of the Web App.
- `string $text`: Message text.

**Returns:**
- `string`: API response.

---

#### `banChatMember($chatId, $userId, $untilDate = null)`
Bans a chat member.

**Parameters:**
- `int $chatId`: Chat ID.
- `int $userId`: User ID to ban.
- `int|null $untilDate`: (Optional) Date until the user is banned.

**Returns:**
- `string`: API response.

---

#### `restrictChatMember($chatId, $userId, $untilDate, $permissions)`
Restricts a chat member.

**Parameters:**
- `int $chatId`: Chat ID.
- `int $userId`: User ID to restrict.
- `int $untilDate`: Date until the restrictions apply.
- `array $permissions`: New chat permissions for the user.

**Returns:**
- `string`: API response.

