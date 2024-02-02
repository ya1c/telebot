<?php

namespace Ya;

/**
 * Simple class for send messages to a chat or to bot.
 */
class Telebot
{
    /**
     * @param $bot_token
     * @param $chat_id
     * @param $url
     * @param $secret_token
     * @param $apiurl
     */
    public function __construct(private $bot_token = "", private $chat_id = "", private $url = "", private $secret_token = "", private $apiurl = "https://api.telegram.org/bot")
    {

    }

    /**
     * @param $method
     * @param $args
     * @return array
     */
    public function __call($method, $args)
    {
        return [];
    }

    /**
     * @param $url
     * @return bool
     */
    public function checkConnect($url = false)
    {
        if(!$this->getBotToken())
        {
            return false;
        }
        if($url)
        {
            if(!$this->url)
            {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $params
     * @return bool
     */
    public function checkParams($params = [])
    {
        if(!$this->getChatId() || !$params)
        {
            return false;
        }

        foreach ($params as $p)
        {
            if(!$p)
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Set webhook for bot
     *
     * @return array|mixed
     */
    public function setWebhook()
    {
        if(!$this->checkConnect(true))
        {
            return [];
        }

        $allowed_updates = ['message', 'callback_query','edited_channel_post'];
        $query = $this->getFullApiUrl() . '/setWebhook?url=' . $this->url . '&allowed_updates='.json_encode($allowed_updates);
        if($this->secret_token)
        {
            $query .= "&secret_token=" . $this->secret_token;
        }
        $content = file_get_contents($query);
        return $this->_errHandler($content);
    }

    /**
     * @return array|mixed
     */
    public function deleteWebhook()
    {
        if(!$this->checkConnect())
        {
            return [];
        }
        $content = file_get_contents($this->getFullApiUrl() . '/deleteWebhook?drop_pending_updates=true');
        return $this->_errHandler($content);
    }

    /**
     * @return array|mixed
     */
    public function getWebhookInfo()
    {
        if(!$this->checkConnect())
        {
            return [];
        }
        $content = file_get_contents($this->getFullApiUrl() . '/getWebhookInfo');
        return $this->_errHandler($content);
    }

    /**
     * @param $response
     * @param $associative
     * @return mixed
     */
    public function _query($response, $associative = true)
    {
        return json_decode($response, $associative);
    }

    /**
     * @param $response
     * @return mixed
     */
    public function _rawquery($response)
    {
        return $response;
    }

    /**
     * @param $response
     * @param $raw
     * @return mixed
     */
    public function _errHandler($response, $raw = false)
    {
        return ($raw) ? $this->_rawquery($response) : $this->_query($response);
    }

    /**
     * Unique identifier for the target chat or username of the target channel e.g.: -10012345678 or 1234567 or @channelusername
     *
     * @param $id
     * @return void
     */
    public function setChatId($id)
    {
        $this->chat_id = $id;
    }

    /**
     * @return string
     */
    public function getChatId()
    {
        return $this->chat_id;
    }

    /**
     * e.g.: 123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11
     *
     * @param $token
     * @return void
     */
    public function setBotToken($token)
    {
        $this->bot_token = $token;
    }

    /**
     * @return string
     */
    public function getBotToken()
    {
        return $this->bot_token;
    }

    /**
     * @return string
     */
    public function getFullApiUrl()
    {
        return $this->apiurl . $this->getBotToken();
    }

    /**
     * @param $params
     * @param $type
     * @param $reply_markup
     * @param $parse_mode
     * @return bool|mixed
     */
    public function sendMessage($params, $type = 'message', $reply_markup = '', $parse_mode = 'HTML')
    {
        $link = 'send'.ucfirst($type);
        $arr = [];
        $params['chat_id'] = $this->getChatId();

        switch ($type)
        {
            case "location" :
                if(!$this->checkParams([$params['latitude'], $params['longitude']]))
                {
                    return false;
                }
            break;
            case "contact" :
                //phone_number,first_name,last_name,vcard
                if(!$this->checkParams([$params['phone_number'], $params['first_name']]))
                {
                    return false;
                }

            break;
            case "file" :
                //caption,phone_number,photo,video,audio,animation,sticker,document
                if(!$this->checkParams([$params['fileType'], $params[$params['fileType']]]))
                {
                    return false;
                }
                $params['parse_mode'] = $parse_mode;
                if($reply_markup)
                {
                    $params['reply_markup'] = $reply_markup;
                }
                $link = 'send'.ucfirst($params['fileType']);//photo,video,audio,animation,sticker,document
            break;
            default :
                if(!$this->checkParams([$params['text']]))
                {
                    return false;
                }
                $params['parse_mode'] = $parse_mode;
                if($reply_markup)
                {
                    $params['reply_markup'] = $reply_markup;
                }
            break;
        }

        return $this->sendApiMessage($link, $arr, $params);
    }

    /**
     * @param $url
     * @param $arr
     * @param $params
     * @return mixed|true
     */
    public function sendApiMessage($url, $arr, $params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getFullApiUrl() . '/'.$url); // api address
        curl_setopt($curl, CURLOPT_POST, true); // send data POST
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); // max time
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // parameters
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($result, true);

        if($result['ok'] === false || empty($result))
        {
            return $this->_errHandler($result);
        }

        return true;
    }
}