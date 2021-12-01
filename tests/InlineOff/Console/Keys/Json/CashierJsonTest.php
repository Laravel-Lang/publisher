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

namespace Tests\InlineOff\Console\Keys\Json;

use Tests\InlineOff\Console\Keys\BaseJsonTestCase;

class CashierJsonTest extends BaseJsonTestCase
{
    protected $items = [
        'All rights reserved.' => 'Все права защищены.',

        'Card' => 'Карта',

        'Confirm Payment'              => 'Подтвердить оплату',
        'Confirm your :amount payment' => 'Подтвердите платёж на сумму :amount',

        'Extra confirmation is needed to process your payment. Please confirm your payment by filling out your payment details below.' =>
            'Необходимо дополнительное подтверждение для обработки Вашего платежа. Пожалуйста, подтвердите Ваш платёж, заполнив платежные реквизиты.',

        'Extra confirmation is needed to process your payment. Please continue to the payment page by clicking on the button below.' =>
            'Необходимо дополнительное подтверждение для обработки Вашего платежа. Пожалуйста, перейдите на страницу оплаты, нажав кнопку ниже.',

        'Full name'            => 'ФИО',
        'Go back'              => 'Назад',
        'Jane Doe'             => 'Иван Иванов',
        'Pay :amount'          => 'Оплатить :amount',
        'Payment Cancelled'    => 'Платёж отменён',
        'Payment Confirmation' => 'Платёж подтверждён',
        'Payment Successful'   => 'Платёж выполнен',

        'Please provide your name.'   => 'Пожалуйста, укажите Ваше имя.',
        'The payment was successful.' => 'Оплата прошла успешно.',

        'This payment was already successfully confirmed.' => 'Платёж уже подтверждён.',

        'This payment was cancelled.' => 'Платёж был отменён.',
    ];
}
