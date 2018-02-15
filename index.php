<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <title>Форма поиска на чистом PHP, в которой есть фильтры и кнопка Найти</title>
</head>
<body>

<?php require __DIR__ . '/handlers.php'; ?>

<?php
libxml_use_internal_errors(true);
$resultTable = '';
$dom = new DomDocument;
$dom->loadHTMLFile(getTypeUrl());
$xpath = new DomXPath($dom);
$selectOption = getTypeRealty($xpath->query('//select[@id="sct2"]/option'), $dom);

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['rooms'])){
	$getRequest = str_replace('/?', '&', clearRequest($_SERVER['REQUEST_URI']));
	$dom->loadHTMLFile(getTypeUrl().$getRequest);
	$xpath = new DomXPath($dom);
	$resultTable = getResult($xpath->query('//div[@class="result"]/table'), $dom);
}
?>
<div class="container">
    <div class="form-search">
        <form action="" method="GET">
            <div class="heading-form">Поиск недвижимости</div>
            <div class="form-block">
                <div class="form-block-heading">Тип недвижимости</div>
                <select name="type">
					<?php
					$array = [
						'dis1'                  => 'жилая',
						'city/flats'            => 'квартиры (вторичка)',
						'city/rooms'            => 'комнаты',
						'city/elite'            => 'элитная недвижимость',
						'city/newflats'         => 'новостройки',
						'dis2'                  => 'загородная',
						'country/houses'        => 'дома',
						'country/cottages'      => 'коттеджи',
						'country/lands'         => 'участки',
						'dis3'                  => 'коммерческая',
						'commerce/offices'      => 'офисы',
						'commerce/comm_new'     => 'помещения в строящихся домах',
						'commerce/service'      => 'помещения в сфере услуг',
						'commerce/different'    => 'помещения различного назначения',
						'commerce/freestanding' => 'отдельно стоящие здания',
						'commerce/storage'      => 'производственно-складские помещения',
						'commerce/comm_lands'   => 'земельные участки'
					];

					echo showOptions($array, 'type');
					?>
                </select>
            </div>
            <div class="form-block">
                <div class="form-block-heading">Цена(рублей)</div>
                <div class="form-block-container">
                    <input class="w-45" name="price[from]" type="text" placeholder="от" value="<?= (isset($_GET['price']['from'])) ? clearRequest($_GET['price']['from']) : '' ?>">
                    <input class="w-45 right" name="price[to]" type="text" placeholder="до" value="<?= (isset($_GET['price']['from'])) ? clearRequest($_GET['price']['to'] ): '' ?>">
                </div>
				<?= primitiveCheckPrice(); ?>
            </div>
            <div class="form-block">
                <div class="form-block-heading">Количество комнат</div>
                <select required size="3" name="rooms[]" multiple>
					<?php
					$arr = [
						'1' => '1 комната',
						'2' => '2 комнаты',
						'3' => '3 комнаты',
						'4' => '4 комнаты',
						'5' => '5 комнат'
					];
					echo getOptionRooms($arr, 'rooms')
					?>
                </select>
            </div>
            <div class="form-block">
                <label class="d-ib" for="only_photo">
                    <input id="only_photo" type="checkbox" name="only_photo" <?= (isset($_GET['only_photo']) && $_GET['only_photo'] == 'on') ? 'checked' : ''; ?>>
                    <span>Только с фото</span>
                </label>
            </div>
            <button type="submit">Найти</button>
        </form>
    </div>
    <div class="result-block">
		<?= $resultTable ?>
    </div>
</div>
</body>
</html>