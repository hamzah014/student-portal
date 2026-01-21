<?php

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

if (! function_exists('generateRandomString')) {
    function generateRandomString($length = 10)
    {
        return strtoupper(substr(bin2hex(random_bytes($length)), 0, $length));
    }
}

if (! function_exists('flash')) {
    function flash(string $message)
    {
        return new class($message) {
            protected array $flash = [];

            public function __construct(private string $message) {}

            protected function add(string $level, string $title = '', bool $important = false)
            {
                $flash = [
                    'level' => $level,
                    'message' => $this->message,
                    'title' => $title,
                    'important' => $important,
                ];

                $existing = session()->get('flash_notification', collect());
                $existing->push($flash);
                session()->put('flash_notification', $existing);

                return $this;
            }

            public function success(string $title = '', bool $important = false)
            {
                return $this->add('success', $title, $important);
            }

            public function error(string $title = '', bool $important = false)
            {
                return $this->add('danger', $title, $important);
            }

            public function warning(string $title = '', bool $important = false)
            {
                return $this->add('warning', $title, $important);
            }

            public function info(string $title = '', bool $important = false)
            {
                return $this->add('info', $title, $important);
            }
        };
    }
}

