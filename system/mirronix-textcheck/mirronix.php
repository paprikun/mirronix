<?php
function MirronixTextСheck($text, $lang){
$error = array('err','critical');
$filepath = $_SERVER['DOCUMENT_ROOT'].'/system/mirronix-textcheck/'.$lang.'/';
//путь к ругательствам, регистро независим
$curses_text = file_get_contents($filepath.'curses.txt');
//путь к предложениям интим услуг регистро независим
$prostitution_text = file_get_contents($filepath.'prostitution.txt');

//путь к вариантам собаки, регистро независим
$dogs_text = file_get_contents($filepath.'dogs.txt');
$dogs_text = str_replace(array("\r\n"),'|',$dogs_text);
//путь к вариантам точки, регистро независим
$points_text = file_get_contents($filepath.'points.txt');
$points_text = str_replace(array("\r\n"),'|',$points_text);

//путь к текстам ошибок, регистро независим
$error_text = file_get_contents($filepath.'error_text.txt');
$error_text = str_replace(array("\r\n"),'|',$error_text);
$error_t = array();
$error_t = explode("|", $error_text);


$curses_text = '/'.str_replace(array("\r\n"),'|',$curses_text).'/iu';
$prostitution_text = '/'.str_replace(array("\r\n"),'|',$prostitution_text).'/iu';
//переменная ошибок
$error = array('msg'=> '0','critical' => '0'); 
//проверка на длину
if (!empty($text)) {
	if (strlen($text) <= 1000){
				if (preg_match($curses_text,$text)){
					$error['msg'] = $error_t[0] ;
					$error['critical'] = 1; 
				}else if (preg_match($prostitution_text,$text)){
					$error['msg'] =  'Извините, у нас запрещена проституция' ;
					$error['critical'] = 1; 
				}else if (preg_match('/('.$dogs_text.'|@)([\s]+|-+|)([А-Яа-я\w]+)([\s]+|-+|)('.$points_text.')([\s]+|-+|)([А-Яа-я\w])/iu', $text)){
					$error['msg'] =  'Извините, у нас запрещено публиковать любые личные контакты и е-мейлы';
					$error['critical'] = 1; 
				}else if (preg_match('/[\'\^\[\]]/', $text)){
					$error['msg'] =  'Вы используете странные символы. Пишите на русском языке;';
					$error['critical'] = 1;
				}else if (preg_match('/(www)([\s]+|-+|)('.$points_text.')([\s]+|-+|)([А-Яа-я\w]+)([\s]+|-+|)('.$points_text.')([\s]+|-+|)([А-Яа-я\w]+)/iu', $text)){
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


