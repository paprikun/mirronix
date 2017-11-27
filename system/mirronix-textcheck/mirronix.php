<?php
function MirronixTextСheck($text, $lang){
$error = array('err','critical');
$curses_text = file_get_contents('curses.txt');
$prostitution_text = file_get_contents('prostitution.txt');
$curses_text = '/'.str_replace(array("\r\n"),'|',$curses_text).'/';
$prostitution_text = '/'.str_replace(array("\r\n"),'|',$prostitution_text).'/';
//переменная ошибок
$error = array('msg','critical'); 
//проверка на длину
if (!empty($text)) {
	if (strlen($text) <= 1000){
				if (preg_match($curses_text,$text)){
					$error['msg'] = 'Извините, в вашем тексте встречаются нецензурные выражение, у нас они запрещены' ;
					$error['critical'] = 1; 
				}else if (preg_match($prostitution_text,$text)){
					$error['msg'] =  'Извините, у нас запрещена проституция' ;
					$error['critical'] = 1; 
				}else if (preg_match('/(собачка|собака|@|-at-)([\s]+|-+|)([a-z]+)([\s]+|-+|)(\.|точка|-+)([\s]+|-+|)([a-z]+)/iu', $text)){
					$error['msg'] =  'Извините, у нас запрещено публиковать любые личные контакты и е-мейлы';
					$error['critical'] = 1; 
				}else if (preg_match('/[\'\^\[\]]/', $text)){
					$error['msg'] =  'Вы используете странные символы. Пишите на русском языке;';
					$error['critical'] = 1;
				}else if (preg_match('/(www)([\s]+|-+|)(\.|точка|-+)([\s]+|-+|)([a-z]+)([\s]+|-+|)(\.|точка|-+)([\s]+|-+|)([a-z]+)/iu', $text)){
					$error['msg'] =  'Извините, у нас запрещено публиковать ссылки на чужие сайты';
					$error['critical'] = 1;
				}else if (preg_match('/((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}/', $text)){
					$error['msg'] =  'Извините, у нас запрещено публиковать телефоны в тексте объявления';
					$error['critical'] = 1;
				}else{
					$error['msg'] =  'ошибок нет';
					$error['critical'] = null;
				}
		}else{
			$error['msg'] =   'длина превышает 1000 символов';
			$error['critical'] = 1;
		}
	}else{
		$error['msg'] =   'сообщение пустое';
		$error['critical'] = 1;
	}
	return $error;
}
?>


