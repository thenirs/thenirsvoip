<?php

session_start();
if (!isset($_SESSION['good_admin'])){Header("Location: login.php"); exit;}


//Функция возвращает строку вида 03:23:17 (временной интервал с человеческим лицом)
//Аргументом - количество секунд

function sec2time($time){

 $hours = floor($time/3600);
 $min = floor($minutes = ($time/3600 - $hours)*60);
 $sec = $seconds = ceil(($minutes - floor($minutes))*60);

 if ($hours == 0) {$hours = "00";}else{
                  $hours = $hours;
                  if ($hours < 10) {$hours = '0'.$hours;}
}

 if ($min == 0 ){$min = "00";}else{
                                  $min = $min;
                                   if ($min < 10) {$min = '0'.$min;}
                                   }

 if ($sec == 0) {$sec = "00";}else{
                                  $sec = $sec;
                                  if ($sec < 10) {$sec = '0'.$sec;}
                                   }


 return $hours.':'.$min.':'.$sec;
}


// Подключение и выбор БД
$db = mysql_connect('localhost', 'voipstat',
'agentvoip');
mysql_select_db('asteriskcdr');

// Номер запрашиваемой страницы
$page = $_GET['page'];

$limit = 10;
// Количество запрашиваемых записей
$limit = $_GET['rows'];

$sidx = $_GET['sidx'];

// Направление сортировки
$sord = $_GET['sord'];

// Если не указано поле сортировки,
// то производить сортировку по первому полю
if(!$sidx) $sidx =1;

if (!$_GET['_search']) {
                        $where='';
                       }else{
                       $searchField = $_GET['searchField'];
                       $searchString = $_GET['searchString'];
                       $searchOper = $_GET['searchOper'];
                       if ($searchOper == 'bw') $where = "WHERE $searchField LIKE '".$searchString."%'";
                       if ($searchOper == 'ew') $where = "WHERE $searchField LIKE '%".$searchString."'";
                       if ($searchOper == 'cn') $where = "WHERE $searchField LIKE '%".$searchString."%'";
                       if ($searchOper == 'nc') $where = "WHERE $searchField NOT LIKE '%".$searchString."%'";
                       if ($searchOper == 'en') $where = "WHERE $searchField NOT LIKE '%".$searchString."'";
                       if ($searchOper == 'bn') $where = "WHERE $searchField NOT LIKE '".$searchString."%'";
                       if ($searchOper == 'eq') $where = "WHERE $searchField = '".$searchString."'";
                       if ($searchOper == 'ne') $where = "WHERE $searchField <> '".$searchString."'";
                       }

// Выполним запрос, который
// вернет суммарное кол-во записей в таблице
$result = mysql_query("SELECT COUNT(*) AS count FROM cdr ".$where);
$row = mysql_fetch_array($result,MYSQL_ASSOC);
// Теперь эта переменная хранит кол-во записей в таблице
$count = $row['count'];

// Рассчитаем сколько всего страниц займут данные в БД
if( $count > 0 && $limit > 0) {
    $total_pages = ceil($count/$limit);
} else {
    $total_pages = 0;
}

// Если по каким-то причинам клиент запросил
if ($page > $total_pages) $page=$total_pages;

// Рассчитываем стартовое значение для LIMIT запроса
$start = $limit*$page - $limit;

// Зашита от отрицательного значения
if($start < 0) $start = 0;

// Запрос выборки данных

$query = "SELECT * FROM cdr ".$where." ORDER BY ".$sidx." ".$sord." LIMIT ".$start.", ".$limit;
//echo $query;
$result = mysql_query($query);

$dic = array(
            'ANSWERED' => 'ОТВЕЧЕНО',
            'NO ANSWER' => 'НЕТ ОТВЕТА',
            'BUSY' => 'ЗАНЯТО',
            'FAILED' => 'ПРЕРВАН',
             );
// Начало xml разметки
$s = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>\n";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";


// Строки данных для таблицы
$i=1;
while($row = mysql_fetch_assoc($result)) {
$disposition=$row[disposition];
$s .= "<row id='".$i."'>";
$s .= "<cell>". $row[calldate]."</cell>";
$s .= "<cell><![CDATA[".$row[clid]."]]></cell>";
$s .= "<cell><![CDATA[".$row[src]."]]></cell>";
$s .= "<cell><![CDATA[".$row[dst]."]]></cell>";
$s .= "<cell><![CDATA[".$row[lastapp]."]]></cell>";
$s .= "<cell><![CDATA[".$row[lastdata]."]]></cell>";
$s .= "<cell>".sec2time($row[billsec])."</cell>";
$s .= "<cell>".$row[start]."</cell>";
$s .= "<cell>".$row[end]."</cell>";
$s .= "<cell><![CDATA[".$dic[$disposition]."]]></cell>";
$s .= "</row>";
$i++;
}
$s .= "</rows>";

header("Content-type: text/xml ;charset=\"utf-8\"");

echo $s;
?>