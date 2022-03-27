<?

namespace App\Service;


class BBcode
{
    public static function parseBB($str)
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
        $generateHTML = function ($arr) {
            $result = '';
            foreach ($arr as $item) {
                if ($item['tag'] == "img") {
                    $result .= "<img class=\"post_image\" src=" . $item['t'] . ">";
                } else if ($item['tag'] == "b") {
                    $result .= "<b>" . $item['t'] . "</b>";
                } else if ($item["tag"] == "reply") {
                    $result .= '<span id="' . $item['t'] . '" class="reply">>>' . $item['t'] . '</span>';
                } else {
                    $result .= $item['t'];
                }
            }
            return str_replace("\n", "<br>", $result);
        };
        return $generateHTML($result);
    }
}
