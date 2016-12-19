<?php
session_start();
if (!isset($_SESSION['good_admin'])){Header("Location: login.php"); exit;}

//if ($_SERVER["REMOTE_ADDR"] != "10.20.30.37"){echo "����� ����� �� ����";exit;}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<link rel="stylesheet" type="text/css" media="screen" href="css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" mce_href="css/ui.jqgrid.css" />
<style>html, body {
    margin: 0;
    padding: 0;
    font-size: 80%;
    }
</style>
<script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
<script type="text/javascript" src="js/i18n/grid.locale-ru.js"></script>
<script type="text/javascript" src="js/jquery.jqGrid.min.js"></script>
<script type="text/javascript">
$(function(){

$('#le_table').jqGrid({
url:'./statdata.php',
datatype: 'xml',
mtype: 'GET',
colNames:['Дата звонка','Идент', 'Кто звонил','Куда звонил','Приложение','Последние данные','Длительность','Начало звонка','Конец звонка','Статус'],
colModel :[
    {name:'calldate', index:'calldate', width:130},
    {name:'clid', index:'clid', width:135},
    {name:'src', index:'src', width:100},
    {name:'dst', index:'dst', width:100},
    {name:'lastapp', index:'lastapp', width:80},
    {name:'lastdata', index:'lastdata', width:200},
    {name:'billsec', index:'billsec', width:80},
    {name:'start', index:'start', width:130},
    {name:'end', index:'end', width:130},
    {name:'disposition', index:'disposition', width:100}],
    pager: $('#le_tablePager'),
    rowNum:20,
    height: "100%",
    rowList:[10,20,30,100],
    sortname: 'calldate',
    sortorder: 'desc',
    viewrecords: true,
    caption:"Статистика звонков",
    }).navGrid('#le_tablePager',{edit:false,add:false,del:false});

});
</script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Статистика звонков</title></head>
<body><br>
<center><table id="le_table"></table></center>
<div id="le_tablePager"></div>
</body>
</html>