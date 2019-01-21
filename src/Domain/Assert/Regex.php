<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 12/18/18
 * Time: 11:00 PM
 */

namespace App\Domain\Assert;


class Regex
{
    const ONLY_LATIN_CHARACTERS = '/^[a-zA-Z]+$/';
    const ONLY_LATIN_CHARACTERS_AND_DIGITS = '/^[a-zA-Z0-9]+$/';
    // [а-яА-Я] Not works properly :(
    const ONLY_RUSSIAN_CHARACTERS = '/^[аАбБвВгГдДеЕёЁжЖзЗиИйЙкКлЛмМнНоОпПрРсСтТуУфФхХцЦчЧшШщЩъЪыЫьЬэЭюЮяЯ]+$/';
}