<?php

namespace Mr4Lc\SelectBirthday;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Lang;

class SelectBirthdayServiceProvider extends ServiceProvider
{

    public $views = __DIR__ . '/../resources/views';

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($views = $this->views) {
            $this->loadViewsFrom($views, 'mr4-lc');
        }

        if ($this->app->runningInConsole() && $views = $this->views) {
            $this->publishes(
                [$views => resource_path('views/vendor/mr4-lc')],
                'mr4-lc-select-birthday'
            );
        }

        // Form macro select2
        Form::macro('selectBirthday', function ($name, $value = null, $options = [], $required = false, $onchange = '') {
            if (array_key_exists('value', $options)) {
                $value = $options['value'];
            } elseif (Form::getValueAttribute($name) !== null) {
                $value = Form::getValueAttribute($name);
            }
            if (is_string($value)) {
                $value = Carbon::createFromFormat('Y-m-d', $value);
            }
            if (!array_key_exists('class-form-group', $options)) {
                $options['class-form-group'] = 'form-group mr4-lc-select-birthday';
            }
            if (!array_key_exists('class-form-control-year', $options)) {
                $options['class-form-control-year'] = 'form-control year';
            }
            if (!array_key_exists('class-form-label-year', $options)) {
                $options['class-form-label-year'] = '';
            }
            if (!array_key_exists('class-form-control-month', $options)) {
                $options['class-form-control-month'] = 'form-control month';
            }
            if (!array_key_exists('class-form-label-month', $options)) {
                $options['class-form-label-month'] = '';
            }
            if (!array_key_exists('class-form-control-day', $options)) {
                $options['class-form-control-day'] = 'form-control day';
            }
            if (!array_key_exists('class-form-label-day', $options)) {
                $options['class-form-label-day'] = '';
            }
            if (!array_key_exists('default-year', $options)) {
                $options['default-year'] = null;
            }
            if (!array_key_exists('default-month', $options)) {
                $options['default-month'] = null;
            }
            if (!array_key_exists('default-day', $options)) {
                $options['default-day'] = null;
            }
            if (!array_key_exists('min', $options)) {
                $options['min'] = Carbon::now()->subYear(200);
            } else if (is_string($options['min'])) {
                $options['min'] = Carbon::createFromFormat('Y-m-d', $options['min']);
            }
            if (!array_key_exists('max', $options)) {
                $options['max'] = Carbon::now();
            } else if (is_string($options['max'])) {
                $options['max'] = Carbon::createFromFormat('Y-m-d', $options['max']);
            }
            if (!array_key_exists('label', $options)) {
                $options['label'] = [];
            }
            if (!array_key_exists('year', $options['label'])) {
                if (Lang::has('admin.year')) {
                    $options['label']['year'] = __('admin.year');
                } else {
                    $options['label']['year'] = 'Year';
                }
            }
            if (!array_key_exists('month', $options['label'])) {
                if (Lang::has('admin.month')) {
                    $options['label']['month'] = __('admin.month');
                } else {
                    $options['label']['month'] = 'Month';
                }
            }
            if (!array_key_exists('day', $options['label'])) {
                if (Lang::has('admin.day')) {
                    $options['label']['day'] = __('admin.day');
                } else {
                    $options['label']['day'] = 'day';
                }
            }
            $options['year'] = [
                null => $options['label']['year'],
            ];
            for ($i = $options['min']->year; $i <= $options['max']->year; $i++) {
                $options['year'][$i] = $i;
            }
            $options['month'] = [
                null => $options['label']['month'],
            ];
            if (isset($value)) {
                if ($value->year === $options['max']->year) {
                    for ($i = 1; $i <= $options['max']->month; $i++) {
                        $options['month'][$i] = $i;
                    }
                } else {
                    for ($i = 1; $i <= 12; $i++) {
                        $options['month'][$i] = $i;
                    }
                }
            } else {
                for ($i = 1; $i <= 12; $i++) {
                    $options['month'][$i] = $i;
                }
            }
            $options['day'] = [
                null => $options['label']['day'],
            ];
            if (isset($value)) {
                if ($value->year === $options['max']->year && $value->month === $options['max']->month) {
                    for ($i = 1; $i <= $options['max']->day; $i++) {
                        $options['day'][$i] = $i;
                    }
                } else {
                    for ($i = 1; $i <= $options['max']->clone()->endOfMonth()->day; $i++) {
                        $options['day'][$i] = $i;
                    }
                }
            } else {
                for ($i = 1; $i <= 31; $i++) {
                    $options['day'][$i] = $i;
                }
            }

            return view('mr4-lc::forms.mr4-lc-select-birthday', [
                'name' => $name,
                'value' => $value,
                'options' => $options,
                'required' => $required,
                'onchange' => $onchange,
            ]);
        });
    }
}
