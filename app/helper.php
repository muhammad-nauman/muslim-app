<?php

use Illuminate\Support\Facades\Storage;
use wapmorgan\MediaFile\MediaFile;
use wapmorgan\Mp3Info\Mp3Info;
use Illuminate\Support\Str;

if(! function_exists('get_audio_duration')) {
    function get_audio_duration(string $path): string
    {
        if(Str::endsWith($path,
        'wav')) {
            $audio = MediaFile::open($path)->getAudio();
            $duration = $audio->getLength();
        } else {
            $audio = new Mp3Info($path);
            $duration = $audio->duration;
        }

        $audioMins = floor($duration / 60);
        $audioSeconds = floor($duration % 60);

        $audioMins = $audioMins > 9 ? $audioMins : '0' . $audioMins;
        $audioSeconds = $audioSeconds > 9 ? $audioSeconds : '0' . $audioSeconds;

        return $audioMins . ':' . $audioSeconds;
    }
}

if(! function_exists('get_file_with_storage_driver_path')) {
    function get_storage_driver_path(string $path): string
    {
        return Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() .'/' . $path;
    }
}

function replace_special_alphabets($string)
{
    $replaceableAlphabets = [
        'á' => 'a',
        'Á' => 'A',
        'à' => 'a',
        'À' => 'A',
        'ă' => 'a',
        'Ă' => 'A',
        'â' => 'a',
        'Â' => 'A',
        'å' => 'a',
        'Å' => 'A',
        'ã' => 'a',
        'Ã' => 'A',
        'ą' => 'a',
        'Ą' => 'A',
        'ā' => 'a',
        'Ā' => 'A',
        'ä' => 'ae',
        'Ä' => 'AE',
        'æ' => 'ae',
        'Æ' => 'AE',
        'ḃ' => 'b',
        'Ḃ' => 'B',
        'ć' => 'c',
        'Ć' => 'C',
        'ĉ' => 'c',
        'Ĉ' => 'C',
        'č' => 'c',
        'Č' => 'C',
        'ċ' => 'c',
        'Ċ' => 'C',
        'ç' => 'c',
        'Ç' => 'C',
        'ď' => 'd',
        'Ď' => 'D',
        'ḋ' => 'd',
        'Ḋ' => 'D',
        'đ' => 'd',
        'Đ' => 'D',
        'ð' => 'dh',
        'Ð' => 'Dh',
        'é' => 'e',
        'É' => 'E',
        'è' => 'e',
        'È' => 'E',
        'ĕ' => 'e',
        'Ĕ' => 'E',
        'ê' => 'e',
        'Ê' => 'E',
        'ě' => 'e',
        'Ě' => 'E',
        'ë' => 'e',
        'Ë' => 'E',
        'ė' => 'e',
        'Ė' => 'E',
        'ę' => 'e',
        'Ę' => 'E',
        'ē' => 'e',
        'Ē' => 'E',
        'ḟ' => 'f',
        'Ḟ' => 'F',
        'ƒ' => 'f',
        'Ƒ' => 'F',
        'ğ' => 'g',
        'Ğ' => 'G',
        'ĝ' => 'g',
        'Ĝ' => 'G',
        'ġ' => 'g',
        'Ġ' => 'G',
        'ģ' => 'g',
        'Ģ' => 'G',
        'ĥ' => 'h',
        'Ĥ' => 'H',
        'ħ' => 'h',
        'Ħ' => 'H',
        'í' => 'i',
        'Í' => 'I',
        'ì' => 'i',
        'Ì' => 'I',
        'î' => 'i',
        'Î' => 'I',
        'ï' => 'i',
        'Ï' => 'I',
        'ĩ' => 'i',
        'Ĩ' => 'I',
        'į' => 'i',
        'Į' => 'I',
        'ī' => 'i',
        'Ī' => 'I',
        'ĵ' => 'j',
        'Ĵ' => 'J',
        'ķ' => 'k',
        'Ķ' => 'K',
        'ĺ' => 'l',
        'Ĺ' => 'L',
        'ľ' => 'l',
        'Ľ' => 'L',
        'ļ' => 'l',
        'Ļ' => 'L',
        'ł' => 'l',
        'Ł' => 'L',
        'ṁ' => 'm',
        'Ṁ' => 'M',
        'ń' => 'n',
        'Ń' => 'N',
        'ň' => 'n',
        'Ň' => 'N',
        'ñ' => 'n',
        'Ñ' => 'N',
        'ņ' => 'n',
        'Ņ' => 'N',
        'ó' => 'o',
        'Ó' => 'O',
        'ò' => 'o',
        'Ò' => 'O',
        'ô' => 'o',
        'Ô' => 'O',
        'ő' => 'o',
        'Ő' => 'O',
        'õ' => 'o',
        'Õ' => 'O',
        'ø' => 'oe',
        'Ø' => 'OE',
        'ō' => 'o',
        'Ō' => 'O',
        'ơ' => 'o',
        'Ơ' => 'O',
        'ö' => 'oe',
        'Ö' => 'OE',
        'ṗ' => 'p',
        'Ṗ' => 'P',
        'ŕ' => 'r',
        'Ŕ' => 'R',
        'ř' => 'r',
        'Ř' => 'R',
        'ŗ' => 'r',
        'Ŗ' => 'R',
        'ś' => 's',
        'Ś' => 'S',
        'ŝ' => 's',
        'Ŝ' => 'S',
        'š' => 's',
        'Š' => 'S',
        'ṡ' => 's',
        'Ṡ' => 'S',
        'ş' => 's',
        'Ş' => 'S',
        'ș' => 's',
        'Ș' => 'S',
        'ß' => 'SS',
        'ť' => 't',
        'Ť' => 'T',
        'ṫ' => 't',
        'Ṫ' => 'T',
        'ţ' => 't',
        'Ţ' => 'T',
        'ț' => 't',
        'Ț' => 'T',
        'ŧ' => 't',
        'Ŧ' => 'T',
        'ú' => 'u',
        'Ú' => 'U',
        'ù' => 'u',
        'Ù' => 'U',
        'ŭ' => 'u',
        'Ŭ' => 'U',
        'û' => 'u',
        'Û' => 'U',
        'ů' => 'u',
        'Ů' => 'U',
        'ű' => 'u',
        'Ű' => 'U',
        'ũ' => 'u',
        'Ũ' => 'U',
        'ų' => 'u',
        'Ų' => 'U',
        'ū' => 'u',
        'Ū' => 'U',
        'ư' => 'u',
        'Ư' => 'U',
        'ü' => 'ue',
        'Ü' => 'UE',
        'ẃ' => 'w',
        'Ẃ' => 'W',
        'ẁ' => 'w',
        'Ẁ' => 'W',
        'ŵ' => 'w',
        'Ŵ' => 'W',
        'ẅ' => 'w',
        'Ẅ' => 'W',
        'ý' => 'y',
        'Ý' => 'Y',
        'ỳ' => 'y',
        'Ỳ' => 'Y',
        'ŷ' => 'y',
        'Ŷ' => 'Y',
        'ÿ' => 'y',
        'Ÿ' => 'Y',
        'ź' => 'z',
        'Ź' => 'Z',
        'ž' => 'z',
        'Ž' => 'Z',
        'ż' => 'z',
        'Ż' => 'Z',
        'þ' => 'th',
        'Þ' => 'Th',
        'µ' => 'u',
        'а' => 'a',
        'А' => 'a',
        'б' => 'b',
        'Б' => 'b',
        'в' => 'v',
        'В' => 'v',
        'г' => 'g',
        'Г' => 'g',
        'д' => 'd',
        'Д' => 'd',
        'е' => 'e',
        'Е' => 'E',
        'ё' => 'e',
        'Ё' => 'E',
        'ж' => 'zh',
        'Ж' => 'zh',
        'з' => 'z',
        'З' => 'z',
        'и' => 'i',
        'И' => 'i',
        'й' => 'j',
        'Й' => 'j',
        'к' => 'k',
        'К' => 'k',
        'л' => 'l',
        'Л' => 'l',
        'м' => 'm',
        'М' => 'm',
        'н' => 'n',
        'Н' => 'n',
        'о' => 'o',
        'О' => 'o',
        'п' => 'p',
        'П' => 'p',
        'р' => 'r',
        'Р' => 'r',
        'с' => 's',
        'С' => 's',
        'т' => 't',
        'Т' => 't',
        'у' => 'u',
        'У' => 'u',
        'ф' => 'f',
        'Ф' => 'f',
        'х' => 'h',
        'Х' => 'h',
        'ц' => 'c',
        'Ц' => 'c',
        'ч' => 'ch',
        'Ч' => 'ch',
        'ш' => 'sh',
        'Ш' => 'sh',
        'щ' => 'sch',
        'Щ' => 'sch',
        'ъ' => '',
        'Ъ' => '',
        'ы' => 'y',
        'Ы' => 'y',
        'ь' => '',
        'Ь' => '',
        'э' => 'e',
        'Э' => 'e',
        'ю' => 'ju',
        'Ю' => 'ju',
        'я' => 'ja',
        'Я' => 'ja'
    ];
    return str_replace(
        array_keys(
            $replaceableAlphabets
        ),
        array_values($replaceableAlphabets),
        $string);
}

