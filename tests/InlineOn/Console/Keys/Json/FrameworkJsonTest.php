<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\InlineOn\Console\Keys\Json;

use Tests\InlineOn\Console\Keys\BaseJsonTestCase;

class FrameworkJsonTest extends BaseJsonTestCase
{
    protected $items = [
        'All rights reserved.' => 'Все права защищены.',

        'Forbidden' => 'Запрещено',
        'Go Home'   => 'Домой',

        'Go to page :page' => 'Перейти к :page-й странице',

        'Hello!' => 'Здравствуйте!',

        'If you did not create an account, no further action is required.' =>
            'Если Вы не создавали учетную запись, никаких дополнительных действий не требуется.',

        'If you did not request a password reset, no further action is required.' =>
            'Если Вы не запрашивали сброс пароля, то дополнительных действий не требуется.',

        "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser:" =>
            "Если у Вас возникли проблемы с кликом по кнопке \":actionText\", скопируйте и вставьте адрес\nв адресную строку браузера:",

        "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser:" =>
            "Если у Вас возникли проблемы с кликом по кнопке \":actionText\", скопируйте и вставьте адрес\nв адресную строку браузера:",

        'Login'  => 'Войти',
        'Logout' => 'Выйти',

        'Not Found' => 'Не найдено',

        'of'    => 'из',
        'Oh no' => 'О, нет',

        'Page Expired' => 'Страница устарела',

        'Pagination Navigation' => 'Навигация',

        'Please click the button below to verify your email address.' =>
            'Пожалуйста, нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты.',

        'Regards'  => 'С уважением',
        'Register' => 'Регистрация',

        'Reset Password Notification' => 'Уведомление сброса пароля',

        'Reset Password' => 'Сбросить пароль',

        'results' => 'результатов',

        'Server Error'        => 'Ошибка сервера',
        'Service Unavailable' => 'Сервис недоступен',

        'Showing' => 'Показано с',

        'The :attribute must contain at least one letter.' => 'Поле :attribute должно содержать минимум одну букву.',
        'The :attribute must contain at least one number.' => 'Поле :attribute должно содержать минимум одну цифру.',
        'The :attribute must contain at least one symbol.' => 'Поле :attribute должно содержать минимум один спец символ.',

        'The :attribute must contain at least one uppercase and one lowercase letter.' =>
            'Поле :attribute должно содержать как минимум по одному символу в нижнем и верхнем регистрах.',

        'The given :attribute has appeared in a data leak. Please choose a different :attribute.' =>
            'Значение поля :attribute обнаружено в утечке данных. Пожалуйста, укажите другое значение для :attribute.',

        'This action is unauthorized.' =>
            'Неавторизованное действие.',

        'This password reset link will expire in :count minutes.' =>
            'Срок действия ссылки для сброса пароля истекает через :count минут.',

        'to' => 'по',

        'Toggle navigation' => 'Переключить навигацию',
        'Too Many Requests' => 'Слишком много запросов',

        'Unauthorized' => 'Не авторизован',

        'Verify Email Address' => 'Подтвердить email-адрес',

        'Whoops!' => 'Упс!',

        'You are receiving this email because we received a password reset request for your account.' =>
            'Вы получили это письмо, потому что мы получили запрос на сброс пароля для Вашей учетной записи.',
    ];
}
