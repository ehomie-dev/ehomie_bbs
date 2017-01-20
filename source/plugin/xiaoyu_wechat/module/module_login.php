<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    xiaoyu_xss_check();
}
$echoStr = $_GET["echostr"];
if (checkSignature()) {
    if ($echoStr) {
        echo $echoStr;
        exit;
    } else {
        responseMsg();
    }
}
function checkSignature() {
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
    $token = FISH_TOKEN;
    $tmpArr = array(
        $token,
        $timestamp,
        $nonce
    );
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode($tmpArr);
    $tmpStr = sha1($tmpStr);
    if ($tmpStr == $signature) {
        return true;
    } else {
        return false;
    }
}
function responseMsg() {
    $postdata = file_get_contents("php://input");
    if ($postdata) {
        $postObj = simplexml_load_string($postdata, 'SimpleXMLElement', LIBXML_NOCDATA);
        $postObj = xiaoyu_handlePostObj($postObj);
        if (isset($postObj['event'])) {
            switch ($postObj['event']) {
                case 'subscribe':
                    if (!empty($postObj['key'])) {
                        if (!empty($postObj['key'])) {
                            loginusername($postObj);
                        }
                    } else {
                        subscribe($postObj);
                    }
                    break;

                case 'scan':
                    if (!empty($postObj['key'])) {
                        loginusername($postObj);
                    }
                    break;
            }
        } else {
            switch ($postObj['type']) {
                case 'text':
				$result = $this->receiveText($postObj['content']);
                    break;

                case 'location':
				$result = $this->receiveText($postObj['content']);
                    break;

                case 'image':
				$result = $this->receiveText($postObj['content']);
                    break;

                case 'video':
				$result = $this->receiveText($postObj['content']);
                    break;

                case 'link':
				$result = $this->receiveText($postObj['content']);
                    break;

                case 'voice':
				$result = $this->receiveText($postObj['content']);
                    break;
            }
        }
    }
}
function xiaoyu_handlePostObj($postObj) {
    $MsgType = strtolower((string)$postObj->MsgType);
    $result = array(
        'from' => (string)htmlspecialchars($postObj->FromUserName) ,
        'to' => (string)htmlspecialchars($postObj->ToUserName) ,
        'time' => (int)$postObj->CreateTime,
        'type' => (string)$MsgType
    );
    if (property_exists($postObj, 'MsgId')) {
        $result['id'] = $postObj->MsgId;
    }
    switch ($result['type']) {
        case 'text':
            $result['content'] = (string)$postObj->Content;
            break;

        case 'location':
            $result['X'] = (float)$postObj->Location_X;
            $result['Y'] = (float)$postObj->Location_Y;
            $result['S'] = (float)$postObj->Scale;
            $result['I'] = (string)$postObj->Label;
            break;

        case 'image':
            $result['url'] = (string)$postObj->PicUrl;
            $result['mid'] = (string)$postObj->MediaId;
            break;

        case 'video':
            $result['mid'] = (string)$postObj->MediaId;
            $result['thumbmid'] = (string)$postObj->ThumbMediaId;
            break;

        case 'link':
            $result['title'] = (string)$postObj->Title;
            $result['desc'] = (string)$postObj->Description;
            $result['url'] = (string)$postObj->Url;
            break;

        case 'voice':
            $result['mid'] = (string)$postObj->MediaId;
            $result['format'] = (string)$postObj->Format;
            if (property_exists($postObj, Recognition)) {
                $result['txt'] = (string)$postObj->Recognition;
            }
            break;

        case 'event':
            $result['event'] = strtolower((string)$postObj->Event);
            switch ($result['event']) {
                case 'subscribe':
                case 'scan':
                    if (property_exists($postObj, EventKey)) {
                        $result['key'] = str_replace('qrscene_', '', (string)$postObj->EventKey);
                        $result['ticket'] = (string)$postObj->Ticket;
                    }
                    break;

                case 'location':
                    $result['la'] = (string)$postObj->Latitude;
                    $result['lo'] = (string)$postObj->Longitude;
                    $result['p'] = (string)$postObj->Precision;
                    break;

                case 'click':
                    $result['key'] = (string)$postObj->EventKey;
                    break;

                case 'masssendjobfinish':
                    $result['msg_id'] = (string)$postObj->MsgID;
                    $result['status'] = (string)$postObj->Status;
                    $result['totalcount'] = (string)$postObj->TotalCount;
                    $result['filtercount'] = (string)$postObj->FilterCount;
                    $result['sentcount'] = (string)$postObj->SentCount;
                    $result['errorcount'] = (string)$postObj->ErrorCount;
            }
    }
    return $result;
}
/*message*/
function receiveText($postObj) {
    $template = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>';
    $fromUserName = $postObj['from'];
    $toUserName = $postObj['to'];
    $time = TIMESTAMP;
    $type = 'text';
    $content = $postObj['content'];
    $return = sprintf($template, $fromUserName, $toUserName, $time, $type, $content);
    $return = diconv($return, CHARSET, 'UTF-8');
    echo $return;
    exit();
}
function receiveImage($postObj) {
}
function receiveVoice($postObj) {
}
function receiveVideo($postObj) {
}
function receiveMusic($postObj) {
}
function receiveNews($postObj) {
}
/*event*/

