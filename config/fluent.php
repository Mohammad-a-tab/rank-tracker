<?php

/**
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 *
 * Copyright (c) 2015-2021 Yuuki Takezawa
 */

declare(strict_types=1);

return [

    'host' => env('FLUENTD_HOST', '127.0.0.1'),

    'port' => env('FLUENTD_PORT', 24224),

    /** @see https://github.com/fluent/fluent-logger-php/blob/master/src/FluentLogger.php */
    'options' => [],

    /** @see https://github.com/fluent/fluent-logger-php/blob/master/src/PackerInterface.php */
    // specified class name
    'packer' => null,

    // optionally override Ytake\LaravelFluent\FluentHandler class to customize behaviour
    'handler' => null,

    'processors' => [],

    'tagFormat' => 'rank.api.{{channel}}.{{level_name}}',
];
