<?

namespace App\Service;


class BBCode
{
    public static function replyShit($arr)
    {
        $result = [];
        foreach ($arr as $item) {
            $c = self::lex($item["message"]);
            foreach ($c as $k => $t) {
                if ($t["tag"] == "reply") {
                    $result[$t["t"]][] = $item["id"];
                }
            }
        }
        return $result;
    }

    public static function parseBB($str, $postId)
    {
        $result = self::lex($str);
        $generateHTML = function ($arr, $postId) {
            $result = '';
            foreach ($arr as $item) {
                if ($item['tag'] == "img") {
                    $result .= "<img class=\"post_image\" src=" . $item['t'] . ">";
                } else if ($item['tag'] == "b") {
                    $result .= "<b>" . $item['t'] . "</b>";
                } else if ($item["tag"] == "reply") {
                    $result .= '<span id="' . $item['t'] . '" pid="' . $postId . '" class="reply">>>' . $item['t'] . '</span>';
                } else {
                    $result .= $item['t'];
                }
            }
            return str_replace("\n", "<br>", $result);
        };
        return $generateHTML($result, $postId);
    }

    private static function lex($str)
    {
        $result = [];
        $startAttr = false;
        $isOpen = false;
        $t = '';
        $tTag = '';
        for ($i = 0; $i <= strlen($str) - 1; $i++) {
            if ($str[$i] == "<") {
                $startAttr = true;
                $isOpen = true;
                if ($str[$i + 1] == "/") {
                    $isOpen = false;
                }
                if (!empty($t)) {
                    $result[] = ["t" => $t, "tag" => $tTag];
                }
                $t = '';
                $tTag = '';
                continue;
            }
            if ($str[$i] == ">") {
                $startAttr = false;
                continue;
            }
            if ($startAttr && $isOpen) {
                $tTag .= $str[$i];
            } else if (!$startAttr) {
                $t .= $str[$i];
            }
        }
        if (!empty($t)) {
            $result[] = ["t" => $t, "tag" => $tTag];
        }
        return $result;
    }

}