function loginusername($postObj) {
    $enteruser = C::t('#xiaoyu_wechat#xiaoyu_wechat_user')->fetch($postObj['from']);
    if (!empty($enteruser) && !empty($enteruser['uid'])) {
	
	     		require libfile('function/member');
     			$uidinfo = getuserbyuid($enteruser['uid']);
				if($enteruser['uid'] != $uidinfo['uid']) {
					C::t('#xiaoyu_wechat#xiaoyu_wechat_user')->delete_by_uid($enteruser['uid']); }
					
        C::t('#xiaoyu_wechat#xiaoyu_wechat_scan')->update($postObj['key'], array(
            'status' => 1,
            'uid' => $enteruser['uid']
        ));
    } else {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . FISH_ACCESS_TOKEN . '&openid=' . $postObj['from'];
        $res = dfsockopen($url);
        $rearr2 = json_decode($res, true);
        $rearr2 = mult_iconv('UTF-8', CHARSET, $rearr2);
        if (empty($enteruser)) {
            $uid = register_user($rearr2);
            if ($uid <= 0) {
                if ($uid == - 1) {
                    $showmsg = lang('message', 'profile_username_illegal');
                } elseif ($uid == - 2) {
                    $showmsg = lang('message', 'profile_username_protect');
                } elseif ($uid == - 3) {
                    $showmsg = lang('message', 'profile_username_duplicate');
                } elseif ($uid == - 4) {
                    $showmsg = lang('message', 'profile_email_illegal');
                } elseif ($uid == - 5) {
                    $showmsg = lang('message', 'profile_email_domain_illegal');
                } elseif ($uid == - 6) {
                    $showmsg = lang('message', 'profile_email_duplicate');
                } else {
                    $showmsg = lang('message', 'undefined_action');
                }
                $postObj['content'] = $showmsg;
                receiveText($postObj);
            }
            $setarr = array(
                'openid' => $rearr2['openid'],
                'nickname' => $rearr2['nickname'],
                'city' => $rearr2['city'],
                'province' => $rearr2['province'],
                'country' => $rearr2['country'],
                'headimgurl' => $rearr2['headimgurl'],
                'uid' => $uid,
            );
            C::t('#xiaoyu_wechat#xiaoyu_wechat_user')->insert($setarr);
            C::t('#xiaoyu_wechat#xiaoyu_wechat_scan')->update($postObj['key'], array(
                'status' => 1,
                'uid' => $uid
            ));
        }
    }
   $postObj['content'] = lang('plugin/xiaoyu_wechat', 'login_success');
    receiveText($postObj);
}