function getData()
{
    return array(
        array('type' => 'movie','title' => 'Tawheeds Dygder (7 min)','created_at' => '2015-08-30 18:46:45','updated_at' => '2015-11-25 19:10:02','publishing_timestamp' => '2015-08-30 18:46:45','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "audio\\/paminnelser\\/150901%20-%20Tawheeds%20dygder.mp3",
			"width": "auto",
			"height": "auto",
			"autoplay": "0",
			"image": "",
			"title": "Tawheeds Dygder"
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/150901%20-%20Tawheeds%20dygder.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-09-01 00:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": "<p>&nbsp;<\\/p>\\r\\n<p>Ett otroligt fint tal om det viktigaste som finns i v&aring;ra liv. Islams grund och alla profeternas kall.&nbsp;<\\/p>"
		}
	}
}'),
        array('type' => 'movie','title' => 'Tappa inte hoppet (9 min)','created_at' => '2015-09-09 22:36:09','updated_at' => '2015-11-25 19:09:20','publishing_timestamp' => '2015-09-09 22:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/150904%20-%20Tappa%20inte%20hoppet.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-09-04 00:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:50"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => '5 villkor för att synda (6 min)','created_at' => '2015-09-09 22:36:09','updated_at' => '2015-11-25 19:09:04','publishing_timestamp' => '2015-09-09 22:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/150908%20-%205%20villkor%20f\\u00f6r%20att%20synda.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-09-08 00:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:22"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {
		"item":  {
			"0": "4"
		}
	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        [
            'type' => 'movie',
            'title' => '10 första dagarna i Dhul Hijjah (10 min)',
            'created_at' => '2015-09-14 20:00:43',
            'updated_at' => '2015-11-25 19:09:40',
            'publishing_timestamp' => '2015-09-14 20:00:43',
            'expiring_timestamp' => '0000-00-00 00:00:00',
            'elements' => ' {
                    "f9f1824e-fe94-4b81-9301-8b61f314a161":  {
                        "0":  {
                            "file": "audio\\/paminnelser\\/150914%20-%20Dhul%20hijjah.mp3",
                            "width": "auto",
                            "height": "auto",
                            "autoplay": "0",
                            "image": "",
                            "title": "Tawheeds Dygder"
                        }
                    },
                    "90eee517-9c10-4297-a0d8-72c84ae74d22":  {
                        "url": "audio\\/paminnelser\\/150914%20-%20Dhul%20hijjah.mp3",
                        "width": "",
                        "height": "",
                        "autoplay": "0"
                    },
                    "8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
                        "0":  {
                            "value": "2015-09-14 00:00:00"
                        }
                    },
                    "69057819-0f6e-46ba-a16f-580328c3bfe4":  {
                        "0":  {
                            "value": "10:26"
                        }
                    },
                    "3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
                        "item":  {
                            "0": "2"
                        }
                    },
                    "2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
                        "0":  {
                            "value": "",
                            "text": "",
                            "target": "0",
                            "custom_title": "",
                            "rel": ""
                        }
                    },
                    "f8cadbf4-23f0-479f-929f-15801b7a8442":  {

                    },
                    "fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
                        "0":  {
                            "value": ""
                        }
                    }
                }'
        ],
        array('type' => 'movie','title' => 'Fast på religionen (3 min)','created_at' => '2015-09-09 22:36:09','updated_at' => '2015-11-01 14:09:23','publishing_timestamp' => '2015-09-09 22:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/150911%20-%20Fast%20p\\u00e5%20religionen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-09-11 00:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "2:43"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "http:\\/\\/islam.nu",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": "<p>&nbsp;<\\/p>\\r\\n<p>Lyssna p&aring; hela f&ouml;rel&auml;sningen h&auml;r: <a href=\\"http:\\/\\/www.islam.nu\\/om-islam\\/allmaent\\/28-vad-skall-jag-goera-foer-att-bli-en-starkare-muslim\\">Islam.nu<\\/a><\\/p>"
		}
	}
}'),
        array('type' => 'movie','title' => 'Så följer man Profeten (sallâ Allâhu \'alayhi wa sallam) (6 min)','created_at' => '2015-09-17 22:36:09','updated_at' => '2015-10-01 14:16:12','publishing_timestamp' => '2015-09-17 22:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/150918%20-%20S\\u00e5%20lyder%20man%20profeten.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-09-17 00:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:21"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": "<p>&nbsp;<\\/p>\\r\\n<p>Lyssna p&aring; hela f&ouml;rel&auml;sningen h&auml;r: <a href=\\"http:\\/\\/ahlussunnah.se\\/rad-och-avhallsamhet\\/item\\/sa-lyder-man-profeten-sallalahu-alayhi-wa-sallam-gislaved\\">Ahlussunnah.se<\\/a><\\/p>"
		}
	}
}'),
        array('type' => 'movie','title' => 'Dygderna av La ilaha illa Allah (7 min)','created_at' => '2015-09-25 20:00:43','updated_at' => '2015-11-25 19:08:38','publishing_timestamp' => '2015-09-25 20:00:43','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "audio\\/paminnelser\\/150926-%20Dygderna%20av%20La%20ilaha%20illa%20Allah.mp3",
			"width": "auto",
			"height": "auto",
			"autoplay": "0",
			"image": "",
			"title": "Tawheeds Dygder"
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/150926-%20Dygderna%20av%20La%20ilaha%20illa%20Allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-09-25 00:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:54"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {
		"item":  {
			"0": "1"
		}
	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Eid al Adha (8 min)','created_at' => '2015-09-23 10:36:09','updated_at' => '2015-10-01 14:15:57','publishing_timestamp' => '2015-09-23 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/150923%20-%20Eid%20ul%20Adha.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-09-23 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:05"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Inbrottstjuven & Imamen (6 min)','created_at' => '2015-09-29 10:36:09','updated_at' => '2015-10-01 14:23:46','publishing_timestamp' => '2015-09-29 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/150930%20-%20Inbrottstjuven%20och%20imamen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-09-29 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:20"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {
		"item":  {
			"0": "5",
			"1": "4"
		}
	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'En vacker hadith om kunskapens dygder (7 min)','created_at' => '2015-10-02 20:00:43','updated_at' => '2015-10-03 14:37:53','publishing_timestamp' => '2015-10-02 20:00:43','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "audio\\/paminnelser\\/151003%20-%20Kunskapens%20dygder.mp3",
			"width": "auto",
			"height": "auto",
			"autoplay": "0",
			"image": "",
			"title": "Tawheeds Dygder"
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151003%20-%20Kunskapens%20dygder.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-10-02 00:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:55"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {
		"item":  {
			"0": "1"
		}
	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Varför lever du? (6 min)','created_at' => '2015-10-06 10:36:09','updated_at' => '2015-10-06 20:14:30','publishing_timestamp' => '2015-10-06 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151007%20-%20Varfor%20lever%20du.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-10-06 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:20"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Meningen med din existens (9 min)','created_at' => '2015-10-08 22:36:09','updated_at' => '2015-10-09 22:32:50','publishing_timestamp' => '2015-10-08 22:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151010%20-%20Meningen%20med%20din%20existens.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-10-09 00:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:04"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {
		"item":  {
			"0": "1"
		}
	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Helgade månaden al-Muharram (7 min)','created_at' => '2015-10-13 10:36:09','updated_at' => '2015-10-14 13:19:59','publishing_timestamp' => '2015-10-13 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151014%20-%20al-Muharram.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-10-13 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:36"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Baktal (9 min)','created_at' => '2015-10-16 10:36:09','updated_at' => '2015-10-17 12:07:56','publishing_timestamp' => '2015-10-16 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151017%20-%20Baktal.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-10-16 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:04"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Dina val & hur de påverkar dig (6 min) ','created_at' => '2015-10-21 10:36:09','updated_at' => '2015-10-21 14:29:30','publishing_timestamp' => '2015-10-21 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151021%20-%20Dina%20val.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-10-21 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:45"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Den sista medlingen (5 min)','created_at' => '2015-10-24 10:36:09','updated_at' => '2015-11-15 13:16:55','publishing_timestamp' => '2015-10-24 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151024%20-%20Medlingen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-10-24 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:21"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Shirk - den värsta synden (9 min)','created_at' => '2015-10-28 20:00:43','updated_at' => '2015-10-28 20:54:12','publishing_timestamp' => '2015-10-28 20:00:43','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "audio\\/paminnelser\\/151028%20-%20Shirk.mp3",
			"width": "auto",
			"height": "auto",
			"autoplay": "0",
			"image": "",
			"title": "Tawheeds Dygder"
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151028%20-%20Shirk.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-10-28 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:27"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {
		"item":  {
			"0": "1",
			"1": "11"
		}
	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Glimtar från Sahabas liv - Stadfasthet  (6 min)','created_at' => '2015-10-31 12:36:09','updated_at' => '2015-10-31 16:28:10','publishing_timestamp' => '2015-10-31 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151031%20-%20AW%20-%20Abu%20bakr.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-10-31 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:34"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "http:\\/\\/islam.nu",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Högmod (5 min)','created_at' => '2015-11-04 10:36:09','updated_at' => '2015-11-04 20:10:00','publishing_timestamp' => '2015-11-04 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151104%20-%20Hogmod.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-11-02 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:09"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Glimtar från Sahabas liv - Sunnah (7 min)','created_at' => '2015-11-07 10:36:09','updated_at' => '2015-11-07 12:18:43','publishing_timestamp' => '2015-11-07 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151107%20-%20Abdullah%20-%20Sunnah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-11-07 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:58"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "http:\\/\\/islam.nu",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vikten av att lära sig arabiska (6 min)','created_at' => '2015-11-11 10:36:09','updated_at' => '2015-11-11 16:10:50','publishing_timestamp' => '2015-11-11 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151111%20-%20Arabiska.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-11-11 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:27"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Terrorattackerna i Paris (7 min)','created_at' => '2015-11-14 12:36:09','updated_at' => '2015-11-25 19:10:26','publishing_timestamp' => '2015-11-14 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151114%20-%20Paris.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-11-14 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:21"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Den mindre formen av shirks fara (8 min)','created_at' => '2015-11-18 10:36:09','updated_at' => '2015-11-18 17:26:54','publishing_timestamp' => '2015-11-18 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151118%20-%20Mindre%20shirk.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-11-18 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:35"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vikten av äktenskap (6 min)','created_at' => '2015-11-21 10:36:09','updated_at' => '2015-11-22 11:03:03','publishing_timestamp' => '2015-11-21 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151121%20-%20Aktenskap.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-11-21 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:53"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Glimtar från Sahabas liv - Bönen (8 min)','created_at' => '2015-11-25 12:36:09','updated_at' => '2015-11-25 18:58:40','publishing_timestamp' => '2015-11-25 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151125%20-%20AW-bonen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-11-25 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:47"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur går ett äktenskap till i Islam? (10 min) ','created_at' => '2015-11-28 10:36:09','updated_at' => '2015-11-28 14:06:06','publishing_timestamp' => '2015-11-28 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151128%20-%20aktenskap%20tillvagagansatt.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-11-28 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:59"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Betydelsen av namnet Allah (8 min)','created_at' => '2016-01-17 10:36:09','updated_at' => '2016-01-17 12:28:27','publishing_timestamp' => '2016-01-17 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160117%20-%20Namnet%20Allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-17 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:59"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Sunnan är som Noas ark (8 min)','created_at' => '2015-12-02 10:36:09','updated_at' => '2015-12-09 16:43:30','publishing_timestamp' => '2015-12-02 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151202%20-%20noas%20ark.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-12-02 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:40"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Makans rättigheter - Del 1 (7 min)','created_at' => '2015-12-05 10:36:09','updated_at' => '2015-12-09 17:02:37','publishing_timestamp' => '2015-12-05 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151205%20-%20Makans%20rattigheter.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-12-05 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:22"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Makans rättigheter - Del 2 (10 min)','created_at' => '2015-12-09 10:36:09','updated_at' => '2015-12-09 17:02:21','publishing_timestamp' => '2015-12-09 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151209%20-%20Makan%20del%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-12-09 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:36"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Faran med innovationer (9 min)','created_at' => '2015-12-12 10:36:09','updated_at' => '2015-12-12 13:11:30','publishing_timestamp' => '2015-12-12 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151202%20-%20noas%20ark.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-12-12 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:23"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Makens rättigheter - Del 1 (9 min)','created_at' => '2015-12-16 10:36:09','updated_at' => '2015-12-16 20:32:08','publishing_timestamp' => '2015-12-16 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151216%20-%20Makens%20rattigheter%20-%20del%201.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-12-16 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:08"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad är Islam?  (12 min)','created_at' => '2015-12-19 12:36:09','updated_at' => '2015-12-19 19:05:00','publishing_timestamp' => '2015-12-19 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151219%20-%20Vad%20ar%20islam.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-12-19 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:55"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Jesus - Guds tjänare & Sändebud (11 min)','created_at' => '2015-12-24 10:36:09','updated_at' => '2015-12-24 15:03:37','publishing_timestamp' => '2015-12-24 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151224%20-%20jesus.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-12-24 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:34"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Makens rättigheter - Del 2 (12 min)','created_at' => '2015-12-27 10:36:09','updated_at' => '2015-12-27 16:47:52','publishing_timestamp' => '2015-12-27 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151227%20-%20Makens%20rattigheter%20-%20del%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-12-27 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:02"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vikten av att lära sig om Allahs namn & attribut (8 min)','created_at' => '2015-12-30 10:36:09','updated_at' => '2016-01-06 17:00:13','publishing_timestamp' => '2015-12-30 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/151231%20-%20Allahs%20namn.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2015-12-31 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:04"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vägarna till kriminalitet (12 min)','created_at' => '2016-01-03 10:36:09','updated_at' => '2016-01-09 18:56:26','publishing_timestamp' => '2016-01-03 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160103%20-%20kriminell.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-03 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:10"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur ska vi tro på Allahs namn & attribut (10 min)','created_at' => '2016-01-06 10:36:09','updated_at' => '2016-01-09 18:56:57','publishing_timestamp' => '2016-01-06 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160106%20-%20Allahs%20namn%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-06 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:28"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Att ständigt minnas Allah (6 min)','created_at' => '2016-01-09 10:36:09','updated_at' => '2016-01-09 19:03:16','publishing_timestamp' => '2016-01-09 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160109%20-%20minnas%20allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-09 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:14"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett kliv mot ett nytt liv - Del 1 (10 min)','created_at' => '2016-01-14 10:36:09','updated_at' => '2016-01-14 18:14:32','publishing_timestamp' => '2016-01-14 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160114%20-%20kliv%20mot%20nytt%20liv%201.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-14 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "09:49"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett kliv mot ett nytt liv - Koranen (14 min)','created_at' => '2016-01-21 10:36:09','updated_at' => '2016-01-21 16:08:06','publishing_timestamp' => '2016-01-21 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160121%20-%20kliv%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-21 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "13:47"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Betydelsen av namnet ar-Rabb (6 min)','created_at' => '2016-01-24 10:36:09','updated_at' => '2016-01-24 14:07:52','publishing_timestamp' => '2016-01-24 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160124%20-%20arrabb.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-24 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:19"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Luras inte av dig själv (7 min)','created_at' => '2016-01-28 10:36:09','updated_at' => '2016-01-28 17:34:35','publishing_timestamp' => '2016-01-28 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160127%20-%20Lura%20inte.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-28 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:21"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Var förlåtande (8 min)','created_at' => '2016-01-31 10:36:09','updated_at' => '2016-01-31 18:47:59','publishing_timestamp' => '2016-01-31 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160131%20-%20va%20forlatande.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-31 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:40"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett kliv mot ett nytt liv - Del 3 (11 min)','created_at' => '2016-02-03 10:36:09','updated_at' => '2016-02-14 17:14:55','publishing_timestamp' => '2016-02-03 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160203%20-%20Kliv%20del%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-01-31 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:51"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Betydelsen av namnen ar-Rahman ar-Rahim (9 min)','created_at' => '2016-02-07 10:36:09','updated_at' => '2016-02-14 17:15:15','publishing_timestamp' => '2016-02-07 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160207%20-%20arrahman%20arrahim.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-02-04 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:15"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Känn dig inte säker från Allahs straff (12 min)','created_at' => '2016-02-14 10:36:09','updated_at' => '2016-02-14 17:15:28','publishing_timestamp' => '2016-02-14 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160214%20-%20ej%20saker%20fran%20allahs%20straff.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-02-14 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:51"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett kliv mot ett nytt liv - Del 4 (7 min)','created_at' => '2016-02-17 10:36:09','updated_at' => '2016-02-17 17:43:39','publishing_timestamp' => '2016-02-17 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160217%20-%20kliv%20del%204.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-02-17 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:38"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Betydelsen av namnen al-Hayy al-Qayyum (6 min)','created_at' => '2016-02-21 10:36:09','updated_at' => '2016-02-21 17:34:00','publishing_timestamp' => '2016-02-21 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160221%20-%20alhayy.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-02-21 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:14"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Livet i graven (6 min)','created_at' => '2016-02-24 10:36:09','updated_at' => '2016-02-24 17:56:09','publishing_timestamp' => '2016-02-24 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160224%20-%20livet%20o%20graven.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-02-24 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:14"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett kliv mot ett nytt liv - Synd & Olydnad - Del 5 (13 min) ','created_at' => '2016-02-28 10:36:09','updated_at' => '2016-02-28 16:29:43','publishing_timestamp' => '2016-02-28 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160228%20-%20kliv%205.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-02-28 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:39"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Betydelsen av namnet ar-Razzaq (8 min)','created_at' => '2016-03-02 10:36:09','updated_at' => '2016-04-09 17:03:37','publishing_timestamp' => '2016-03-02 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160302%20-%20arrazzaq.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-03-02 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:30"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Uppriktighet till Allah (10 min)','created_at' => '2016-03-08 10:36:09','updated_at' => '2016-04-09 17:03:24','publishing_timestamp' => '2016-03-08 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160307%20-%20domedagen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-03-08 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:49"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett kliv mot ett nytt liv - Alkohol - Del 6 (10 min)','created_at' => '2016-03-12 10:36:09','updated_at' => '2016-04-09 17:03:09','publishing_timestamp' => '2016-03-12 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160312%20-%20kliv%206%20-%20alkohol.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-03-12 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:30"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett kliv mot ett nytt liv - Självmord - Del 7 (8 min)','created_at' => '2016-03-18 10:36:09','updated_at' => '2016-04-09 17:02:53','publishing_timestamp' => '2016-03-18 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160318%20-%20sjalvmord.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-03-18 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:11"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Betydelsen av namnet as-Sami\' (9 min)','created_at' => '2016-03-24 10:36:09','updated_at' => '2016-04-09 17:02:32','publishing_timestamp' => '2016-03-24 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160324%20-%20as-sami.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-03-24 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:47"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vi och Koranen (8 min)','created_at' => '2016-03-30 10:36:09','updated_at' => '2016-04-09 17:02:17','publishing_timestamp' => '2016-03-30 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160330%20-%20vi%20och%20koranen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-03-20 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:17"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett kliv mot ett nytt liv - Att våga förändras - Del 8 (10 min)','created_at' => '2016-04-03 02:36:09','updated_at' => '2016-04-09 17:01:59','publishing_timestamp' => '2016-04-03 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160403%20-%20vaga%20forandras.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-04-03 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:02"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vägen till ånger (9 min)','created_at' => '2016-04-06 12:36:09','updated_at' => '2016-04-09 17:01:43','publishing_timestamp' => '2016-04-06 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160406%20-%20vagen%20till%20anger.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-04-06 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:25"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Betydelsen av namnet al-Basir (5 min)','created_at' => '2016-04-09 10:36:09','updated_at' => '2016-04-09 16:55:13','publishing_timestamp' => '2016-04-09 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160409%20-%20albaseer.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-04-09 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:26"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vägen till förlåtelse - Del 2 (11 min)','created_at' => '2016-04-13 12:36:09','updated_at' => '2016-04-13 13:53:48','publishing_timestamp' => '2016-04-13 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160413%20-%20vagen%20till%20anger%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-04-13 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:00"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Betydelsen av namnet al-\'Alîm (8 min)','created_at' => '2016-04-17 10:36:09','updated_at' => '2016-04-17 12:02:24','publishing_timestamp' => '2016-04-17 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160417%20-%20al%20alim.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-04-17 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:50"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett kliv mot ett nytt liv - Muslim i Sverige 2016 - Del 9 (17 min)','created_at' => '2016-04-20 02:36:09','updated_at' => '2016-04-20 16:21:46','publishing_timestamp' => '2016-04-20 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160420%20-%20ta%20inte%20latt%20pa%20dessa.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-04-20 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "16:59"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Betydelsen av namnen al-\'Afuww & al-Ghafûr (7 min)','created_at' => '2016-04-24 10:36:09','updated_at' => '2016-04-24 18:20:41','publishing_timestamp' => '2016-04-24 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160424%20-%20Alafuww.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-04-24 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:18"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'De vill släcka Allahs ljus (15 min)','created_at' => '2016-04-29 12:36:09','updated_at' => '2016-04-29 18:03:24','publishing_timestamp' => '2016-04-29 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160429%20-%20slacka%20Allahs%20ljus.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-04-29 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "15:01"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Syrien brinner (8 min)','created_at' => '2016-05-05 10:36:09','updated_at' => '2016-05-05 11:22:44','publishing_timestamp' => '2016-05-05 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160505%20-%20Syrien%20brinner.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-05-05 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:04"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Månaden Sha\'bân (9 min)','created_at' => '2016-05-08 12:36:09','updated_at' => '2016-05-08 13:26:10','publishing_timestamp' => '2016-05-08 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160508%20-%20shabaan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-05-08 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:22"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Råd inför Ramadan (9 min)','created_at' => '2016-05-12 02:36:09','updated_at' => '2016-05-12 17:03:19','publishing_timestamp' => '2016-05-12 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160512%20-%20tips%20ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-05-12 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:38"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Råd inför Ramadan - Del 2 (9 min)','created_at' => '2016-05-16 02:36:09','updated_at' => '2016-05-16 18:24:30','publishing_timestamp' => '2016-05-16 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160512%20-%20tips%20ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-05-16 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:09"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Mitten av månaden Sha\'ban (10 min)','created_at' => '2016-05-19 10:36:09','updated_at' => '2016-05-19 21:08:07','publishing_timestamp' => '2016-05-19 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160519%20-%20mitten%20shabaan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-05-19 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:02"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Råd inför Ramadan - Del 3 (9 min)','created_at' => '2016-05-24 02:36:09','updated_at' => '2016-05-24 11:32:40','publishing_timestamp' => '2016-05-24 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160524%20-%20ramadan%20r\\u00e5d%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-05-24 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:47"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Råd inför Ramadan - Del 4 (5 min)','created_at' => '2016-05-28 02:36:09','updated_at' => '2016-05-28 15:06:18','publishing_timestamp' => '2016-05-28 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160528%20-%20r\\u00e5d%20ramadan%204.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-05-28 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:31"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad är syftet med skapelsen? (5 min)','created_at' => '2016-06-06 02:36:09','updated_at' => '2016-06-06 15:22:58','publishing_timestamp' => '2016-06-06 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160606%20-%20Ramadan%201.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-06 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:31"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Åkalla endast Allah! (4 min)','created_at' => '2016-06-07 02:36:09','updated_at' => '2016-06-07 15:15:31','publishing_timestamp' => '2016-06-07 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160607%20-%20ramadan%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-07 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "3:50"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Fortsätta praktisera efter Ramadan (9 min)','created_at' => '2016-07-16 02:36:09','updated_at' => '2016-07-16 19:33:30','publishing_timestamp' => '2016-07-16 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160716%20-%20praktisera%20efter%20ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-16 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:23"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'All dyrkan för Allah! (8 min)','created_at' => '2016-06-08 02:36:09','updated_at' => '2016-06-08 12:28:19','publishing_timestamp' => '2016-06-08 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160608%20-%20ramadan%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-08 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:56"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Avguderi förstör alla handlingar! (7 min)','created_at' => '2016-06-09 02:36:09','updated_at' => '2016-06-08 12:45:15','publishing_timestamp' => '2016-06-09 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160609%20-%20ramadan%204.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-09 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tawheeds 3 kategorier (9 min)','created_at' => '2016-06-10 02:36:09','updated_at' => '2016-06-10 20:19:01','publishing_timestamp' => '2016-06-10 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160610%20-%20ramadan%205.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-10 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:36"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Fastan i ett orent tillstånd (6 min)','created_at' => '2016-06-11 10:36:09','updated_at' => '2016-06-11 14:22:56','publishing_timestamp' => '2016-06-11 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160611%20-%20ramadan%206.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-11 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:10"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Att kräkas, bryter det fastan? (3 min)','created_at' => '2016-06-13 10:36:09','updated_at' => '2016-06-13 17:15:47','publishing_timestamp' => '2016-06-13 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160611%20-%20ramadan%206.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-13 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "2:38"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Bryter synder fastan? (4 min)','created_at' => '2016-06-14 10:36:09','updated_at' => '2016-06-13 17:22:04','publishing_timestamp' => '2016-06-14 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160611%20-%20ramadan%206.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-14 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "4:19"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Sover bort Ramadan (4 min)','created_at' => '2016-06-15 10:36:09','updated_at' => '2016-06-13 17:43:32','publishing_timestamp' => '2016-06-15 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160615%20-%20ramadan%209.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-15 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "3:32"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ramadan är en speciell månad (5 min)','created_at' => '2016-06-16 10:36:09','updated_at' => '2016-06-13 17:50:43','publishing_timestamp' => '2016-06-16 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160616%20-%20ramadan%2010.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-16 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "4:52"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Förändringens månad (7 min)','created_at' => '2016-06-18 10:36:09','updated_at' => '2016-06-18 15:54:43','publishing_timestamp' => '2016-06-18 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160618%20-%201%20f\\u00f6r\\u00e4ndringens%20m\\u00e5nad.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-18 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:59"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Från mörker till ljus (6 min)','created_at' => '2016-06-19 10:36:09','updated_at' => '2016-06-18 16:01:53','publishing_timestamp' => '2016-06-19 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160619%20-%202%20fr\\u00e5n%20m\\u00f6rker%20till%20ljus.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-19 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:01"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tålamod med allt (6 min)','created_at' => '2016-06-20 10:36:09','updated_at' => '2016-06-18 16:05:28','publishing_timestamp' => '2016-06-20 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160620%20-%203%20t\\u00e5lamod%20med%20allt.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-20 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:19"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Sök hjälp med bönen (7 min)','created_at' => '2016-06-21 10:36:09','updated_at' => '2016-06-18 16:09:30','publishing_timestamp' => '2016-06-21 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160621%20-%204%20S\\u00f6k%20hj\\u00e4lp%20med%20b\\u00f6nen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-21 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:28"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tacksamhet och dhikr (6 min)','created_at' => '2016-06-22 10:36:09','updated_at' => '2016-06-18 16:12:55','publishing_timestamp' => '2016-06-22 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160622%20-%205%20tacksamhet%20och%20dhikr.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-22 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:51"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Från synder till lydnad (5 min)','created_at' => '2016-06-23 10:36:09','updated_at' => '2016-06-18 16:15:28','publishing_timestamp' => '2016-06-23 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160623%20-%206%20Fr\\u00e5n%20synder%20till%20lydnad.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-06-23 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:17"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tafsir från surat Al-Furqan (6 min)','created_at' => '2016-06-30 12:36:09','updated_at' => '2016-06-30 17:04:26','publishing_timestamp' => '2016-06-30 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160508%20-%20shabaan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-01 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:16"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tafsir från surat Al-Furqan - Del 2 (8 min)','created_at' => '2016-07-01 12:36:09','updated_at' => '2016-07-01 12:55:13','publishing_timestamp' => '2016-07-01 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160701%20-%20tafsir%20del%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-01 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:24"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tafsir från surat Al-Furqan - Del 3 (5 min)','created_at' => '2016-07-02 12:36:09','updated_at' => '2016-07-01 12:58:37','publishing_timestamp' => '2016-07-02 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160702%20-%20tafsir%20del%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-02 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "4:48"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tafsir från surat Al-Furqan - Del 4 (6 min)','created_at' => '2016-07-03 12:36:09','updated_at' => '2016-07-01 13:01:38','publishing_timestamp' => '2016-07-03 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160703%20-%20tafsir%20del%204.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-03 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:24"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tafsir från surat Al-Furqan - Del 5 (7 min)','created_at' => '2016-07-04 12:36:09','updated_at' => '2016-07-01 13:04:03','publishing_timestamp' => '2016-07-04 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160704%20-%20tafsir%20del%205.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-04 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:09"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Om Eid: Bestämmelser & Profetiska vägledningar (7 min)','created_at' => '2016-07-05 02:36:09','updated_at' => '2016-07-05 17:32:26','publishing_timestamp' => '2016-07-05 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160705%20-%20Eid%20al%20fitr.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-05 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:45"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Medan vi faller (7 min)','created_at' => '2016-07-21 02:36:09','updated_at' => '2016-07-21 20:27:01','publishing_timestamp' => '2016-07-21 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160721%20-%20medan%20vi%20faller.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-21 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:13"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Profetens Sunnah (9 min)','created_at' => '2016-07-27 02:36:09','updated_at' => '2016-07-26 20:45:23','publishing_timestamp' => '2016-07-27 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160721%20-%20medan%20vi%20faller.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-27 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:26"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Föräldrarnas & de äldres status i islam (10 min)','created_at' => '2016-07-27 02:36:09','updated_at' => '2016-07-27 18:30:09','publishing_timestamp' => '2016-07-27 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160721%20-%20medan%20vi%20faller.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-07-27 02:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:13"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Handlingarnas villkor (8 min)','created_at' => '2016-08-01 02:36:09','updated_at' => '2016-09-11 16:33:17','publishing_timestamp' => '2016-08-01 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160801%20-%20handlingarnas%20villkor.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-08-01 02:11:06"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:18"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Glimtar från Profetens karaktär (8 min)','created_at' => '2016-08-07 02:36:09','updated_at' => '2016-09-11 16:33:34','publishing_timestamp' => '2016-08-07 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160807%20-%20profetens%20karakt\\u00e4r.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-08-07 02:11:06"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:03"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Glimtar från Profetens karaktär - Del 2 (8 min)','created_at' => '2016-08-13 02:36:09','updated_at' => '2016-09-11 16:34:03','publishing_timestamp' => '2016-08-13 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160813%20-%20glimtar%20profeten%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-08-13 02:11:06"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:40"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Allahs vackra namn - Al-Wadud (8 min)','created_at' => '2016-08-18 10:36:09','updated_at' => '2016-09-11 16:34:35','publishing_timestamp' => '2016-08-18 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160818%20-%20al%20wadud.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-08-18 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "08:02"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Glimtar från Profetens karaktär - Del 3 (9 min)','created_at' => '2016-08-21 02:36:09','updated_at' => '2016-09-11 16:35:12','publishing_timestamp' => '2016-08-21 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160821%20-%20profetens%20glimtar%20del%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-08-21 02:11:06"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:19"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Allahs vackra namn - al-Kafi & al-Hasib (10 min)','created_at' => '2016-08-26 10:36:09','updated_at' => '2016-09-11 16:35:30','publishing_timestamp' => '2016-08-26 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160826%20-%20al%20hasib.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-08-26 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:34"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'De första 10 dagarna i Dhul-Hidjah (12 min)','created_at' => '2016-09-01 10:36:09','updated_at' => '2016-09-11 16:35:51','publishing_timestamp' => '2016-09-01 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160901%20-%20dhulhijja.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-09-01 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:36"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'De lärdas status (9 min)','created_at' => '2016-09-04 02:36:09','updated_at' => '2016-09-11 16:36:04','publishing_timestamp' => '2016-09-04 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160904%20-%20lardas%20status.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-09-04 02:11:06"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:10"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad hände efter Ramadan? (8 min)','created_at' => '2016-09-06 10:36:09','updated_at' => '2016-09-11 16:36:16','publishing_timestamp' => '2016-09-06 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160906%20-%20ramadan%20vart%20\\u00e4r%20du%20nu.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-09-06 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:22"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Eid ul-Adha (13 min)','created_at' => '2016-09-11 10:36:09','updated_at' => '2016-09-11 16:38:24','publishing_timestamp' => '2016-09-11 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160911%20-%20Eid%20al%20adha.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-09-11 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "13:36"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Allah är ovanför sin skapelse (8 min)','created_at' => '2016-09-16 02:36:09','updated_at' => '2016-09-16 19:37:13','publishing_timestamp' => '2016-09-16 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161116%20-%20Allah%20ovanfor%20skapelsen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-09-16 02:11:06"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:07"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ärlighet (10 min)','created_at' => '2016-09-21 12:36:09','updated_at' => '2016-09-21 17:54:29','publishing_timestamp' => '2016-09-21 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160704%20-%20tafsir%20del%205.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-09-21 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:09"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ärlighet - Del 2 (9 min)','created_at' => '2016-09-24 12:36:09','updated_at' => '2016-09-25 12:47:39','publishing_timestamp' => '2016-09-24 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/160924%20-%20arlighet%202.MP3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-09-24 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "09:03"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Den helgade månaden Muharram (7 min)','created_at' => '2016-10-02 02:36:09','updated_at' => '2016-10-16 09:49:15','publishing_timestamp' => '2016-10-02 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161002%20-%20muharram.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-10-02 02:11:06"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:52"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ärlighet - Del 3 (10 min)','created_at' => '2016-10-08 12:36:09','updated_at' => '2016-10-16 09:49:00','publishing_timestamp' => '2016-10-08 12:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161008%20-%20arlighet%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-10-08 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:33"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ärlighet i handel - Del 4 (15 min)','created_at' => '2016-10-16 11:36:09','updated_at' => '2016-10-16 09:54:41','publishing_timestamp' => '2016-10-16 11:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161016%20-%20arlighet%20i%20handel.MP3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-10-16 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "15:18"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Kampen till Jannah (9 min)','created_at' => '2016-10-18 02:36:09','updated_at' => '2016-10-19 16:06:26','publishing_timestamp' => '2016-10-18 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161019%20-%20kampen%20till%20jannah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-10-19 02:11:06"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:14"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Religionen är Nasihah (10 min)','created_at' => '2016-10-23 02:36:09','updated_at' => '2016-10-23 13:38:40','publishing_timestamp' => '2016-10-23 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161024%20-%20religionen%20ar%20nasiha.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-10-23 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:58"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'De 3 första som hamnar i elden (9 min)','created_at' => '2016-10-26 11:36:09','updated_at' => '2016-10-27 18:02:31','publishing_timestamp' => '2016-10-26 11:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161026%20-%20tre%20i%20elden.MP3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-10-26 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:11"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vikten av Du\'a (8 min)','created_at' => '2016-10-30 02:36:09','updated_at' => '2016-10-30 16:51:46','publishing_timestamp' => '2016-10-30 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161030%20-%20vikten%20av%20dua.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-10-30 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:11"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Trosbekännelsens 7 villkor (8 min)','created_at' => '2016-11-06 02:36:09','updated_at' => '2016-11-06 19:29:36','publishing_timestamp' => '2016-11-06 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161106%20-%20trosbek\\u00e4nnelsen%207%20villkor.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-11-06 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:41"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Den korrekta trosläran (9 min)','created_at' => '2016-11-09 10:36:09','updated_at' => '2016-11-09 16:48:10','publishing_timestamp' => '2016-11-09 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161109%20-%20korrekta%20troslaran.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-11-09 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:41"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Att lära sig om trosläran är obligatoriskt (10 min)','created_at' => '2016-11-13 10:36:09','updated_at' => '2016-11-13 16:42:02','publishing_timestamp' => '2016-11-13 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161109%20-%20korrekta%20troslaran.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-11-09 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:58"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Dyrkan i Islam (6 min)','created_at' => '2016-11-17 02:36:09','updated_at' => '2016-11-17 19:44:14','publishing_timestamp' => '2016-11-17 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161117%20-%20dyrkan%20i%20islam.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-11-17 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:00"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vägarna till ett lyckligt liv (10 min)','created_at' => '2016-11-21 02:36:09','updated_at' => '2016-11-21 19:02:46','publishing_timestamp' => '2016-11-21 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161121%20-%20vagarna%20till%20lyckligt%20liv.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-11-21 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:38"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Att kalla till den korrekta trosläran (9 min)','created_at' => '2016-11-26 10:36:09','updated_at' => '2016-12-01 16:57:18','publishing_timestamp' => '2016-11-26 10:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161126%20-%20kalla%20trosl\\u00e4ra.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-11-26 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:04"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur man hanterar ilska (7 min)','created_at' => '2016-12-01 02:36:09','updated_at' => '2016-12-01 16:58:58','publishing_timestamp' => '2016-12-01 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161201%20-%20hantera%20ilska.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-12-01 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:18"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Medan vi faller - Skjutningar & Mord (10 min)','created_at' => '2016-12-05 02:36:09','updated_at' => '2016-12-05 22:45:40','publishing_timestamp' => '2016-12-05 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "http:\\/\\/muslimappen.se\\/audio\\/paminnelser\\/161205%20-%20medan%20vi%20faller%20del%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-12-05 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:52"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ska man fira Profetens födelsedag? (11 min)','created_at' => '2016-12-10 02:36:09','updated_at' => '2016-12-10 18:10:26','publishing_timestamp' => '2016-12-10 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161210%20-%20mawlid.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-12-10 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:13"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Bortglömda Sunnah (11 min)','created_at' => '2016-12-19 18:45:51','updated_at' => '2016-12-19 17:51:59','publishing_timestamp' => '2016-12-19 18:45:54','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161219%20-%20bortglomda%20sunnah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-12-19 12:00:00"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:19"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Dagliga handlingar som hör till Sunnah (8 min)','created_at' => '2016-12-23 02:36:09','updated_at' => '2016-12-23 18:01:46','publishing_timestamp' => '2016-12-23 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161223%20-%20dagliga%20sunnah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-12-23 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:43"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Dagliga handlingar som hör till Sunnah - Del 2 (9 min)','created_at' => '2016-12-30 02:36:09','updated_at' => '2016-12-30 15:36:54','publishing_timestamp' => '2016-12-30 02:36:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/161230%20-%20sunnah%20del%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2016-12-30 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:37"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Dagliga handlingar som hör till Sunnah - Del 3 (10 min)','created_at' => '2017-01-04 10:47:50','updated_at' => '2017-06-10 17:43:17','publishing_timestamp' => '2017-01-04 10:47:52','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170104%20-%20sunnah%20del%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-01-04 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:46"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tawhid ar-Rububiyyah (11 min)','created_at' => '2017-01-09 10:26:47','updated_at' => '2017-06-10 17:43:39','publishing_timestamp' => '2017-01-09 10:26:47','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170109%20-%20tawheed%20rububiyah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-01-09 10:26:47"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:00"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tawhid al-Uluhiyyah (12 min)','created_at' => '2017-01-15 10:21:31','updated_at' => '2017-06-10 17:43:51','publishing_timestamp' => '2017-01-15 10:21:34','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170115%20-%20uluhiyah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-01-15 10:20:51"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:30"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Faran i att åkalla andra än Allah (4 min)','created_at' => '2017-01-24 10:47:50','updated_at' => '2017-06-10 17:44:03','publishing_timestamp' => '2017-01-24 10:47:52','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170122%20-%20\\u00e5kalla%20andra%20\\u00e4n%20allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-01-24 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "3:49"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Avguderi förstör alla handlingar (7 min)','created_at' => '2017-01-27 10:47:50','updated_at' => '2017-06-10 17:44:23','publishing_timestamp' => '2017-01-27 10:47:52','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170127%20-%20avguderi%20f\\u00f6rst\\u00f6r.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-01-27 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'All drykan hör endast till Allah (8 min)','created_at' => '2017-02-02 19:09:05','updated_at' => '2017-06-10 17:47:05','publishing_timestamp' => '2017-02-02 19:09:07','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170202%20-%20all%20dyrkan%20till%20allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-02-02 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:56"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur Tawhids kategorier hör ihop med varandra (10 min)','created_at' => '2017-02-09 21:24:49','updated_at' => '2017-06-10 17:47:28','publishing_timestamp' => '2017-02-09 21:24:51','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170115%20-%20uluhiyah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-02-09 10:20:51"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:30"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Koranens kall till Tawhid (12 min)','created_at' => '2017-02-15 21:24:49','updated_at' => '2017-06-10 17:47:43','publishing_timestamp' => '2017-02-15 21:24:51','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170216%20-%20Koranens%20kall%20till%20tawhid.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-02-16 10:20:51"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:25"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Bönen! Bönen! (9 min)','created_at' => '2017-02-02 19:09:05','updated_at' => '2017-06-10 17:44:35','publishing_timestamp' => '2017-02-02 19:09:07','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170224%20-%20bonen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-02-24 11:38:07"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:28"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur uppkom Shirk (12 min)','created_at' => '2017-03-04 21:24:49','updated_at' => '2017-06-10 17:48:05','publishing_timestamp' => '2017-03-04 21:24:51','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170304%20-%20uppkom%20shirk.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-03-04 10:20:51"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:39"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vägarna till Shirk - Del 1 (11 min)','created_at' => '2017-03-14 21:24:49','updated_at' => '2017-06-10 17:48:24','publishing_timestamp' => '2017-03-14 21:24:51','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170314%20-%20vagarna%20till%20shirk.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-03-14 10:20:51"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:43"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Viktiga Dua (8 min)','created_at' => '2017-03-25 15:53:25','updated_at' => '2017-06-10 17:48:40','publishing_timestamp' => '2017-03-25 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170325%20-%20viktiga%20dua.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-03-25 15:53:05"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "08:02"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Viktiga Dua - Del 2 (7 min)','created_at' => '2017-04-03 15:53:25','updated_at' => '2017-06-10 17:48:54','publishing_timestamp' => '2017-04-03 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170403%20-%20viktiga%20dua%20del%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-04-03 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "07:16"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Viktiga Dua - Del 3 (11 min)','created_at' => '2017-04-20 15:53:25','updated_at' => '2017-06-10 17:49:21','publishing_timestamp' => '2017-04-20 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170420%20-%20viktiga%20dua%20del%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-04-20 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:47"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Inför Ramadan - 2017  (8 min)','created_at' => '2017-04-24 08:16:09','updated_at' => '2017-06-10 17:49:38','publishing_timestamp' => '2017-04-24 09:16:16','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170424%20-%20inf\\u00f6r%20ramadan%202017.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-04-24 12:15:53"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:33"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett råd till muslimer efter attentatet i Stockholm (9 min)','created_at' => '2017-04-13 10:24:49','updated_at' => '2017-06-10 17:49:08','publishing_timestamp' => '2017-04-13 10:24:51','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170413%20-%20d%C3%A5det%20i%20stockholm.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-04-13 10:20:51"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:46"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Fastans Fördelar (7 min)','created_at' => '2017-04-28 09:55:13','updated_at' => '2017-06-10 17:49:51','publishing_timestamp' => '2017-04-28 09:55:16','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170428%20-%20fastans%20fordelar.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-04-28 11:55:01"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:21"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad bryter och vad bryter inte fastan? (8 min)','created_at' => '2017-05-02 20:05:33','updated_at' => '2017-06-10 17:50:04','publishing_timestamp' => '2017-05-02 20:05:35','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170502%20-%20vad%20bryter%20fastan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-05-02 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:55"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'När börjar och slutar Ramadan? (12 min)','created_at' => '2017-05-17 08:43:53','updated_at' => '2017-06-10 17:50:22','publishing_timestamp' => '2017-05-17 08:43:53','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170517%20-%20ramadan%20borja%20sluta.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-05-17 07:43:46"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:00"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => '6 nyttor med att ha Gudsfruktan (6 min)','created_at' => '2017-05-25 16:16:18','updated_at' => '2017-06-10 17:50:38','publishing_timestamp' => '2017-05-25 14:16:22','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170525%20-%20nyttor%20med%20taqwa.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-05-25 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:56"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Syftet med fastan i Ramadan (11 min)','created_at' => '2017-05-27 16:16:18','updated_at' => '2017-06-10 17:50:53','publishing_timestamp' => '2017-05-27 14:16:22','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170527%20-%20ramadan%201.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-05-27 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:56"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'De gudfruktiges egenskaper (9 min)','created_at' => '2017-05-28 16:16:18','updated_at' => '2017-06-10 17:51:25','publishing_timestamp' => '2017-05-28 14:16:22','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170528%20-%20ramadan%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-05-28 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:27"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur kan vi uppnå gudsfruktan? (11 min)','created_at' => '2017-05-28 16:16:18','updated_at' => '2017-06-10 17:51:12','publishing_timestamp' => '2017-05-28 14:16:22','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170529%20-%20ramadan%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-05-29 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:13"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Frukta Allah och ge inte upp (7 min)','created_at' => '2017-05-29 16:16:18','updated_at' => '2017-06-10 17:51:40','publishing_timestamp' => '2017-05-29 14:16:22','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170530%20-%20ramadan%204.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-05-29 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:36"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Döden och den intelligenta (11 min)','created_at' => '2017-05-31 16:16:18','updated_at' => '2017-06-10 17:51:55','publishing_timestamp' => '2017-05-31 14:16:22','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170531%20-%20ramadan%205.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-05-29 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vägen till gudsfruktan (11 min)','created_at' => '2017-06-01 12:52:59','updated_at' => '2017-06-10 17:52:08','publishing_timestamp' => '2017-06-01 12:53:03','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170601%20-%20ramadan%206.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-01 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:59"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ramadan - Koranens månad (12 min)','created_at' => '2017-06-03 15:53:25','updated_at' => '2017-06-10 17:52:28','publishing_timestamp' => '2017-06-03 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170603%20-%20ramadan%207.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-03 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:29"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur Allah ärar och upphöjer folk med Koranen (11 min)','created_at' => '2017-06-04 15:53:25','updated_at' => '2017-06-10 17:52:42','publishing_timestamp' => '2017-06-04 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170604%20-%20ramadan%208.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-04 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:22"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Koranen: En skatt av belöning och kunskap (13 min)','created_at' => '2017-06-05 15:53:25','updated_at' => '2017-06-10 17:52:55','publishing_timestamp' => '2017-06-05 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170605%20-%20ramadan%209.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-05 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:49"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Förträffligheten av vissa kapitel och verser från Koranen (12 min)','created_at' => '2017-06-06 15:53:25','updated_at' => '2017-06-10 17:53:09','publishing_timestamp' => '2017-06-06 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170605%20-%20ramadan%209.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-06 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:34"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Förträffligheten av vissa kapitel och verser från Koranen - Del 2 (11 min)','created_at' => '2017-06-07 15:53:25','updated_at' => '2017-06-10 17:53:32','publishing_timestamp' => '2017-06-07 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170607%20-%20ramadan%2011.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-07 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:49"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur ska man läsa Koranen? (13 min)','created_at' => '2017-06-08 15:53:25','updated_at' => '2017-06-10 17:53:43','publishing_timestamp' => '2017-06-08 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170608%20-%20ramadan%2012.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-08 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:55"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Förklaring av trons grunder - Del 2 (12 min)','created_at' => '2017-06-09 15:53:25','updated_at' => '2017-06-10 17:53:54','publishing_timestamp' => '2017-06-09 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170609%20-%20ramadan%2013.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-09 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:30"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Förklaring av trons grunder - Del 3 (13 min)','created_at' => '2017-06-10 15:53:25','updated_at' => '2017-06-10 17:54:04','publishing_timestamp' => '2017-06-10 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170610%20-%20ramadan%2014.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-10 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "13:31"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Förklaring av trons grunder - Del 4 (13 min)','created_at' => '2017-06-11 15:53:25','updated_at' => '2017-06-10 17:54:15','publishing_timestamp' => '2017-06-11 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170611%20-%20ramadan%2015.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-11 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "13:11"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Varför finns du? (2 min)','created_at' => '2017-06-14 15:53:25','updated_at' => '2017-06-14 17:57:28','publishing_timestamp' => '2017-06-14 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170614%20-%20ramadan%2016%20Ramadan%20Special%20Varf\\u00f6r%20finns%20du.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-14 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "1:34"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tiden (2 min)','created_at' => '2017-06-15 15:53:25','updated_at' => '2017-06-14 18:02:09','publishing_timestamp' => '2017-06-15 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170615-%20ramadan%2017%20Ramadan%20Special%20Tiden.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-15 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "1:21"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Att följa Profetens Sunnah (2 min)','created_at' => '2017-06-16 15:53:25','updated_at' => '2017-07-08 18:26:09','publishing_timestamp' => '2017-06-16 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170616%20-%20ramadan%2018%20Ramadan%20Special%20Att%20folja%20profetens%20sunnah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-16 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "1:48"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Fällor i Ramadan (2 min)','created_at' => '2017-06-17 15:53:25','updated_at' => '2017-06-14 18:08:04','publishing_timestamp' => '2017-06-17 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170617%20-%20Ramadan%20Special%20Fallor%20i%20Ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-17 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "2:21"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på sista dagen (11 min)','created_at' => '2017-07-08 10:27:26','updated_at' => '2017-07-08 18:30:16','publishing_timestamp' => '2017-06-16 15:53:27','expiring_timestamp' => '2017-07-08 12:27:29','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170708%20-%20tron%20p\\u00e5%20sista%20dagen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-07-08 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:39"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Avsluta Ramadan på bästa sätt (5 min)','created_at' => '2017-06-22 16:16:18','updated_at' => '2017-06-22 13:08:30','publishing_timestamp' => '2017-06-22 14:16:22','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170622%20-%20avsluta%20ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-22 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "4:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ta vara på sista dagarna i Ramadan (3 min)','created_at' => '2017-06-23 16:16:18','updated_at' => '2017-06-23 19:58:20','publishing_timestamp' => '2017-06-23 14:16:22','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170623%20-%20laylat%20ul%20qadr.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-06-23 11:03:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "3:18"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Att praktisera islam även efter Ramadan (7 min) ','created_at' => '2017-07-13 16:33:56','updated_at' => '2017-07-13 18:34:39','publishing_timestamp' => '2017-07-13 16:33:56','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170713%20-%20praktisera%20efter%20ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-07-13 12:33:46"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:47"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Qadr (13 min)','created_at' => '2017-07-21 15:53:25','updated_at' => '2017-07-21 17:25:17','publishing_timestamp' => '2017-07-21 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170721%20-%20tron%20p\\u00e5%20qadr.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-07-21 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:54"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Dygden av goda handlingar (10 min)','created_at' => '2017-07-26 16:33:56','updated_at' => '2017-07-26 20:07:32','publishing_timestamp' => '2017-07-26 16:33:56','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170726%20-%20dygden%20av%20goda%20handlingar.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-07-26 12:33:46"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:41"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Älskar du Allah? (2 min)','created_at' => '2017-08-05 15:53:25','updated_at' => '2017-08-09 19:20:36','publishing_timestamp' => '2017-08-05 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170805%20-%20\\u00e4lskar%20du%20allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-08-05 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "1:54"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "9"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Dygden av goda handlingar - Del 2 (6 min)','created_at' => '2017-08-09 16:33:56','updated_at' => '2017-08-09 19:24:26','publishing_timestamp' => '2017-08-09 16:33:56','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170809%20-%20dygden%20av%20goda%20hand%20del%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-08-09 12:33:46"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "5:56"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Dygden av goda handlingar - Del 3 (7 min)','created_at' => '2017-08-17 16:33:56','updated_at' => '2017-08-17 14:19:49','publishing_timestamp' => '2017-08-17 16:33:56','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170817%20-%20dygden%20av%20goda%20handlingar%20del%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-08-17 12:33:46"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:34"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'De tio första dagarna i Dhul-Hijjah (8 min)','created_at' => '2017-08-23 15:53:25','updated_at' => '2017-08-23 18:15:41','publishing_timestamp' => '2017-08-23 15:53:27','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170823%20-%20djul%20hijjah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-08-23 16:33:18"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:59"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Människornas liknelse i detta liv (11 min)','created_at' => '2017-09-07 12:52:07','updated_at' => '2017-09-07 18:58:51','publishing_timestamp' => '2017-09-07 12:52:07','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170907%20-%20m\\u00e4nniskornas%20liknelse.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-09-07 09:51:56"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:34"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur uppnår man inlevelse i Bönen? (9 min)','created_at' => '2017-09-18 12:00:37','updated_at' => '2017-09-18 17:03:39','publishing_timestamp' => '2017-09-18 10:00:41','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170918%20-%20inlevelse%20i%20bonen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-09-18 07:00:27"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:08"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Mest älskade handlingarna hos Allah (9 min)','created_at' => '2017-09-30 12:00:37','updated_at' => '2017-09-30 17:19:54','publishing_timestamp' => '2017-09-30 10:00:41','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/170930%20-%20b\\u00e4sta%20handlingarna.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-09-30 07:00:27"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:54"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'De tidiga imamernas bön (6 min)','created_at' => '2017-10-18 14:24:09','updated_at' => '2017-10-18 19:23:51','publishing_timestamp' => '2017-10-18 11:24:12','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/171018%20-%20de%20tidiga%20imamernas%20b\\u00f6n.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-10-18 14:23:55"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:07"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Berättelsen om pärlhalsbandet (10 min)','created_at' => '2017-11-01 21:54:48','updated_at' => '2017-11-02 20:54:55','publishing_timestamp' => '2017-11-01 21:54:48','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/171025%20-%20ber\\u00e4ttelsen%20om%20p\\u00e4rlhalsbandet.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-10-30 09:51:56"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:40"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Koranens väldigaste Surah (9 min)','created_at' => '2017-11-16 09:01:37','updated_at' => '2017-11-16 16:05:17','publishing_timestamp' => '2017-11-16 09:01:41','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/171116%20-%20koranens%20valdigaste%20surah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-11-16 07:00:27"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:31"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Drömmar (10 min)','created_at' => '2017-11-25 21:54:48','updated_at' => '2017-11-25 17:20:05','publishing_timestamp' => '2017-11-25 21:54:48','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/171124%20-%20Dr\\u00f6mmar.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-11-25 09:51:56"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:08"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Mawlid (9 min)','created_at' => '2017-11-30 09:01:37','updated_at' => '2017-11-30 16:55:52','publishing_timestamp' => '2017-11-30 09:01:41','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/171130%20-%20mawlid.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-11-30 07:00:27"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:54"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'al-Aqsa i våra hjärtan (10 min)','created_at' => '2017-12-14 14:24:09','updated_at' => '2017-12-14 17:57:51','publishing_timestamp' => '2017-12-14 11:24:12','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/171214%20-%20al%20aqsa.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-12-14 14:23:55"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:10"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Jesus sanna budskap (7 min)','created_at' => '2017-12-25 14:24:09','updated_at' => '2017-12-25 19:03:25','publishing_timestamp' => '2017-12-25 11:24:12','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/171225%20-%20Jesus%20sanna%20budskap.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2017-12-25 14:23:55"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:24"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tips för bättre sömn enligt Sunnah (10 min)','created_at' => '2018-01-04 16:32:00','updated_at' => '2018-01-04 20:42:36','publishing_timestamp' => '2018-01-04 14:32:03','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180104%20-%20b\\u00e4ttre%20s\\u00f6mn.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-01-04 07:00:27"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:52"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tips för bättre sömn enligt Sunnah - Del 2 (10 min)','created_at' => '2018-01-14 16:32:00','updated_at' => '2018-01-14 16:45:28','publishing_timestamp' => '2018-01-14 14:32:03','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180114%20-%20b\\u00e4ttre%20s\\u00f6mn%20del%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-01-14 07:00:27"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:39"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tre vackra råd (11 min)','created_at' => '2018-01-31 13:59:04','updated_at' => '2018-01-31 20:02:02','publishing_timestamp' => '2018-01-31 10:59:08','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180131%20-%20tre%20vackra%20rad.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-01-31 09:58:57"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:08"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ta vara på din hälsa (12 min)','created_at' => '2018-02-11 10:42:40','updated_at' => '2018-02-11 17:42:57','publishing_timestamp' => '2018-02-11 11:42:47','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180211%20-%20ta%20vara%20p\\u00e5%20h\\u00e4lsan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-02-11 09:42:04"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:30"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Lär känna Allah (6 min)','created_at' => '2018-02-15 12:50:38','updated_at' => '2018-02-15 14:50:58','publishing_timestamp' => '2018-02-15 12:50:41','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180215%20-%20lar%20kanna%20allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-02-15 10:50:29"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:11"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Varför besvaras inte min dua (6 min)','created_at' => '2018-02-21 11:02:32','updated_at' => '2018-02-21 19:34:44','publishing_timestamp' => '2018-02-21 11:02:34','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180221%20-%20besvara%20dua.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-02-21 11:02:12"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:17"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "202"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Sju farliga konsekvenser av synder (7 min)','created_at' => '2018-02-26 15:06:36','updated_at' => '2018-02-26 18:07:29','publishing_timestamp' => '2018-02-26 13:06:39','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180226%20-%20sju%20konsekvenser%20av%20synder.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-02-26 13:06:24"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:42"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vanliga misstag man säger och gör (6 min)','created_at' => '2018-03-04 13:55:29','updated_at' => '2018-03-04 18:56:19','publishing_timestamp' => '2018-03-04 12:55:32','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180304%20-%20vanliga%20misstag.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-03-04 13:55:14"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:28"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => '7 enkla sätt du kan bekämpa islamhatet på sociala medier (12 min)','created_at' => '2018-03-08 14:20:26','updated_at' => '2018-03-08 18:20:33','publishing_timestamp' => '2018-03-08 13:20:29','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180308%20-%20hatet%20p\\u00e5%20sociala%20medier.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-03-08 12:20:13"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:10"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Några tips kring barnuppfostran (10 min)','created_at' => '2018-03-12 13:55:29','updated_at' => '2018-03-12 16:53:59','publishing_timestamp' => '2018-03-12 12:55:32','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180312%20-%20barnuppfostran.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-03-12 13:55:14"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:51"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur kan jag förbättra min bön (8 min)','created_at' => '2018-02-21 11:02:32','updated_at' => '2018-03-25 17:58:17','publishing_timestamp' => '2018-02-21 11:02:34','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180325%20-%20hur%20f\\u00f6rb\\u00e4ttrar%20b\\u00f6nen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-02-21 11:02:12"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:30"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "202"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Råd inför Ramadan 2018 (10 min)','created_at' => '2018-04-15 13:19:23','updated_at' => '2018-04-15 15:19:55','publishing_timestamp' => '2018-04-15 12:19:29','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180415%20-%20inf\\u00f6r%20ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-04-15 10:19:10"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:36"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Visdomen bakom fastan (7 min)','created_at' => '2018-04-23 13:04:21','updated_at' => '2018-04-23 18:04:41','publishing_timestamp' => '2018-04-23 12:04:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180422%20-%20visdomen%20bakom%20fastan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-04-23 10:19:10"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:27"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vanliga misstag i Ramadan (9 min)','created_at' => '2018-05-05 13:04:21','updated_at' => '2018-05-05 18:48:06','publishing_timestamp' => '2018-05-05 12:04:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180505%20-%20vanliga%20misstag%20i%20ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-05 10:19:10"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:19"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur ska vi välkomna Ramadan (11 min)','created_at' => '2018-05-16 09:18:01','updated_at' => '2018-05-16 14:18:33','publishing_timestamp' => '2018-05-16 09:18:05','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180516%20-%20valkomna%20ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-16 11:17:50"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "11:17"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Målet med fastan (11 min)','created_at' => '2018-05-17 15:19:19','updated_at' => '2018-05-17 15:25:49','publishing_timestamp' => '2018-05-17 15:19:19','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180517%20-%20R1%20-%20M\\u00e5let%20med%20fastan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-17 17:25:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:38"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'De gudsfruktigas egenskaper (9 min)','created_at' => '2018-05-18 15:19:19','updated_at' => '2018-05-17 15:34:38','publishing_timestamp' => '2018-05-18 15:19:19','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180518%20-%20R2%20-%20De%20gudfruktigas%20egenskaper.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-18 15:25:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:24"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad har du förberett till Domedagen (10 min)','created_at' => '2018-05-19 15:19:19','updated_at' => '2018-05-17 15:34:15','publishing_timestamp' => '2018-05-19 15:19:19','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180519%20-%20R3%20-%20Vad%20har%20du%20f\\u00f6rberett%20till%20Domedagen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-19 15:25:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:01"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Rädda dig från elden (10 min)','created_at' => '2018-05-20 12:19:19','updated_at' => '2018-05-20 12:05:59','publishing_timestamp' => '2018-05-20 12:19:19','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180520%20-%20R4%20-%20R\\u00e4dda%20dig%20fr\\u00e5n%20elden.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-20 15:25:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:28"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Allah (9 min)','created_at' => '2018-05-21 13:04:21','updated_at' => '2018-05-21 17:26:47','publishing_timestamp' => '2018-05-21 12:04:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180521%20-%20R5%20-%20Tron%20p\\u00e5%20Allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-21 10:19:10"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:50"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Änglarna (7 min)','created_at' => '2018-05-22 13:04:21','updated_at' => '2018-05-22 19:21:02','publishing_timestamp' => '2018-05-22 12:04:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180522%20-%20R6%20-%20Tron%20p\\u00e5%20\\u00c4nglarna.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-22 10:19:10"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Böckerna (6 min)','created_at' => '2018-05-23 13:04:21','updated_at' => '2018-05-23 16:09:03','publishing_timestamp' => '2018-05-23 12:04:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180523%20-%20R7%20-%20Tron%20p\\u00e5%20B\\u00f6ckerna.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-23 10:19:10"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:08"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Sändebuden (7 min)','created_at' => '2018-05-24 13:04:21','updated_at' => '2018-05-23 16:11:36','publishing_timestamp' => '2018-05-24 12:04:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180524%20-%20R8%20-%20Tron%20p\\u00e5%20S\\u00e4ndebuden.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-24 10:19:10"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:53"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Domedagen & Ödet (12 min)','created_at' => '2018-05-25 13:04:21','updated_at' => '2018-05-23 16:15:16','publishing_timestamp' => '2018-05-25 12:04:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180525%20-%20R9%20-%20Tron%20p\\u00e5%20Domedagen%20%26%20\\u00d6det.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-05-25 10:19:10"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:10"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur kan vi öka vår tro på Allah (9 min) ','created_at' => '2018-06-01 12:10:37','updated_at' => '2018-06-01 19:11:16','publishing_timestamp' => '2018-06-01 13:10:39','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180601%20-%20R16%20-%20\\u00d6ka%20tron%20p\\u00e5%20Allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-06-01 12:09:48"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:09"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur kan vi öka vår tro på Allah - Del 2 (7 min)','created_at' => '2018-06-02 12:10:37','updated_at' => '2018-06-02 15:57:35','publishing_timestamp' => '2018-06-02 13:10:39','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180602%20-%20R17%20-%20\\u00d6ka%20tron%20p\\u00e5%20Allah%20-%20del%202.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-06-02 12:09:48"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:43"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur kan vi öka vår tro på Allah - Del 3 (8 min)','created_at' => '2018-06-03 12:10:37','updated_at' => '2018-06-02 16:01:10','publishing_timestamp' => '2018-06-03 13:10:39','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180603%20-%20R18%20-%20\\u00d6ka%20tron%20p\\u00e5%20Allah%20del%203.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-06-03 12:09:48"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:02"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur kan vi öka vår tro på Allah - Del 4 (7 min)','created_at' => '2018-06-04 12:10:37','updated_at' => '2018-06-02 16:04:09','publishing_timestamp' => '2018-06-04 13:10:39','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180604%20-%20R19%20-%20\\u00d6ka%20tron%20p\\u00e5%20Allah%20del%204.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-06-04 12:09:48"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:12"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => '10 sista dagarna (4 min)','created_at' => '2018-06-06 09:04:00','updated_at' => '2018-06-06 12:04:21','publishing_timestamp' => '2018-06-06 10:04:02','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180606%20-%20R21%20-%2010%20sista%20dagarna.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-06-06 11:03:49"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "4:14"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "202"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Laylat ul-Qadr (7 min)','created_at' => '2018-06-07 09:04:00','updated_at' => '2018-06-06 12:11:16','publishing_timestamp' => '2018-06-07 10:04:02','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180607%20-%20R22%20-%20Laylat%20al%20qadr.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-06-07 11:03:49"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:00"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "202"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Att tänka på när man gör dua (8 min)','created_at' => '2018-06-08 09:04:00','updated_at' => '2018-06-06 12:16:59','publishing_timestamp' => '2018-06-08 10:04:02','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "http:\\/\\/muslimappen.se\\/audio\\/paminnelser\\/180608%20-%20R23%20-%20Att%20t%C3%A4nka%20p%C3%A5%20n%C3%A4r%20man%20g%C3%B6r%20dua.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-06-08 11:03:49"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:41"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "202"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Skänk ifrån det du älskar (11 min)','created_at' => '2018-06-11 09:04:00','updated_at' => '2018-06-11 15:07:48','publishing_timestamp' => '2018-06-11 10:04:02','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180611%20-%20R26%20-%20Sk\\u00e4nk%20ifr\\u00e5n%20det%20du%20\\u00e4lskar.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-06-11 11:03:49"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:51"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Berättelsen om den blinde, den spetälske och den flintskallige (17 min)','created_at' => '2018-07-02 09:42:45','updated_at' => '2018-07-09 19:52:06','publishing_timestamp' => '2018-07-02 10:42:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180702%20-%20ber\\u00e4ttelsen%20om%20spet\\u00e4lske.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-07-02 10:42:25"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "17:16"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Föräldrarnas status i Islam (7 min) ','created_at' => '2018-07-09 09:04:00','updated_at' => '2018-07-09 19:51:46','publishing_timestamp' => '2018-07-09 10:04:02','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180709%20-%20f\\u00f6r\\u00e4ldrarnas%20status.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-07-09 11:03:49"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:07"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "202"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Varför ber du inte? Svar på de vanligaste ursäkterna (10 min)','created_at' => '2018-07-18 12:48:48','updated_at' => '2018-07-18 18:49:10','publishing_timestamp' => '2018-07-18 13:48:53','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180718%20-%20varf\\u00f6r%20ber%20du%20inte.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-07-18 14:48:38"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:52"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'At-Tawakkul - Att lita på Allah (10 min)','created_at' => '2018-07-25 14:22:32','updated_at' => '2018-07-25 19:23:04','publishing_timestamp' => '2018-07-25 13:22:36','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180725%20-%20Tawakull.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-07-25 14:48:38"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:43"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Skatter bättre än guld och silver (15 min)','created_at' => '2018-08-02 14:47:42','updated_at' => '2018-08-02 16:48:06','publishing_timestamp' => '2018-08-02 13:47:46','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180802%20-%20Skatter.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-08-02 10:42:25"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "15:00"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Balans i dyrkan (8 min)','created_at' => '2018-08-11 10:09:20','updated_at' => '2018-08-11 12:09:44','publishing_timestamp' => '2018-08-11 08:09:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180811%20-%20Balans%20i%20religionen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-08-11 14:48:38"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Faran i att förtrycka någon (7 min)','created_at' => '2018-08-30 10:09:20','updated_at' => '2018-08-30 19:21:44','publishing_timestamp' => '2018-08-30 08:09:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180830%20-%20faran%20i%20att%20fortrycka%20nagon.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-08-30 14:48:38"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:15"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Skynda till gott (6 min)','created_at' => '2018-08-30 10:09:20','updated_at' => '2018-09-09 18:40:48','publishing_timestamp' => '2018-08-30 08:09:24','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180909%20-%20skynda%20till%20gott.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-09-09 11:31:15"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:27"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Bli förlåten 1 års synder under Ashura dagen (4 min)','created_at' => '2018-09-17 12:17:28','updated_at' => '2018-09-17 15:21:13','publishing_timestamp' => '2018-09-17 11:17:31','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/180916%20-%20bli%20f\\u00f6rl\\u00e5ten%201%20\\u00e5rs%20synde.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-09-17 12:21:02"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "4:02"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vi måste ha tålamod (9 min)','created_at' => '2018-10-06 10:42:43','updated_at' => '2018-10-06 12:43:05','publishing_timestamp' => '2018-10-06 09:42:47','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "http:\\/\\/muslimappen.se\\/audio\\/paminnelser\\/181006%20-%20m%C3%A5ste%20ha%20t%C3%A5lamod.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-10-06 12:21:02"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => '9 faktorer som får bort shaytan (8 min)','created_at' => '2018-10-12 10:42:43','updated_at' => '2018-10-13 11:24:06','publishing_timestamp' => '2018-10-12 09:42:47','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/181013%20-%209%20faktorer%20som%20f\\u00e5r%20bort%20shaytan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-10-13 12:21:02"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'De fyra mest älskade orden hos Allah (10 min) ','created_at' => '2018-10-27 06:57:10','updated_at' => '2018-10-27 13:57:48','publishing_timestamp' => '2018-10-27 08:57:13','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/181027%20-%204%20ord.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-10-27 09:56:54"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:36"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "6"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'O Allah, hjälp mig minnas dig... (8 min)','created_at' => '2018-11-20 09:04:00','updated_at' => '2018-11-20 18:37:11','publishing_timestamp' => '2018-11-20 10:04:02','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/181120%20-%20O%20allah%20hj\\u00e4lp%20mig%20minnas%20dig.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-11-20 11:03:49"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:40"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "202"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett råd till ungdomar kring droger & kriminalitet (10 min)','created_at' => '2018-12-04 09:31:22','updated_at' => '2018-12-04 15:35:17','publishing_timestamp' => '2018-12-04 10:31:26','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/181204%20-%20Ett%20r\\u00e5d%20till%20ungdomar.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-12-04 08:29:26"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:57"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad betyder Shahadah (Trosbekännelsen)? (7 min)','created_at' => '2018-12-12 08:47:05','updated_at' => '2018-12-12 15:53:26','publishing_timestamp' => '2018-12-12 08:47:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/191212%20-%20vad%20betyder%20shahadah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-12-12 11:46:50"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:26"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad betyder "ilah" (Gudom) i trosbekännelsen? (7 min)','created_at' => '2018-12-12 08:47:05','updated_at' => '2018-12-27 13:12:00','publishing_timestamp' => '2018-12-12 08:47:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/191227%20-%20Vad%20betyder%20ilah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-12-27 11:46:50"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:56"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad betyder La ilah illa Allah (8 min)','created_at' => '2019-01-09 19:14:49','updated_at' => '2019-01-18 16:02:26','publishing_timestamp' => '2018-01-09 08:47:09','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190109%20-%20vad%20betyder%20la%20ilah%20illa%20allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2018-01-09 11:46:50"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:04"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Några av trosbekännelsens dygder (8 min)','created_at' => '2019-01-18 10:03:46','updated_at' => '2019-01-18 16:03:55','publishing_timestamp' => '2019-01-18 10:03:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190118%20-%20n\\u00e5gra%20av%20trosbek\\u00e4nnelsen%20dygder.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-01-18 11:03:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:42"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Villkoren för La ilah illa Allah (11 min)','created_at' => '2019-01-30 10:27:28','updated_at' => '2019-01-30 19:27:57','publishing_timestamp' => '2019-01-30 12:27:32','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190130%20-%20la%20ilah%20illa%20allahs%20villkor.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-01-30 09:27:14"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:53"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad går emot La ilah illa Allah (8 min)','created_at' => '2019-02-17 10:50:59','updated_at' => '2019-02-17 13:51:22','publishing_timestamp' => '2019-02-17 09:51:03','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190217%20-%20vad%20g\\u00e5r%20emot%20la%20ilah%20illa%20allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-02-17 09:50:49"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:08"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Felaktiga förståelser av La ilaha illa Allah (8 min)','created_at' => '2019-03-05 09:00:19','updated_at' => '2019-03-05 13:00:41','publishing_timestamp' => '2019-03-05 10:00:23','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190305%20-%20felaktiga%20f\\u00f6rst\\u00e5elser%20av%20La%20ilah%20illa%20Allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-03-05 14:00:09"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "8:08"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Islamofobin  (13 min)','created_at' => '2019-03-16 13:01:11','updated_at' => '2019-03-16 19:02:30','publishing_timestamp' => '2019-03-16 11:01:16','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190316%20-%20islamofobi.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-03-16 17:00:50"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:58"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "2"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => '5 tips inför Ramadan (6 min)','created_at' => '2019-03-30 10:38:53','updated_at' => '2019-03-30 18:39:16','publishing_timestamp' => '2019-03-30 10:38:57','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190330%20-%205%20tips%20infor%20ramadan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-03-30 09:38:44"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:25"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ett gyllene råd ifrån profeten till Abu Dharr (7 min)','created_at' => '2019-04-11 13:09:48','updated_at' => '2019-04-11 19:10:09','publishing_timestamp' => '2019-04-11 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190411%20-%20ett%20gyllene%20r\\u00e5d%20till%20abu%20dharr.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-04-11 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:13"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "202"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Ramadan - Förändringen börjar här och nu idag! (7 min)','created_at' => '2019-05-05 13:09:48','updated_at' => '2019-05-05 14:15:04','publishing_timestamp' => '2019-05-05 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190503%20-%20Ramadan%200%20-%20F\\u00f6r\\u00e4ndringen%20b\\u00f6rjar%20h\\u00e4r%20och%20nu%20idag%20.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-05 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:58"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Målet med fastan i Ramadan (11 min)','created_at' => '2019-05-05 13:09:48','updated_at' => '2019-05-07 11:56:23','publishing_timestamp' => '2019-05-05 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190507%20-%20Ramadan%20Dag%201%20-%20M\\u00e5let%20med%20fastan.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-07 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:38"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vilka egenskaper har de gudfruktiga? (9 min)','created_at' => '2019-05-08 13:09:48','updated_at' => '2019-05-07 12:00:47','publishing_timestamp' => '2019-05-08 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190508%20-%20Ramadan%20Dag%202%20-%20Vilka%20egenskaper%20har%20de%20gudfruktiga.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-08 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "9:24"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Vad har du förberett inför Domedagen? (10 min)','created_at' => '2019-05-09 13:09:48','updated_at' => '2019-05-07 12:03:30','publishing_timestamp' => '2019-05-09 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190509%20-%20Ramdan%20Dag%203%20-%20Vad%20har%20du%20f\\u00f6rberett%20inf\\u00f6r%20Domedagen%3F.m4a.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-09 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:01"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Hur viktigt är vårt tal och vad vi säger? (10 min)','created_at' => '2019-05-10 13:09:48','updated_at' => '2019-05-07 12:06:10','publishing_timestamp' => '2019-05-10 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190510%20-%20Ramadan%20dag%204%20-%20%20Hur%20viktigt%20\\u00e4r%20v\\u00e5rt%20tal%20och%20vad%20vi%20s\\u00e4ger%3F.m4a.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-10 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:27"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "19"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Allah (10 min)','created_at' => '2019-05-11 13:09:48','updated_at' => '2019-05-08 11:16:59','publishing_timestamp' => '2019-05-11 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190511%20-%20Ramadan%20dag%205%20-%20Tron%20p\\u00e5%20Allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-11 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "10:33"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Änglarna (7 min)','created_at' => '2019-05-12 13:09:48','updated_at' => '2019-05-08 11:19:40','publishing_timestamp' => '2019-05-12 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190512%20-%20Ramadan%20dag%206%20-%20Tron%20p\\u00e5%20\\u00e4nglarna.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-12 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:33"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Böckerna (7 min)','created_at' => '2019-05-13 13:09:48','updated_at' => '2019-05-26 11:13:21','publishing_timestamp' => '2019-05-13 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190513%20-%20Ramadan%20dag%207%20-%20Tron%20p\\u00e5%20b\\u00f6ckerna.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-13 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:31"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Sändebuden (7 min)','created_at' => '2019-05-14 13:09:48','updated_at' => '2019-05-08 11:24:25','publishing_timestamp' => '2019-05-14 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190514%20-%20Ramadan%20dag%208%20-%20Tron%20p\\u00e5%20s\\u00e4ndebuden.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-14 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:02"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Domedagen (6 min)','created_at' => '2019-05-15 13:09:48','updated_at' => '2019-05-08 11:27:31','publishing_timestamp' => '2019-05-15 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190515%20-%20Ramadan%20dag%209%20-%20Tron%20p\\u00e5%20domedagen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-15 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:10"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tron på Ödet (6 min)','created_at' => '2019-05-16 13:09:48','updated_at' => '2019-05-08 11:29:49','publishing_timestamp' => '2019-05-16 10:09:50','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190516%20-%20Ramadan%20dag%2010%20-%20Tron%20p\\u00e5%20\\u00f6det.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-16 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "6:00"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "3"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Tillit till Allah (12 min)','created_at' => '2019-05-27 12:49:18','updated_at' => '2019-05-26 10:49:49','publishing_timestamp' => '2019-05-27 12:49:18','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190527%20-%20Ramadan%20dag%2022%20-%20Tillit%20till%20Allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-27 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "12:09"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "202"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'La ilaha illa Allah (7 min)','created_at' => '2019-05-27 12:49:18','updated_at' => '2019-05-26 11:09:13','publishing_timestamp' => '2019-05-27 12:49:18','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190526%20-%20Ramadan%20dag%2021%20-%20La%20ilah%20illa%20allah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-26 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "7:23"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "266"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Bönen (14 min)','created_at' => '2019-05-28 12:49:18','updated_at' => '2019-05-30 14:27:05','publishing_timestamp' => '2019-05-28 12:49:18','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190528%20-%20Ramadan%2025%20-%20B\\u00f6nen.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-28 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "13:52"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "268"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Zakat (15 min)','created_at' => '2019-05-31 12:49:18','updated_at' => '2019-05-31 16:54:36','publishing_timestamp' => '2019-05-31 12:49:18','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190531%20-%20Ramadan%2026%20-%20Zakat.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-05-31 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "15:45"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "268"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}'),
        array('type' => 'movie','title' => 'Sadaqah (18 min) ','created_at' => '2019-06-02 12:49:18','updated_at' => '2019-06-02 16:13:00','publishing_timestamp' => '2019-06-02 12:49:18','expiring_timestamp' => '0000-00-00 00:00:00','elements' => ' {
	"f9f1824e-fe94-4b81-9301-8b61f314a161":  {
		"0":  {
			"file": "",
			"width": "",
			"height": "",
			"autoplay": "0",
			"image": "",
			"title": ""
		}
	},
	"90eee517-9c10-4297-a0d8-72c84ae74d22":  {
		"url": "audio\\/paminnelser\\/190602%20-%20sadaqah.mp3",
		"width": "",
		"height": "",
		"autoplay": "0"
	},
	"8a220e32-6975-41ec-9c26-4f73f18d47d3":  {
		"0":  {
			"value": "2019-06-02 09:09:35"
		}
	},
	"69057819-0f6e-46ba-a16f-580328c3bfe4":  {
		"0":  {
			"value": "18:01"
		}
	},
	"3c1156e0-14d2-4e70-8d75-a3a92c93d7b9":  {
		"item":  {
			"0": "268"
		}
	},
	"2a2257fa-56fd-4bdb-8b47-662baba460e4":  {
		"0":  {
			"value": "",
			"text": "",
			"target": "0",
			"custom_title": "",
			"rel": ""
		}
	},
	"f8cadbf4-23f0-479f-929f-15801b7a8442":  {

	},
	"fc6f9df9-8604-4ce2-a293-c60089ec6dbc":  {
		"0":  {
			"value": ""
		}
	}
}')
    );
}
