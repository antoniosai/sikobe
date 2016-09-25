<?php

namespace App\Contracts;

/*
 * This file is part of the Digital Delivery.
 *
 * (c) Sulaeman <sulaeman.nowhere@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface Presentable
{
    /**
     * Return a created presenter.
     *
     * @return \App\Presenter\Presenter
     */
    public function getPresenter();
}