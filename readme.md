Callback
=========================================
[![Latest Stable Version](https://poser.pugx.org/slexx/callback/v/stable)](https://packagist.org/packages/slexx/callback) [![Total Downloads](https://poser.pugx.org/slexx/callback/downloads)](https://packagist.org/packages/slexx/callback) [![Latest Unstable Version](https://poser.pugx.org/slexx/callback/v/unstable)](https://packagist.org/packages/slexx/callback) [![License](https://poser.pugx.org/slexx/callback/license)](https://packagist.org/packages/slexx/callback)

## Установка

```
$ composer require slexx/callback
```

## Базовое использование

Класс позволяет вызывать методы других классов, для вызого статичного метода используется синтаксис вида `ПространствоИмён\ИмяКласса::имяМетода`, для вызова других `ПространствоИмён\ИмяКласса->имяМетода`. 

```php
use Slexx\Callback\Callback;

$callback1 = new Callback('\NameSpace\ClassName::staticMethod');
$callback2 = new Callback('\NameSpace\ClassName->method');
```

Класс ещё умеет работать с `callable`.

```php
use Slexx\Callback\Callback;

$callback1 = new Callback([$object, 'method']);
$callback2 = new Callback(function($name) {
    return 'Hello, ' . $name . '!';
});
```

Для вызова класса есть несколько методов `invoke` и `invokeArgs` второй принимает массив аргументов.

```php
use Slexx\Callback\Callback;

$callback = new Callback(function($name) {
    return 'Hello, ' . $name . '!';
});

echo $callback->invoke('Alex') . '<br>';
echo $callback->invokeArgs(['Alex']) . '<br>';
echo $callback('Alex');
```

## API
### getClass

**Возвращает:** `mixed|null|string` - Объект класса если в конструктор был переданн массив с объектом, имя класса или `null` в случае отсуцтвия класса.

### getType

**Возвращает:** `null|string` - Вернёт `::` если метод статичный. Если метод не является статичным `->`. В любых других случаях `null`

### getMethod

**Возвращает:** `object|string` - Имя метода или замыкание.

### invokeArgs

Вызывает метод или функцию с передаваемым массивом аргументов.

```php
$callback = new Callback(function($arg1, $arg2) {
    var_dump(func_get_args());
});
$callback->invokeArgs(['arg1', 2]);
```

### invoke

Вызывает метод или функцию.

```php
$callback = new Callback(function($arg1, $arg2) {
    var_dump(func_get_args());
});
$callback->invoke('arg1', 2);
```

### __invoke

Магический метод позволяющий использовать класс как обычное замыкание.

```php
$callback = new Callback(function($arg1, $arg2) {
    var_dump(func_get_args());
});
$callback('arg1', 2);
```
