<?php
/**
 * Утилиты для работы с текстом (прежде всего в кодировке utf-8)
 * Функции strlen, mb_strlen без указания кодировки не подходят!
 *   $this->assertEquals(8, strlen('Тест'));
 *   $this->assertEquals(8, mb_strlen('Тест'));
 * Русские буквы в utf-8 занимают по 2 байта, поэтому длина слова Тест якобы 8 символов 
 * А теперь укажем кодировку явно:
 *   $this->assertEquals(4, mb_strlen('Тест', 'utf-8'));
 *
 * Копирование подстроки:
 *   $this->assertEquals('Те', mb_substr('Тест', 0, 2, 'utf-8'));
 */
class String
{
    /**
     * @var string Кодировка для всех операций
     */
    public static $encoding = 'utf-8';

    /**
     * @static Длина строки
     * @param $s string строка
     * @return int Длина строки
     */
    public static function len($s)
    {
        return mb_strlen($s, self::$encoding);
    }

    /**
     * @static Вырезать подстроку
     * @param $s string Исходная строка
     * @param $start int С какого символа
     * @param $len int Длина подстроки
     * @return string Подстрока
     */
    public static function subStr($s, $start, $len)
    {
        return mb_substr($s, $start, $len, self::$encoding);
    }

    /**
     * @static Обрезка длинного текста. Обрезать... по три точки... Чтобы всё влазило...
     * @param $s Исходная строка
     * @param $len До скольки символов уменьшить
     * @return string Обрезанная строка
     */
    public static function trimLen($s, $len)
    {
        // Если текст длинный, то мы его обрезаем до нужной длины и добавляем три точки...
        if (String::len($s) > $len) {
            $more = '...';
            $res = String::subStr($s, 0, $len - String::len($more)) . $more;
            assert(String::len($res) == $len);
            return $res;
        }
        // Короткий текст возвращаем без изменений
        return $s;
    }

}
